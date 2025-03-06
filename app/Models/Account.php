<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'currency', 'balance'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function incomeTransactions()
    {
        return $this->hasMany(IncomeTransaction::class);
    }

    public function expenseTransactions()
    {
        return $this->hasMany(ExpenseTransaction::class);
    }
}
