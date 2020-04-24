@extends('layouts.default')

@section('content')

<h2>
    Rendez-vous du {{ $appointment->formatDateReadable() }}
    @if($appointment->isAlreadyPassed())
    <span class="badge badge-secondary">
        Déjà passé
    </span>
    @endif
</h2>
<table class="table informations">
    <tr>
        <td>Urgence</td>
        <td>
            <span class="badge badge-primary {{ $appointment->urgency }}">{{ $appointment->urgency }}</span>
        </td>
    </tr>
    <tr>
        <td>Type</td>
        <td>{{ $appointment->exam->name }}</td>
    </tr>
    <tr>
        <td>Hopital</td>
        <td>{{ $appointment->hospital->name . ' (' . $appointment->hospital->summary . ')' }}</td>
    </tr>
    <tr>
        <td>Patient</td>
        <td>
            <a href="{{ route('patient.show', ['patient' => $appointment->patient]) }}">
                {{ $appointment->patient->firstname . ' ' . $appointment->patient->lastname }}
            </a>
        </td>
    </tr>
    @if($appointment->comment)
    <tr>
        <td>Commentaire</td>
        <td>
            {{ $appointment->comment }}
        </td>
    </tr>
    @endif
</table>
<button class="btn-sm btn-danger float-right" data-toggle="modal" data-target="#deleteAppointment">
    Supprimer
</button>

<!-- Modal -->
<div class="modal fade" id="deleteAppointment" tabindex="-1" role="dialog" aria-labelledby="deleteAppointment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="{{ route('appointment.destroy', ['appointment' => $appointment->id]) }}">
                    @method('delete')
                    @csrf
                    <p>Confirmer la suppression de ce rendez-vous ?</p>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Confirmer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">Annuler</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection