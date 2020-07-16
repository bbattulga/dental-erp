<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Doctor;


class DoctorController extends Controller
{
    //
    public function index(){
         $doctors = Doctor::all();
        return $doctors;
    }

    public function show(Request $request){
        $doctor = Doctor::findOrFail($id);
        return $doctor;
    }

    public function update(Request $request){
        $doctor = Doctor::findOrFail($request['id']);
        $doctor->update($request->all());
        return $doctor;
    }

    public function destroy($id){
        return Doctor::destroy($id);
    }
}
