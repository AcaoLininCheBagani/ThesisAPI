<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $table = 'treatment_type';
    public $timestamps = false;
    // public function treatmen(){

    //     return $this->hasOne(Diagnosis::class, 't_type_id');
    // }
}
