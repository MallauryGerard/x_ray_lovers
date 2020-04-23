<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Enums\Gender;
use Illuminate\Validation\Rule;
use DateTime;

class PatientController extends Controller {

    public function show(Patient $patient) {
        return view('patient.show', ['patient' => $patient]);
    }
    
    public function create() {
        return view('patient.create');
    }

    public function store(Request $request) {
        $request->validate([
            'firstname' => ['required', 'max:150', 'min:2', 'alpha'],
            'lastname' => ['required', 'max:255', 'min:2', 'alpha'],
            'birthdate' => ['required', 'date'],
            'gender' => Rule::in(Gender::$allGenders),
            'phone_number' => ['required', 'numeric', 'unique:patients,phone_number'],
            'email' => ['nullable', 'email', 'unique:patients,email']
        ]);

        if ($this->doesPatientExist($request->firstname, $request->lastname, $request->birthdate)) {
            session()->flash('error', 'Le patient existe déjà');
            return redirect()->back();
        }

        // Test si le patient existe déjà

        $patient = new Patient();
        $patient->firstname = $request->firstname;
        $patient->lastname = $request->lastname;
        $patient->birthdate = $request->birthdate;
        $patient->gender = $request->gender;
        $patient->phone_number = $request->phone_number;
        $patient->email = $request->email;
        $patient->save();

        session()->flash('success', 'Patient ajouté avec succès');
        return redirect()->route('patient.show', ['patient' => $patient->id]);
    }

    private function doesPatientExist(string $firstname, string $lastname, string $birthdate) {
        $birthdate = new DateTime($birthdate);
        return Patient::where([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'birthdate' => $birthdate->format('y-m-d')
                ])->exists();
    }

    public function fetchLastname(Request $request) {
        if (!$request->ajax()) {
            abort(404);
        }
        $birthdate = $request->get('value');
        $lastnames = Patient::where('birthdate', $birthdate)->orderBy('lastname')->distinct()->get(['lastname']);
        if ($lastnames->first()) {
            $output = '<option value="" disabled selected>Nom de famille du patient</option>';
            foreach ($lastnames as $lastname) {
                $output .= '<option value="' . $lastname->lastname . '">' . $lastname->lastname . '</option>';
            }
        } else {
            $output = '<option value="" disabled selected>Aucun patient n\'est enregistré avec cette date de naissance</option>';
        }
        echo $output;
    }

    public function fetchFirstname(Request $request) {
        if (!$request->ajax()) {
            abort(404);
        }
        $lastname = $request->get('value');
        $firstnames = Patient::where('lastname', $lastname)->orderBy('firstname')->distinct()->get(['firstname']);
        $output = '<option value="" disabled selected>Prénom du patient</option>';
        foreach ($firstnames as $firstname) {
            $output .= '<option value="' . $firstname->firstname . '">' . $firstname->firstname . '</option>';
        }
        echo $output;
    }

}
