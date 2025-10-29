<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts';

    protected $fillable = ['bank', 'account_number', 'user_id'];

    public function bills()
    {
        return $this->hasMany(BillHistory::class);
    }
}
