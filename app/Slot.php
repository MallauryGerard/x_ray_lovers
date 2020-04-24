<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Appointment;
use App\Enums\Urgency;

class Slot extends Model
{
    public $timestamps = false;
    
    protected $guarded = ['*'];
    
    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
    
    public static function firstFreeSlotOfDate(string $date, string $urgency){
        $slots = self::all();
        $nbSlots = 0;
        foreach($slots as $slot){
            if(!Appointment::where(['scheduled_date' => $date, 'slot_id' => $slot->id])->exists()){
                $dateFormat = Carbon::createFromFormat('Y-m-d H:i:s', $date . " " . $slot->start, "Europe/Brussels")->format('d/m/yy à H:i');
                return ['date' => $date, 'slot_id' => $slot->id, 'readableDate' => "Première date libre: le " . $dateFormat];
            }
        }
    } 
}
