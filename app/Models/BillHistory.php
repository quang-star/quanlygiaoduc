<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillHistory extends Model
{
    use HasFactory;

    protected $table = 'bill_histories';

    protected $fillable = [
        'contract_id', 'payment_time', 'phone_number', 'money', 'bank_account_id', 'image', 'content'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }
}
