@extends('layouts.default')

@section('content')

<h2>Liste des rendez-vous</h2>
<div id="accordion">
    <div class="card">
        <div class="card-header" id="headingFilter">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#filteringOptions" aria-expanded="false" aria-controls="filteringOptions">
                    <i class="fas fa-filter"></i> Filtrer la liste
                </button>
            </h5>
        </div>
        <div id="filteringOptions" class="collapse bg-light" aria-labelledby="headingFilter" data-parent="#accordion">
            <div class="card-body">
                <form action="{{ route('appointment.index') }}" method="GET">
                    <div class="row my-3">
                        <div class="col-md-6">
                            <label for="scheduled_date">Date du rendez-vous</label>
                            <input type="date" id="scheduled_date" class="form-control" name="scheduled_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <select id="exam_id" class="form-control" name="exam_id">
                                <option value="" selected>Tous les examens</option>
                                @foreach($exams as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <select id="urgency" class="form-control" name="urgency">
                                <option value="" selected>Tous les niveaux d'urgence</option>
                                @foreach($urgencies as $urgency)
                                <option value="{{ $urgency }}">{{ $urgency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <select id="hospital_id" class="form-control" name="hospital_id">
                                <option value="" selected>Tous les hôpitaux</option>
                                @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-rounded my-3">Filtrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Urgence</th>
            <th scope="col">Type d'examen</th>
            <th scope="col">Hopital</th>
            <th scope="col">Nom, prénom</th>
            <th scope="col">Aperçu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($appointments as $appointment)
        <tr class="{{ ($appointment->isAlreadyPassed()) ? 'lessOpacity' : '' }}">
            <td>{{ $appointment->formatDateReadable() }}</td>
            <td><span class="badge badge-primary {{ $appointment->urgency }}">{{ $appointment->urgency }}</span></td>
            <td>{{ $appointment->exam->name }}</td>
            <td>{{ $appointment->hospital->summary }}</td>
            <td><a href="{{ route('patient.show', ['patient' => $appointment->patient->id]) }}">{{ $appointment->patient->lastname . " " . $appointment->patient->firstname }}</a></td>
            <td>
                <a href="{{ route('appointment.show', ['appointment' => $appointment->id]) }}" type="button" class="btn btn-primary btn-sm">
                    <i class="far fa-eye"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="my-2 float-right">
    {{ $appointments->withQueryString()->links() }}
</div>

@endsection