<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign(['exam_id'], 'fk_appointments_exam_id')->references(['id'])->on('exams')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['hospital_id'], 'fk_appointments_hospital_id')->references(['id'])->on('hospitals')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['patient_id'], 'fk_appointments_patient_id')->references(['id'])->on('patients')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['slot_id'], 'fk_appointments_slot_id')->references(['id'])->on('slots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign('fk_appointments_exam_id');
            $table->dropForeign('fk_appointments_hospital_id');
            $table->dropForeign('fk_appointments_patient_id');
            $table->dropForeign('fk_appointments_slot_id');
        });
    }
}
