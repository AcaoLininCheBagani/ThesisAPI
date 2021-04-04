<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

    class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable;

    protected $table = 'dentist_table';
    public $timestamps = false;
    protected $primaryKey = 'dentist_id';

    //protected $guard = 'admin';

    protected $fillable = [
        'dent_fname',
        'dent_lname',
        'dent_address',
        'dent_gender',
        'dent_phone_num',
        'dob',
        'dent_email',
        'password',
        'user_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function getJWTIdentifier() {
        return $this->getKey();
    }

    //
    public function getJWTCustomClaims() {
        return [];
    }
    public function diagnosisDoc(){

        return $this->hasOne(Diagnosis::class, 'dentist_id');

    }

}
