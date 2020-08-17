<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserTreatments;
use App\TreatmentNote;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\CheckIn;
use App\Photo;


class UserTreatmentController extends Controller
{
    public function index(){
		return UserTreatments::with([
				'user', 
				'checkin',
				'treatment', 
				'treatmentSelection'
			])
			->get();
	}

	public function show($id){
		return UserTreatments::with([
				'user', 
				'checkin',
				'treatment', 
				'treatmentSelection'
			])
			->where('id', $id)
			->get();
	}

	public function store(Request $request){
		$user_treatment = UserTreatments::create($request->all());

		$t = $user_treatment->treatment; // load treatment
		if (!empty($request['symptom'] || !empty($request['diagnosis']))){
			
            $note = TreatmentNote::create([
                'checkin_id'=> $request['checkin_id'],
                'user_treatment_id'=>$user_treatment->id,
                'symptom'=>$request['symptom'],
                'diagnosis'=>$request['diagnosis']
            ]);
        }
		return $user_treatment;
	}
	
	public function query(Request $request){
		if ($request['user_id']){
			return UserTreatments::with('treatment')
					->where('user_id', $request['user_id'])
					->orderBy('created_at', 'desc')
					->get();
		}
		return array();
	}

	public function update(Request $request){
		 if (!empty($request['symptom']) || !empty($request['diagnosis'])){
			$note = TreatmentNote::where('user_treatment_id', $request['id'])->get();
			if ($note->count() == 0){
				$note = TreatmentNote::create([
	                'checkin_id'=> $request['checkin_id'],
	                'user_treatment_id'=>$request['id'],
	                'symptom'=>$request['symptom'],
	                'diagnosis'=>$request['diagnosis']
	            ]);
			}else{
				TreatmentNote::where('user_treatment_id', $request['id'])->update($request->all());
			}
		}

		// if (!empty($request['id']))	
		// 	return UserTreatments::where('id', $request['id'])->update($request->all());
		return 1;
	}

	public function xray(Request $request){
		$user = User::find($request['user_id']);
		return $user->photos;
	}

	public function xrayStore(Request $request){
		if ($image = $request->file(['image'])){
			$user = User::find($request['user_id']);
            $image_name = time().$image->getClientOriginalName();
            if (env('APP_ENV') == "local") {
              Storage::putFileAs('public/img/xray', $image, $image_name);
            }else if (env('APP_ENV') == "prod"){
              Storage::disk('gcs')->putFileAs('public/img/xray', $image, $image_name);
            }
            $photo = $user->photos()->create(['path'=>$image_name]);
            return $photo;
        }
	}

	public function xrayDestroy($id){
		return Photo::destroy($id);
	}

	public function finish(Request $request){
		$checkin_id = $request['checkin_id'];
		return CheckIn::where('id', $checkin_id)->update(['state'=>2]);
	}

	public function destroy($id){
        
		return UserTreatments::destroy($id);
	}
}
