<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use eloquentFilter\QueryFilter\ModelFilters\ModelFilters;
use App\{Appointment, Exam, Patient, Slot, Hospital};
use App\Enums\Urgency;
use Carbon\Carbon;

class AppointmentController extends Controller {

    const NB_FREE_SECURITY_SLOT_FOR_LOW_URGENCY = 50;
    const NB_FREE_SECURITY_SLOT_FOR_MEDIUM_URGENCY = 15;
    const MAX_DELAY_FOR_AN_APPOINTMENT = 300;

    /**
     * @param \eloquentFilter\QueryFilter\ModelFilters\ModelFilters $modelFilters
     */
    public function index(Request $request, ModelFilters $modelFilters) {
        if (!empty($modelFilters->filters())) {
            $appointments = Appointment::filter($modelFilters)->with('patient')->orderBy('scheduled_date', 'desc')->paginate(15, ['*'], 'page');
        } else {
            $appointments = Appointment::with('patient')->orderBy('scheduled_date', 'desc')->paginate(15);
        }
        return view('appointment.index', [
            'appointments' => $appointments, 'exams' => Exam::all(), 
            'urgencies' => Urgency::$allUrgencies,
            'hospitals' => Hospital::all()
        ]);
    }

    public function indexAgenda() {
        return view('appointment.indexAgenda', [
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

        session()->flash('success', 'Rendez-vous ajout?? avec succ??s');
        return redirect()->route('appointment.show', ['appointment' => $appointment->id]);
    }

    public function destroy(Appointment $appointment) {
        $appointment->delete();
        session()->flash('success', 'Rendez-vous supprim?? avec succ??s');
        return redirect()->route('appointment.indexAgenda');
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
        while ($count < self::MAX_DELAY_FOR_AN_APPOINTMENT && !$found) {
            if ($request->currentDate) { // if currentDate is not null -> the user asked for a new date
                $currentDate = Carbon::createFromFormat('Y-m-d', $request->currentDate);
            } else {
                $currentDate = Carbon::today();
            }
            $date = $currentDate->addDay($count);
            if (!$date->isSunday() && !$date->isSaturday()) { // Dodge non-working day
                $freeSlot = Slot::firstFreeSlotOfDate($date->format('Y-m-d'), $urgency);
            }
            if ($freeSlot) {
                $nbSecuritySlots++;
                if ($request->currentDate || $urgency == Urgency::Hight ||
                        ($urgency == Urgency::Medium && $nbSecuritySlots >= self::NB_FREE_SECURITY_SLOT_FOR_MEDIUM_URGENCY) ||
                        ($urgency == Urgency::Low && $nbSecuritySlots >= self::NB_FREE_SECURITY_SLOT_FOR_LOW_URGENCY)) {
                    echo '<div class="alert alert-success" role="alert">' . $freeSlot['readableDate'] . '. '
                    . '<br><i>Cette date ne convient pas ?</i> '
                    . '<button type="button" class="btn btn-sm btn-primary" id="newDate">Trouver une date ult??rieure</button></div>';
                    echo '<input id="slot" name="slot" type="hidden" value="' . $freeSlot['slot_id'] . '">';
                    echo '<input id="date" name="date" type="hidden" value="' . $freeSlot['date'] . '">';
                    $found = true;
                }
            }
            $count++;
        }
        if ($count >= self::MAX_DELAY_FOR_AN_APPOINTMENT) {
            echo '<div class="alert alert-danger" role="alert">D??sol??, aucune disponibilit?? n\'a ??t?? trouv??e.</div>';
        }
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

}
