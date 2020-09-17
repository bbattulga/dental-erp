<?php

namespace App\Http\Controllers;

use App\Log;
use App\ProductHistory;
use App\Products;
use App\Promotion;
use App\UserRole;
use App\Transaction;
use App\TransactionCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountantProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('accountant');
    }
    public function product(){
        $products = Products::all();
        return view('accountant.product',compact('products'));
    }
    public function show($id) {
        $products = Products::all();
        $specific_product = Products::find($id);
        $histories = ProductHistory::all()->where('product_id', $specific_product->id);
        $roles = UserRole::all();
        return view('accountant.product_show', compact('products', 'specific_product', 'histories', 'roles'));
    }
    public function store(Request $request){
        $product = Products::create([
                        'name'=>$request['name'],
                        'quantity'=>0,
                        'price'=>$request['price'],
                        'unit'=>$request->input('unit', '')
                    ]);
        return redirect('/accountant/products');
    }
    public function update(Request $request){
        $product = Products::find($request['id']);
        $product->update(['quantity'=>$product->quantity + $request['quantity']]);
        ProductHistory::create([
                'product_id'=>$product->id, 
                'user_id'=>Auth::user()->id, 
                'quantity'=>$request['quantity'], 
                'description'=>Auth::user()->name . ' нэмэв', 
                'created_by'=>Auth::user()->id
                            ]);
        return redirect();
    }
    public function add(Request $request){
        $product = Products::find($request['id']);
        $product->update(['quantity' => $product->quantity+abs($request['quantity'])]);
        return redirect('/accountant/products/'.$product->id);
    }

    public function decrease(Request $request) {
        $product = Products::find($request['id']);
        $user = User::find($request['user_id']);
        // ProductHistory::create([
        //         'product_id'=>$product->id, 
        //         'user_id'=>$user->id, 
        //         'quantity'=> -1 * $request['quantity'], 
        //         'description'=>$user->name . ' '.$request['quantity']. $product->unit . ' авав', 
        //         'created_by'=>Auth::user()->id
        //     ]);
        $product->update(['quantity'=>$product->quantity - abs($request['quantity'])]);
        return redirect('/accountant/products/'.$product->id);
    }

    public function delete($id){
        $this->delete_product($id);
    }

    public function delete_product($id){
        $product = Products::find($id);
        $product->delete();
        return redirect('/accountant/products');

    }
    public function change_product_index($id){
        $products = Products::all();
        $specific_product = Products::find($id);
        $histories = ProductHistory::all()->where('product_id', $specific_product->id);
        $roles = UserRole::all();
        return view('accountant.product_change', compact('products', 'specific_product', 'histories', 'roles'));
    }
    public function change_product(Request $request){
        $product = Products::find($request['id']);
        $user = User::find(Auth::user()->id);
        // Log::create(['type'=>2,'type_id'=>$product->id,'user_id'=>Auth::user()->id,'action_id'=>1,'description'=>$user->name.' '.$product->name.' барааг '.$request['name'].' болгож өөрчлөв.'.' Нэгж хэмжээг '.$product->quantity.'-ээс '.$request['quantity']. $product->unit . ' болгов.']);
        $product->update([
                        'quantity'=>$request['quantity'],
                        'name'=>$request['name'],
                        'price'=>$request['price']
                    ]);
        return redirect('/accountant/change_product_index/'.$product->id);
    }
}
