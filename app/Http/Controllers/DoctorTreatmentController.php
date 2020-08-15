<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\UserRole;
use App\Transaction;
use App\Treatment;
use App\TreatmentSelections;
use App\TreatmentCategory;
use App\User;
use App\UserTreatments;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Roles;
use App\ToothType;
use App\UserTooth;
use App\CheckInState;
use App\Symptom;
use App\TreatmentNote;
use Illuminate\Support\Facades\Storage;


class DoctorTreatmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('doctor');
    }
    //
    public function index($checkin_id) {
        $checkin = CheckIn::with('user')->where('id', $checkin_id)->first();
        if($checkin->state <= 1) {
            $checkin_all = CheckIn::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
            $category = 1;
            $treatments = Treatment::where('category', $category)->get();
            $treatmentCategories = TreatmentCategory::all();
            $user_treatments = UserTreatments::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
            $nurses = User::where('role_id', Roles::nurse()->id)->get();
            $tooth_types = ToothType::all();
            $user_tooths = UserTooth::with('tooth_type', 'tooth')
                            ->where('user_id', $checkin->user_id)
                            ->get();

            // udpate checkin state
            $checkin->update([
                'state' => CheckInState::treatment_started()
            ]);

            $symptoms = Symptom::where('user_id', $checkin->user_id)->get();
            return view('doctor.treatment2',
                    compact('checkin'));
        } else {
            return redirect('404');
        }
    }
    public function gajig($checkin_id) {
        $checkin = CheckIn::find($checkin_id);
        if($checkin->state == 0) {
            $checkin_all = CheckIn::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
            $category = 2;
            $treatments = Treatment::where('category', $category)->get();
            $user_treatments = UserTreatments::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
            $nurses = UserRole::where('role_id', Roles::nurse()->id)->get();
            return view('doctor.treatment',compact('checkin', 'treatments','user_treatments', 'checkin_all', 'nurses', 'category'));
        } else {
            return redirect('404');
        }
    }
    public function sogog($checkin_id) {
        $checkin = CheckIn::find($checkin_id);
        if($checkin->state == 0) {
            $checkin_all = CheckIn::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
            $category = 3;
            $treatments = Treatment::where('category', $category)->get();
            $user_treatments = UserTreatments::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
            $nurses = UserRole::where('role_id', Roles::nurse()->id)->get();
            return view('doctor.treatment',compact('checkin', 'treatments','user_treatments', 'checkin_all', 'nurses', 'category'));
        } else {
            return redirect('404');
        }
    }
    public function mes($checkin_id) {
        $checkin = CheckIn::find($checkin_id);
        if($checkin->state == 0) {
            $checkin_all = CheckIn::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
            $category = 4;
            $treatments = Treatment::where('category', $category)->get();
            $user_treatments = UserTreatments::where('user_id', $checkin->user_id)->orderBy('id', 'DESC')->get();
            $nurses = UserRole::where('role_id', Roles::nurse()->id)->get();
            
            return view('doctor.treatment',compact('checkin', 'treatments','user_treatments', 'checkin_all', 'nurses', 'category'));
        } else {
            return redirect('404');
        }
    }
    public function store(Request $request) {
        $checkin = CheckIn::find($request['checkin_id']);
        if(empty($request['treatment_selection_id']) || $request['treatment_selection_id']==null || $request['treatment_selection_id']==0){
            if(empty($request['price'])) {
                $price = Treatment::find($request['treatment_id'])->price;
            } else {
                $price = $request['price'];
            }

            $user_treatment = UserTreatments::create(['checkin_id'=>$request['checkin_id'],'treatment_id'=>$request['treatment_id'],'treatment_selection_id'=>0,'tooth_id'=>$request['tooth_id'],'value'=>$request['value_id'], 'user_id'=>$checkin->user_id, 'price'=>$price,
                'description'=>$request['description'],
                'tooth_type_id'=>$request['tooth_type_id'],
                'decay_level'=>$request['decay_level']
            ]);

            if (!empty($request['symptom'] || !empty($request['diagnosis']))){
                $note = TreatmentNote::create([
                    'checkin_id'=>$checkin->id,
                    'user_treatment_id'=>$user_treatment->id,
                    'symptom'=>$request['symptom'],
                    'diagnosis'=>$request['diagnosis']
                ]);
            }
        } else {
            if(empty($request['price'])) {
                $price = TreatmentSelections::find($request['treatment_selection_id'])->price;
            } else {
                $price = $request['price'];
            }
            $user_treatment = UserTreatments::create(['checkin_id'=>$request['checkin_id'],'treatment_id'=>$request['treatment_id'],'treatment_selection_id'=>$request['treatment_selection_id'],'tooth_id'=>$request['tooth_id'],'value'=>$request['value_id'], 'user_id'=>$checkin->user_id, 'price'=>$price,
                'description'=>$request['description'],
                'tooth_type_id'=>$request['tooth_type_id'],
                'decay_level'=>$request['decay_level']
            ]);
            if (!empty($request['symptom'] && !empty($request['diagnosis']))){
                $note = TreatmentNote::create([
                    'checkin_id'=>$checkin->id,
                    'user_treatment_id'=>$user_treatment->id,
                    'symptom'=>$request['symptom'],
                    'diagnosis'=>$request['diagnosis']
                ]);
            }
        }
        return back()->with('last_treatment', 1);
    }
    public function finish(Request $request) {
        $checkin = CheckIn::find($request['checkin_id']);
        $checkin->nurse_id = $request['nurse_id'];
        $checkin->state = 2;
        $checkin->save();
        return redirect('doctor');
    }
    public function delete_history($id) {
        UserTreatments::find($id)->delete();
        return redirect()->back();
    }
    public function xray(Request $request) {
        $user = User::find($request['xray_user_id']);
        if ($image = $request->file(['photo'])) {
            $image_name = time().$image->getClientOriginalName();
            Storage::putFileAs('public/img/xray', $image, $image_name);
            $user->photos()->create(['path'=>$image_name]);
        }
        return redirect()->back();
    }

}
