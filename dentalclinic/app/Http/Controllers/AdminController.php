<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:admin', ['except' => ['login', 'register']]);
    }

    //login API
    public function login(Request $request){

        $credentials = $request->only('email','password');
        if($token = auth('admin')->attempt($credentials))
        {
            return $this->createNewToken($token);
        }else{
            return response()->json(['status' => 400, 'message' => 'unauthorized']);
        }

        //return $this->createNewToken($token);
    }

   //register API
    public function register(Request $request) {

        $record = new Admin;
        $record->dent_fname = $request->dent_fname;
        $record->dent_lname = $request->dent_lname;
        $record->dent_address= $request->dent_address;
        $record->dent_gender = $request->dent_gender;
        $record->dent_phone_num = $request->dent_phone_num;
        $record->dob = $request->dob;
        $record->email = $request->email;
        $record->password = Hash::make($request->password);
        $record->user_id = '1';

        $record->save();
    }


    //logout API
    public function logout() {
        auth('admin')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    //refresh token API
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

   //get ADMIN profile API
    public function userProfile() {
        return response()->json(auth('admin')->user());



    // // Retrieve the currently authenticated user's ID...
    // $id = Auth::id();
    }
    //get user profile API
    public function userID() {
        return response()->json(Auth::id());
    }
    //token generate
    protected function createNewToken($token){
        return response()->json([
            'status' => 'true',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth('admin')->user()
        ]);
    }

}


