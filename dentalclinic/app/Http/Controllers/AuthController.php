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

class AuthController extends Controller
{

    //limit and pag gamit sa middleware
    public function __construct() {
        $this->middleware('auth:patient', ['except' => ['login', 'register',]]);
    }

    //LOGIN USER
    public function login(Request $request){

        $credentials = $request->only('email','password');
        if(!$token = auth('patient')->attempt($credentials))
        {
            return response()->json(['error' => 'Unauthorized'], 401);

        }

       return $this->createNewToken($token);
    }


    //TEST get patient medical history table info one to one relation
    public function findCon(){
        $loginUsersID = Auth::id();
        $patient = Patient::find($loginUsersID)->patientHistory;


        if($patient == ''){
            return 'hey you no record!';
        }else{
        return $patient;//->patientHistory->pmed_condition;
        }
    }
    public function findDiag(){

       // $diagnosisFind = Auth::id();
        $users = DB::table('patient_tables')->get();
        return $users;
    }



    //LOGOUT USER
    public function logout() {

        auth('patient')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    //REFRESH TOKEN

    public function refresh() {
        return $this->createNewToken(auth('patient')->refresh());
    }

    //GET USER INFORMATION
    public function userProfile() {
        return response()->json(Auth::user());
    }

    //GENERATE TOKEN
    protected function createNewToken($token){

        return response()->json([

            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth('patient')->user()
        ]);
    }



}
