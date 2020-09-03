<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\Http\Middleware\Doctor;
use App\Item;
use App\ItemHistory;
use App\Lease;
use App\ProductHistory;
use App\Products;
use App\Promotion;
use App\UserRole;
use App\Transaction;
use App\TransactionCategory;
use App\TreatmentSelections;
use App\User;
use App\UserPromotions;
use App\UserTreatments;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceptionPaymentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('reception');
    }
    
    public function index() {
        $treatment_done_users = CheckIn::where('state',2)->orderBy('updated_at', 'asc')->get();
        return view('reception.payment',compact('treatment_done_users'));
    }

    public function store(Request $request){
        $user_treatments = UserTreatments::all()->where('checkin_id',$request['checkin_id']);
        $total = 0;
//        foreach ($user_treatments as $user_treatment){
//            if($user_treatment->treatment_selection_id == 0){
//                $total = $total + $user_treatment->treatment->price;
//            }
//            else{
//                $total = $total + TreatmentSelections::find($user_treatment->treatment_selection_id)->price;
//            }
//        }
        foreach ($user_treatments as $user_treatment){
                $total = $total + $user_treatment->price;
            }
        if(empty($request['promotion_code']) and empty($request['lease'])){

            Transaction::create(['price'=>$total,
                                'type_id'=>TransactionCategory::treatment()->id,
                                'transactionable_type'=>UserTreatments::class,
                                'transactionable_id'=>$request['checkin_id'],
                                'created_by'=>Auth::user()->id]
                            );

            $update = CheckIn::find($request['checkin_id']);
            $update->update(['state' => 3]);
        }
        elseif (!empty($request['promotion_code']) and empty($request['lease'])) {
            if($promotion = Promotion::where('promotion_end_date','>=',date('Y-m-d'))->where('promotion_code',$request['promotion_code'])->first()){
                $total = $total - $total*$promotion->percentage/100;
                $total = (int) $total;

                $transaction = Transaction::create([
                    'price'=>$total,
                    'type_id'=>TransactionCategory::treatment()->id,
                    'description' => 'Урамшуулаллын код ашиглаж төлбөр төлсөн',

                    'transactionable_type'=>UserTreatments::class,
                    'transactionable_id'=>$request['checkin_id'],
                    'created_by'=>Auth::user()->id
                ]);

                UserPromotions::create(['checkin_id'=>$request['checkin_id'],'promotion_id'=>$promotion->id, 'created_by'=>Auth::user()->id]);
                $update = CheckIn::find($request['checkin_id']);
                $update->update(['state' => 3]);
            }
            else{
                session()->flash('ended');
            }
        }
        elseif (empty($request['promotion_code']) and !empty($request['lease'])){
            Lease::create(['total'=>$total,'checkin_id'=>$request['checkin_id'],'price'=>$total-$request['lease'],'created_by'=>Auth::user()->id]);

            Transaction::create([
                'price'=>$request['lease'],
                'type_id'=>TransactionCategory::treatment()->id,
                'transactionable_type'=>UserTreatments::class,
                'transactionable_id'=>$request['checkin_id'],
                'created_by'=>Auth::user()->id,
                'description'=>'Зээлийн урьдчилгаа.'
            ]);

            $update = CheckIn::find($request['checkin_id']);
            $update->update(['state' => 4]);
        }
        elseif (!empty($request['promotion_code']) and !empty($request['lease'])){
            if($promotion = Promotion::where('promotion_end_date','>',date('Y-m-d'))->where('promotion_code',$request['promotion_code'])->first()){
                $total = $total - $total*$promotion->percentage/100;
                $tota = (int) $total;
                Lease::create(['total'=>$total,'checkin_id'=>$request['checkin_id'],'price'=>$total-$request['lease'],'created_by'=>Auth::user()->id]);

                $transaction = Transaction::create([
                    'price'=>$request['lease'],
                    'type_id'=>TransactionCategory::treatment()->id,
                    'transactionable_type'=>UserTreatments::class,
                    'transactionable_id'=>$request['checkin_id'],
                    'description'=>'Зээлтэй, урамшуулал ашиглаж төлбөр төлөгдсөн.',
                    'created_by'=>Auth::user()->id
                ]);

                UserPromotions::create(['checkin_id'=>$request['checkin_id'],'promotion_id'=>$promotion->id, 'created_by'=>Auth::user()->id]);
                $update = CheckIn::find($request['checkin_id']);
                $update->update(['state' => 4]);
            }
            else{
                session()->flash('ended');
            }
        }
        return back();
    }
    public function lease(){
        $leases = Lease::all()->where('price','>',0);
        return view('reception.lease',compact('leases'));
    }
    public function lease_store(Request $request){
        $lease = Lease::find($request['lease_id']);
        $request->validate([
            'price'=>'required'
        ]);
        if($lease->price < $request['price']) {
            return redirect()->back();
        }

        $lease->price = $lease->price - $request['price'];
        $lease->save();

        $checkin = CheckIn::find($request['checkin_id']);
        if ($lease->price == 0){
            $checkin->update(['state'=>3]);
            $lease->delete();
            Transaction::create([
                'price'=>$request['price'],
                'type_id'=>TransactionCategory::treatment()->id,
                'transactionable_type'=>UserTreatments::class,
                'transactionable_id'=>$request['checkin_id'],
                'description'=>'Зээлтэй төлбөр төлөгдсөн.',
                'created_by'=>Auth::user()->id
            ]);
        }else{
            // left some
            Transaction::create([
                'price'=>$request['price'],
                'type_id'=>TransactionCategory::treatment()->id,
                'transactionable_type'=>UserTreatments::class,
                'transactionable_id'=>$request['checkin_id'],
                'description'=>'Зээл төлөх.',
                'created_by'=>Auth::user()->id
            ]);
        }
        return redirect('/reception/lease');
    }
    public function product(){
        $products = Item::all();
        return view('reception.product',compact('products'));
    }
    public function show($id) {
        $products = Item::all();
        $specific_product = Item::find($id);
        $histories = ItemHistory::all()->where('item_id', $specific_product->id);
        $roles = UserRole::all();
        return view('reception.product_show', compact('products', 'specific_product', 'histories', 'roles'));
    }

    public function decrease_product(Request $request) {
        $product = Item::find($request['id']);
        $minus = $product->quantity - $request['quantity'];
        $product->update(['quantity'=>$minus]);
        $history = ItemHistory::create(['item_id'=>$product->id,'quantity'=> -1 * $request['quantity'],'created_by'=>Auth::user()->id]);
        Transaction::create([
                'type_id'=>TransactionCategory::item()->id,
                'transactionable_id'=>$request['id'],
                'transactionable_type'=>ItemHistory::class,
                'price'=> $request['quantity']*$product->price,
                'description'=>''.$product->name.' '.$request['quantity'].' ширхэг зарсан.',
                'created_by'=>Auth::user()->id]);
        return redirect('/reception/product/'.$product->id);
    }
}
