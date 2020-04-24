@extends('layouts.default')

@section('content')

<h2 class="my-4">Informations du patient</h2>
<table class="table">
    <tr>
        <td>Prénom</td>
        <td>{{ $patient->firstname }}</td>
    </tr>
    <tr>
        <td>Nom de famille</td>
        <td>{{ $patient->lastname }}</td>
    </tr>
    <tr>
        <td>Sexe</td>
        <td>{{ $patient->gender }}</td>
    </tr>
    <tr>
        <td>Date de naissance</td>
        <td>{{ $patient->formatDateReadable() . " (" . $patient->getAge() . ")" }}</td>
    </tr>
    <tr>
        <td>Téléphone</td>
        <td>{{ $patient->phone_number }}</td>
    </tr>
    @if($patient->email)
    <tr>
        <td>Email</td>
        <td>{{ $patient->email }}</td>
    </tr>
    @endif
</table>

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
            <td>{{ $appointment->formatDateReadable() }}</td>
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