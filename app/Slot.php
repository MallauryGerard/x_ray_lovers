<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    public $timestamps = false;
    
    protected $guarded = ['*'];
    
    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
