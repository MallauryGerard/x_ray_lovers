<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public $timestamps = true;
    
    protected $fillable = ['*'];
    
    /*
     * Relations
     */
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function exam(){
        return $this->belongsTo(Exam::class);
    }
    public function hospital(){
        return $this->belongsTo(Hospital::class);
    }
}
