<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model {

    public $timestamps = true;
    protected $fillable = ['*'];
    // Cast to a "Carbon" DateTime
    protected $casts = [
        'scheduled_date' => 'datetime',
    ];

    /*
     * Relations
     */
    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function hospital() {
        return $this->belongsTo(Hospital::class);
    }
    
    /*
     * Usefull methods
     */
    public static function getTodayAppointments() {
        return Appointment::whereDate('scheduled_date', Carbon::today())->orderBy('scheduled_date', 'asc')->get();
    }

    public function getEndDate() {
        return $this->scheduled_date->addMinutes($this->exam->duration); // End date -> We just add duration to start date
    }

    public function formatDateReadable() {
        return $this->scheduled_date->format('d/m/yy à H:i');
    }
    
    public function isAlreadyPassed() {
        return $this->scheduled_date->isPast();
    }

}
