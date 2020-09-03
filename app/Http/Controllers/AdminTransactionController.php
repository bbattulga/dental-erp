<?php

namespace App\Http\Controllers;

use App\Log;
use App\TransactionCategory;
use App\Transaction;
use App\UserRole;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminTransactionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index() {
        $start_date = Date('Y-m-01');
        $end_date = Date('Y-m-d');
        return view('admin.transaction', $this->transactionData($start_date, $end_date));
    }

    public function search($start_date, $end_date) {
        return view('admin.transaction', $this->transactionData($start_date, $end_date));
    }
    public function date(Request $request) {
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        return redirect('/admin/transaction/' . $start_date.'/'.$end_date);
    }
    public function by_month(Request $request){
        $month = $request['month'];
        $year = $request['year'];
        $end_month = $request['month']+1;
        $start_date= Date('Y-m-d',strtotime($year .'-'.$month.'-'.'01'));
        if($end_month == 12){
            $end_month = 1;
        }
        $end_date = Date('Y-m-d',strtotime($year.'-'.$end_month.'-'.'1'));
        return redirect('/admin/transaction/' . $start_date.'/'.$end_date);
    }

    public function transactionData($start_date, $end_date){
        if (gettype($start_date) === 'integer'){
            $start_date = Date('Y-m-d 00:00:00', $start_date);
        }
        if (gettype($end_date) === 'integer'){
            $end_date = Date('Y-m-d 23:59:59', $end_date);
        }
        $roles = UserRole::all();
        $types = TransactionCategory::all();
        $transactions = Transaction::all()->where('created_at','>=', $start_date)
                                        ->where('created_at', '<=', $end_date)
                                        ->sortByDesc('id');
        $income = 0;
        $outcome = 0;
        $category_outcomes = [];
        for ($i=0; $i<=$types->count(); $i++){
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

}
