<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Appointment;

class Patient extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['*'];
    
    // Cast to a "Carbon" DateTime
    protected $casts = [
        'birthdate' => 'datetime',
    ];
    
    /*
     * relations
     */
    public function appointments(){
        return $this->hasMany(Appointment::class)->orderBy('scheduled_date', 'desc');
    }
    
    /*
     * usefull methods
     */
    public function formatDateReadable() {
        return $this->birthdate->format('d/m/y');
    }
    
    public function getAge(){
        $age = Carbon::parse($this->birthdate)->age;
        return ($age > 1) ? $age.' ans' : $age.' an';
    }
}
