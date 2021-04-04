<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Diagnosis;
use App\Models\Treatment;
use Validator;
use Illuminate\Support\Facades\Hash;


//test to be remove
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function setToken(Request $request){

        Cookie::queue('name','bagani',10);
    }

    public function getToken(){

        $name = $request->cookie('name');
        return $name;
    }

}
