<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient_history extends Model
{
    use HasFactory;

    protected $table = 'patient_medical_history';
    public $timestamps = false;
    //protected $primaryKey = 'patient_med_hist_id';
}
