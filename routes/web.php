<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('appointment.index'));
});

// Ajax
Route::get('/fetchLastname', 'PatientController@fetchLastname')->name('fetchLastname');
Route::get('/fetchFirstname', 'PatientController@fetchFirstname')->name('fetchFirstname');
Route::get('/ajaxPatientAlreadyExist', 'PatientController@ajaxPatientAlreadyExist')
        ->name('ajaxPatientAlreadyExist');
Route::get('/ajaxFindAFreeSlot', 'AppointmentController@ajaxFindAFreeSlot');


// Appointments
Route::get('/appointments', 'AppointmentController@index')->name('appointment.index');
Route::get('/appointments/create', 'AppointmentController@create')->name('appointment.create');
Route::get('/appointments/{appointment}', 'AppointmentController@show')->name('appointment.show');
Route::delete('/appointments/{appointment}', 'AppointmentController@destroy')->name('appointment.destroy');
Route::post('/appointments', 'AppointmentController@store')->name('appointment.store');

// Patients
Route::get('/patients/create', 'PatientController@create')->name('patient.create');
Route::post('/patients', 'PatientController@store')->name('patient.store');
Route::get('/patients/{patient}', 'PatientController@show')->name('patient.show');
