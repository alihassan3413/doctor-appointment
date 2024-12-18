<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'specialization', 
        'bio', 
        'clinic_address', 
        'start_time', 
        'end_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function leaves()
    {
        return $this->hasMany(DoctorLeave::class);
    }

}
