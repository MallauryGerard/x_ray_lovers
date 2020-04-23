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
<p><b>Urgence:</b> <span class="badge badge-primary {{ $appointment->urgency }}">{{ $appointment->urgency }}</span></p>
<p><b>Type:</b> {{ $appointment->exam->name }}</p>
<p><b>Hopital:</b> {{ $appointment->hospital->name . ' (' . $appointment->hospital->summary . ')' }}</p>
<p>
    <b>Patient:</b> 
    <a href="{{ route('patient.show', ['patient' => $appointment->patient]) }}">
        {{ $appointment->patient->firstname . ' ' . $appointment->patient->lastname }}
    </a>
</p>
@if($appointment->comment)
<p class="card-text"><b>Commentaire:</b> {{ $appointment->comment }}</p>
@endif
<button class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteAppointment">
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