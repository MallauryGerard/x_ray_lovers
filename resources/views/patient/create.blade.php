@extends('layouts.default')

@section('content')

<h2>Ajouter un patient</h2>
<form action="{{ route('patient.store') }}" method="POST">
    @csrf
    <p class="text-danger"><i>* Champs obligatoires</i></p>
    <div class="row">
        <div class="col-lg-5">
            <label for="firstname">Prénom: <span class="text-danger"> *</span></label>
            <input type="text" id="firstname" class="form-control @error('firstname') is-invalid @enderror" name="firstname" pattern="(.){2,150}" 
                   value="{{ old('firstname') }}" required>
            @error('firstname')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-lg-5">
            <label for="lastname">Nom de famille: <span class="text-danger"> *</span></label>
            <input type="text" id="lastname" class="form-control @error('lastname') is-invalid @enderror" name="lastname" pattern="(.){2,150}" 
                   value="{{ old('lastname') }}" required>
            @error('lastname')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class='col-lg-2'>
            <label for="birthdate">Naissance: <span class="text-danger"> *</span></label>
            <input class="form-control form-control @error('birthdate') is-invalid @enderror" type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
            @error('birthdate')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-lg-2">
            <label for="gender">Genre: <span class="text-danger"> *</span></label>
            <select class="form-control form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
                <option value="autre">Autre</option>
            </select>
            @error('gender')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class='col-lg-5'>
            <label for="phone_number">Numéro de téléphone: <span class="text-danger"> *</span></label>
            <input class="form-control form-control @error('phone_number') is-invalid @enderror" type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
            @error('phone_number')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class='col-lg-5'>
            <label for="email">Adresse email:</label>
            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-rounded waves-effect mt-5 float-right">Ajouter</button>
</form>

@endsection