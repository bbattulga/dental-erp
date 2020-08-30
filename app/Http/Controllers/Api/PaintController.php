<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Paint;


class PaintController extends Controller
{
    //

    public function index(Request $request){
		return Paint::all();
	}

	public function show(Request $request){
		return Paint::where('user_id', $request['user_id'])->get();
	}

	public function store(Request $request){

		$paint = Paint::create([
			'user_id' => $request['user_id'],
			'content' => json_encode($request['content'])
		]);
		return $paint;
	}

	public function update(Request $request){
		return Paint::findOrFail($request['id'])->update($request->all());
	}

	public function destroy($id){
		return Paint::destroy($id);
	}
}
