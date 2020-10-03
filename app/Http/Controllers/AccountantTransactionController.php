<?php

namespace App\Http\Controllers;

use App\Log;
use App\TransactionCategory;
use App\UserRole;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountantTransactionController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('accountant');
    }


    public function index() {
        $start_date = strtotime('-30 Days');
        $end_date = strtotime('Today');
        return view('accountant.transaction', $this->transactionData($start_date, $end_date));
    }

    public function edit(Request $request) {
        $transaction = Transaction::find($request['transaction_id']);
        Log::create(['type'=>0,'type_id'=>$transaction->id,'user_id'=>Auth::user()->id,'action_id'=>1,'description'=> 'Хэмжээ '
            .$transaction->price.'₮ -> '.$request['price'].'₮ Тайлбар '.$transaction->description. ' -> '. $request['description'] . ' Төрөл: '
            .TransactionCategory::find($transaction->type_id)->name. ' -> '.TransactionCategory::find($request['transaction_edit_type'])->name]);
        $transaction->update(['price'=>$request['price'],'description'=>$request['description'],'type_id'=>$request['transaction_edit_type']]);
        return redirect('/accountant/transactions');
    }
//    public function delete(Request $request){
//        $trans = Transaction::find($request['transaction_id']);
//        $log = Log::create(['type'=>0,'type_id'=>$request['transaction_id'],'user_id'=>Auth::user()->id,'action_id'=>0,'description'=>$request['description']]);
//        $trans->delete();
//        return redirect('/accountant/transactions');
//
//    }

    public function search($start_date, $end_date) {
        return view('accountant.transaction', $this->transactionData($start_date, $end_date));
    }

    public function updateOutcomeType(Request $request) {

    }

    public function store(Request $request) {
        Transaction::create([
            'price'=> -1*abs($request['price']), 
            'type_id'=> $request['type_id'], 
            'description'=>$request['description'],
            'created_by'=>Auth::user()->id
        ]);
        return redirect('/accountant/transactions');
    }
    public function salary(Request $request) {
        $user = UserRole::find($request['staff'])->staff;
        $salary_type = TransactionCategory::salary();
        Transaction::create(['price'=> -1*abs($request['price']),
                                'type_id'=> $salary_type->id, 
                                'description'=>$user->name.' цалин',
                                'created_by'=>Auth::user()->id]);
        return redirect()->back();
    }
    public function income(Request $request) {
        Transaction::create(['price'=> abs($request['price']),
                            'type_id'=> $request['type_id'], 
                            'description'=>$request['description'],
                            'created_by'=>Auth::user()->id
                        ]);
        return redirect()->back();
    }
    public function TransactionCategory(Request $request) {
        TransactionCategory::create(['name'=>$request['name']]);
        return redirect()->back();
    }

    public function date(Request $request) {
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        return redirect('/accountant/transactions/' . $start_date.'/'.$end_date);
    }
    public function by_month(Request $request){
        $month = $request['month'];
        $year = $request['year'];
        $end_month = $request['month']+1;
        $start_date= Date('Y-m-d', strtotime($year .'-'.$month.'-'.'01'));
        if($end_month == 12){
            $end_month = 1;
        }
        $end_date = Date('Y-m-d', strtotime($year.'-'.$end_month.'-'.'01'));
        return redirect('/accountant/transactions/' . $start_date.'/'.$end_date);
    }


    public function transactionData($start_date, $end_date){
        if (gettype($start_date) === 'integer'){
            $start_date = Date('Y-m-d 00:00:00', $start_date);
        }else{
            $start_date = Date('Y-m-d 00:00:00', strtotime($start_date));
        }
        if (gettype($end_date) === 'integer'){
            $end_date = Date('Y-m-d 23:59:59', $end_date);
        }else{
            $end_date = Date('Y-m-d 23:59:59', strtotime($end_date));
        }
        $roles = UserRole::all();
        $types = TransactionCategory::all();
        $transactions = Transaction::all()->where('created_at','>=', $start_date)
                                        ->where('created_at', '<=', $end_date)
                                        ->sortByDesc('id');
        $income = 0;
        $outcome = 0;
        $category_outcomes = [];
        for ($i=0; $i<=$types[$types->count()-1]->id; $i++){
            array_push($category_outcomes, 0);
        }
        foreach($transactions as $transaction){
            if ($transaction->price > -1){
                $income += $transaction->price;
                continue;
            }
            $category_outcomes[$transaction->type_id] += abs($transaction->price);
            $outcome += $transaction->price;
        }
        $outcome = abs($outcome);

        $start_date = Date('Y-m-d', strtotime($start_date));
        $end_date = Date('Y-m-d', strtotime($end_date));
        return compact('transactions', 'roles', 'start_date', 'end_date', 
                        'types', 'outcome', 'category_outcomes', 'income');
    }

    public function outcomeCategory(Request $request){
        TransactionCategory::create([
            'name' => $request['name']
        ]);
        return redirect()->back();
    }

}
