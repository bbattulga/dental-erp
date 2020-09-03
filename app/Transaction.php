<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\CheckIn;
use App\Promotion;
    

class Transaction extends Model
{
    //
    protected $fillable = [
        'price', 
        'type_id', 
        'transactionable_id',
        'transactionable_type',
        'description',
        'created_by'
    ];

    public function transactionable(){
        return $this->morphTo();
    }

    public function type() {
        return $this->hasOne('App\TransactionCategory', 'id', 'type_id');
    }

    // for legacy code
    public function getPromotionAttribute(){
        return $this->transactionable;
    }
    public function getCheckInAttribute(){
        return $this->transactionable;
    }
    // end for legacy code
}
