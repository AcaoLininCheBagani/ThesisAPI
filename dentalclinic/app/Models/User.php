<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'dentist_table';
    public $timestamps = false;
    protected $primaryKey = 'dentist_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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