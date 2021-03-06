<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class Patient extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'patient_tables';
    public $timestamps = false;
    protected $primaryKey = 'patient_id';
    //protected $guard = 'patient';

    protected $fillable = [
        'patient_fname',
        'patient_mname',
        'patient_lname',
        'patient_address',
        'patient_gender',
        'email',
        'password',
        'patient_phone_num',
        'dob',
        'user_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

     //
     public function getJWTIdentifier() {
        return $this->getKey();
    }

    //
    public function getJWTCustomClaims() {
        return [];
    }

}
