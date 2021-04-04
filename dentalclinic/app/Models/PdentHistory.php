<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdentHistory extends Model
{
    use HasFactory;
    protected $table = 'patient_dent_history';
    public $timestamps = false;
}
