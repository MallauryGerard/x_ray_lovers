<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Appointment;
use App\Exam;
use App\Patient;
use App\Enums\Urgency;
use Carbon\Carbon;
use App\Slot;
use App\Hospital;

class AppointmentController extends Controller {
    
    const NB_FREE_SECURITY_SLOT_FOR_LOW_URGENCY = 50;
    const NB_FREE_SECURITY_SLOT_FOR_MEDIUM_URGENCY = 15;
    const MAX_DELAY_FOR_AN_APPOINTMENT = 300;

    public function index() {
        return view('appointment.index', [
            'appointments' => $this->databaseToCalendarJson(Appointment::all())
        ]);
    }

    public function show(Appointment $appointment) {
        return view('appointment.show', [
            'appointment' => $appointment
        ]);
    }

    public function create() {
        return view('appointment.create', [
            'exams' => Exam::all(), 'urgencies' => Urgency::$allUrgencies,
            'hospitals' => Hospital::all()
        ]);
    }
    
    public function store(Request $request) {
        $request->validate([
            'firstname' => ['required', 'max:150', 'min:2', 'alpha', 'exists:patients,firstname'],
            'lastname' => ['required', 'max:255', 'min:2', 'alpha', 'exists:patients,lastname'],
            'birthdate' => ['required', 'date', 'exists:patients,birthdate'],
            'exam' => ['required', 'exists:exams,id'],
            'urgency' => ['required'],
            'hospital' => ['required', 'exists:hospitals,id'],
            'slot' => ['required', 'exists:slots,id'],
            'date' => ['required', 'date'],
        ]);
        
        $patient = Patient::where([
            'firstname' => $request->firstname, 
            'lastname' => $request->lastname, 
            'birthdate' => $request->birthdate, 
            ])->first();
        
        $appointment = new Appointment();
        $appointment->scheduled_date = $request->date;
        $appointment->urgency = $request->urgency;
        $appointment->comment = $request->comment;
        $appointment->exam_id = $request->exam;
        $appointment->patient_id = $patient->id;
        $appointment->hospital_id = $request->hospital;
        $appointment->slot_id = $request->slot;
        $appointment->save();
        
        session()->flash('success', 'Rendez-vous ajouté avec succès');
        return redirect()->route('appointment.show', ['appointment' => $appointment->id]);
    }

    public function destroy(Appointment $appointment) {
        $appointment->delete();
        session()->flash('success', 'Rendez-vous supprimé avec succès');
        return redirect()->route('appointment.index');
    }

    private function databaseToCalendarJson(Collection $appointments) {
        $dataCalendar = [];
        $cpt = 0;
        foreach ($appointments as $appointment) {
            $dataCalendar[$cpt]["title"] = $appointment->exam->name . ' - ' . $appointment->hospital->summary;
            $dataCalendar[$cpt]["start"] = $appointment->getStartDatetime();
            $dataCalendar[$cpt]["end"] = $appointment->getEndDatetime();
            $dataCalendar[$cpt]["url"] = route('appointment.show', ['appointment' => $appointment->id]);
            $dataCalendar[$cpt]["classNames"] = $appointment->urgency;
            $dataCalendar[$cpt]["description"] = $appointment->comment . " " .
                    "(" . $appointment->exam->name . " pour le " . $appointment->hospital->summary . " - " .
                    $appointment->patient->firstname . " " . $appointment->patient->lastname . ")";
            $cpt++;
        }
        return json_encode($dataCalendar);
    }
    
    public function ajaxFindAFreeSlot(Request $request) {
        if (!$request->ajax() || !in_array($request->urgency, Urgency::$allUrgencies)) {
            abort(404);
        }
        $urgency = $request->urgency;
        $freeSlot = null;
        $count = 1;
        $nbSecuritySlots = 0;
        $found = false;
        while($count < self::MAX_DELAY_FOR_AN_APPOINTMENT && !$found){
            if($request->currentDate){ // if currentDate is not null -> the user asked for a new date
                $currentDate = Carbon::createFromFormat('Y-m-d', $request->currentDate);
            }else{
                $currentDate = Carbon::today();
            }
            $date = $currentDate->addDay($count);
            if(!$date->isSunday() && !$date->isSaturday()){ // Dodge non-working day
                $freeSlot = Slot::firstFreeSlotOfDate($date->format('Y-m-d'), $urgency);
            }
            if($freeSlot){
                $nbSecuritySlots++;
                if($request->currentDate || $urgency == Urgency::Hight ||
                   ($urgency == Urgency::Medium && $nbSecuritySlots >= self::NB_FREE_SECURITY_SLOT_FOR_MEDIUM_URGENCY) ||
                    ($urgency == Urgency::Low && $nbSecuritySlots >= self::NB_FREE_SECURITY_SLOT_FOR_LOW_URGENCY)){
                    echo '<div class="alert alert-success" role="alert">'.$freeSlot['readableDate'].'. '
                            . '<br><i>Cette date ne convient pas ?</i> '
                            . '<button type="button" class="btn btn-sm btn-primary" id="newDate">Trouver une date ultérieure</button></div>';
                    echo '<input id="slot" name="slot" type="hidden" value="'.$freeSlot['slot_id'].'">';
                    echo '<input id="date" name="date" type="hidden" value="'.$freeSlot['date'].'">';
                    $found = true;
                }
            }
            $count++;
        }
        if($count >= self::MAX_DELAY_FOR_AN_APPOINTMENT){
            echo '<div class="alert alert-danger" role="alert">Désolé, aucune disponibilité n\'a été trouvée.</div>';
        }
    }
}
