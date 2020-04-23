@extends('layouts.default')

@section('content')

<h2 class="my-4">Informations du patient</h2>

<p><b>Prénom:</b> {{ $patient->firstname }}</p>
<p><b>Nom de famille:</b> {{ $patient->lastname }}</p>
<p><b>Sexe:</b> {{ $patient->gender }}</p>
<p><b>Date de naissance:</b> {{ $patient->formatDateReadable() . " (" . $patient->getAge() . ")" }}</p>
<p><b>Téléphone:</b> {{ $patient->phone_number }}</p>
@if($patient->email)
<p><b>Email:</b> {{ $patient->email }}</p>
@endif

@if($patient->appointments->first())
<h3 class="my-4">Rendez-vous du patient</h3>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Urgence</th>
            <th scope="col">Type d'examen</th>
            <th scope="col">Hopital de référence</th>
            <th scope="col">Aperçu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patient->appointments as $appointment)
        <tr class="{{ ($appointment->isAlreadyPassed()) ? 'lessOpacity' : '' }}">
            <th scope="row">{{ $appointment->formatDateReadable() }}</th>
            <td><span class="badge badge-primary {{ $appointment->urgency }}">{{ $appointment->urgency }}</span></td>
            <td>{{ $appointment->exam->name }}</td>
            <td>{{ $appointment->hospital->name }}</td>
            <td>
                <a href="{{ route('appointment.show', ['appointment' => $appointment->id]) }}" type="button" class="btn btn-primary btn-sm">
                    <i class="far fa-eye"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection