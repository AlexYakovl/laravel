<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'amount', 'transaction_time'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}

