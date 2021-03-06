<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:patient', ['except' => ['login', 'register']]);
    }

    //LOGIN USER
    public function login(Request $request){

        $credentials = $request->only('email','password');
        if($token = auth('patient')->attempt($credentials))
        {
            return $this->createNewToken($token);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }

    //REGISTER DENTIST
    public function register(Request $request) {

        $record = new Patient;
        $record->patient_fname = $request->patient_fname;
        $record->patient_mname = $request->patient_mname;
        $record->patient_lname = $request->patient_lname;
        $record->patient_address= $request->patient_address;
        $record->patient_gender = $request->patient_gender;
        $record->email = $request->email;
        $record->password = Hash::make($request->password);
        $record->patient_phone_num = $request->patient_phone_num;
        $record->dob = $request->dob;
        $record->user_id = $request->user_id;

        $record->save();

    }


    //LOGOUT USER
    public function logout() {
        auth('patient')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    //REFRESH TOKEN

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
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
