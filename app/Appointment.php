<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model {

    public $timestamps = true;
    protected $fillable = ['*'];

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
    
    public function slot(){
        return $this->belongsTo(Slot::class);
    }
    
    /*
     * Usefull methods
     */
    public function getStartDatetime(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->scheduled_date . " " . $this->slot->start, "Europe/Brussels");
    }

    public function getEndDatetime() {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->scheduled_date . " " . $this->slot->end, "Europe/Brussels");
    }

    public function formatDateReadable() {
        return $this->getStartDatetime()->format('d/m/yy à H:i');
    }
    
    public function isAlreadyPassed() {
        return $this->getEndDatetime()->isPast();
    }

}
