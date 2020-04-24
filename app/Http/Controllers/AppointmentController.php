<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Appointment;

class AppointmentController extends Controller
{
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
        return view('appointment.create');
    }
    
    public function destroy(Appointment $appointment) {
        $appointment->delete();
        session()->flash('success', 'Rendez-vous supprimé avec succès');
        return redirect()->route('appointment.index');
    }
    
    private function databaseToCalendarJson(Collection $appointments){
        $dataCalendar = [];
        $cpt = 0;
        foreach($appointments as $appointment){
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
