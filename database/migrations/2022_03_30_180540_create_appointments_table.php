<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('scheduled_date');
            $table->enum('urgency', ['faible', 'modérée', 'élevée']);
            $table->text('comment')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->unsignedTinyInteger('exam_id')->index('fk_appointments_exam_id');
            $table->unsignedInteger('patient_id')->index('fk_appointments_patient_id');
            $table->unsignedTinyInteger('hospital_id')->index('fk_appointments_hospital_id');
            $table->unsignedInteger('slot_id')->index('fk_appointments_slot_id');

            $table->unique(['scheduled_date', 'slot_id'], 'scheduled_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
