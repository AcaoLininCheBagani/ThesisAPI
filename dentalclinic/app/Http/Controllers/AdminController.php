<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Patient;
use App\Models\Diagnosis;
use App\Models\Treatment;
use App\Models\PdentHistory;
use App\Models\Patient_history;
use App\Models\Ptooth;
use Validator;
use Illuminate\Support\Facades\Hash;

//test to be remove
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin', ['except' => ['login', 'register','registerAdmin']]);
    }

    //login API
    public function login(Request $request){

        $credentials = $request->only('email','password');
        if(!$token = auth('admin')->attempt($credentials))
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);

    }

   //register DENTIST
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
     //REGISTER USER
     public function storeUser(Request $request) {

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
        $record->user_id = '1';
        $record->save();
        $id = DB::getPdo()->lastInsertId();

        $history = new Patient_history;
        $history->pmed_condition = $request->pmed_condition;
        $history->health_status = $request->health_status;
        $history->patient_id = $id;
        $history->save();

        return $id;

    }
    //UPDATE PATIENT INFORMATION
    public function updatePatient(Request $request,$id){
        try{
            $record = Patient::findOrFail($id);
            $record->patient_address= $request->patient_address;
            $record->patient_gender = $request->patient_gender;
            $record->email = $request->email;
            $record->patient_phone_num = $request->patient_phone_num;
            $record->dob = $request->dob;
            $record->save();

            return response()->json(['status' => 200, 'message' => 'Successfully updated!']);
        }catch(\Exception $e){
            return response()->json(['status' => false]);
        }

    }
    //DELETE PATIENT/USER
    // public function deleteUser($id){

    //         $record = Patient::findOrFail($id);
    //         $record->delete();
    //         //return response()->json(['status' => true, 'message' =>'Successfully deleted!']);

    // }

    //SEARCH
    public function search($name){
        $getUser = DB::table('patient_tables')
        ->select('patient_id', DB::raw("CONCAT(patient_fname,' ', patient_mname,' ', patient_lname) as Name"),
        DB::raw("TIMESTAMPDIFF(YEAR, DATE(dob), current_date) AS age"),'patient_address','patient_phone_num','patient_gender')
        ->where('patient_lname', 'like', "%".$name."%")
        ->get();
        return $getUser;
    }
    //SEARCH FOR ID
    public function searchID($id){
        $getInfo = DB::table('patient_tables')
        ->join('diagnosis_table','patient_tables.patient_id','=','diagnosis_table.patient_id')
        ->join('treatment_type','diagnosis_table.diagnosis_id','=','treatment_type.diagnosis_id')
        ->join('patient_tooth','treatment_type.t_type_id','=','patient_tooth.treatment_id')
        ->select('t_type_name','t_category','t_styles','ptooth_name','ptooth_location')
        ->where('patient_tables.patient_id','=',$id)
        ->get();

        return $getInfo;
    }
    //view
    public function viewPatient(){
        $users = DB::table('patient_tables')
        ->select('patient_id', DB::raw("CONCAT(patient_fname,' ', patient_mname,' ', patient_lname) as Name"),'dob',
        DB::raw("TIMESTAMPDIFF(YEAR, DATE(dob), current_date) AS age"),'patient_gender','email','patient_phone_num','patient_address')
        ->get();
        return $users;
    }

    //VIEW PATIENT TABLE AND PMEDHISTROY TABLE
    public function patientMedicalHistory(){
        $users = DB::table('patient_tables')
        ->join('patient_medical_history','patient_medical_history.patient_id','=','patient_tables.patient_id')
        ->select( DB::raw("CONCAT(patient_fname,' ', patient_mname,' ', patient_lname) as Name"),'dob',
        DB::raw("TIMESTAMPDIFF(YEAR, DATE(dob), current_date) AS age"),'patient_gender','email','patient_phone_num','patient_address','pmed_condition','health_status')
        ->get();
        return $users;
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
        $user = DB::table('dentist_table')
        ->select('dentist_id', DB::raw("CONCAT(dent_fname,' ', dent_lname) as Name"))
        ->get();
        return $user;
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
    //test REGISTER ADMIN
    public function registerAdmin(Request $request){

        $record = new Admin;
        $record->dent_fname = $request->dent_fname;
        $record->dent_lname = $request->dent_lname;
        $record->dent_address= $request->dent_address;
        $record->dent_gender = $request->dent_gender;
        $record->dent_phone_num = $request->dent_phone_num;
        $record->dob = $request->dob;
        $record->email = $request->email;
        $record->password = Hash::make($request->password);
        $record->user_id = '2';

        $record->save();
    }

     //DIAGNOSIS API
     public function diagnosis(Request $request) {

        $record = new Diagnosis;
        $record->patient_id = $request->patient_id;
        $record->dentist_id = $request->dentist_id;
        $record->category= $request->category;
        $record->style = $request->style;
        $record->findings = $request->findings;
        $record->save();
        $id = DB::getPdo()->lastInsertId();

        $dentH = new PdentHistory;
        $dentH->diagnosis_id = $id;
        $dentH->save();

        $treat = new Treatment;
        $treat->t_type_name =$request->t_type_name;
        $treat->t_category = $request->t_category;
        $treat->t_styles = $request->t_styles;
        $treat->diagnosis_id = $id;
        $treat->save();
        $tID = DB::getPdo()->lastInsertId();

        $ptooth = new Ptooth;
        $ptooth->ptooth_name = $request->ptooth_name;
        $ptooth->ptooth_location = $request->ptooth_location;
        $ptooth->treatment_id = $tID;
        $ptooth->save();

        return  response()->json(['status' => 'success'], 200);
    }
}


