<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
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
		$notes_updated = 0;
		 if (!empty($request['symptom']) || !empty($request['diagnosis'])){
			$note = TreatmentNote::where('user_treatment_id', $request['id'])->get();
			if ($note->count() == 0){
				$note = TreatmentNote::create([
	                'checkin_id'=> $request['checkin_id'],
	                'user_treatment_id'=>$request['id'],
	                'symptom'=>$request['symptom'],
	                'diagnosis'=>$request['diagnosis']
	            ]);
	            $notes_updated = 'created new note';
			}else{
				$notes_updated = TreatmentNote::where('user_treatment_id', $request['id'])
					->update([
							'symptom'=>$request['symptom'],
							'diagnosis'=>$request['diagnosis']
							]);
			}
		}
		if (!empty($request['price']))
			return UserTreatments::where('id', $request['id'])->update(['price'=>$request['price']]);
		return $notes_updated;
	}

	public function xray(Request $request){
		$user = User::find($request['user_id']);

		$xrays = array();
		$photos = $user->photos()->orderBy('created_at', 'desc')->get();
		foreach($user->photos as $photo){

			$url = null;
			if (App::environment('local')) {
	          $url = Storage::url('public/img/xray/'.$photo->path);
	        }else if (App::environment('prod')){
	          $disk = Storage::disk('gcs');
	          $url = $disk->url('public/img/xray/'.$photo->path);
	        }

	        if ($url != null){
	        	$xray = $photo;
	        	$photo->url = $url;
	        	array_push($xrays, $xray);
	        }
		}

		return $xrays;
	}

	public function xrayStore(Request $request){
		if ($image = $request->file(['image'])){
			$user = User::find($request['user_id']);
            $image_name = time().$image->getClientOriginalName();
            if (App::environment('local')) {
              Storage::disk('local')->putFileAs('public/img/xray', $image, $image_name);
              $url = Storage::url('public/img/xray/'.$image_name);
            }else if (App::environment('prod')){
              Storage::disk('gcs')->putFileAs('public/img/xray', $image, $image_name);
              $url = Storage::disk('gcs')->url('public/img/xray/'.$image_name);
            }
            $photo = $user->photos()->create(['path'=>$image_name]);
            $photo->url = $url;
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
