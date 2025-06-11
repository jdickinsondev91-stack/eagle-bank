<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasCustomId, HasFactory;

    protected $idPrefix = 'tan-';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'account_id',
        'transaction_type_id',
        'amount',
        'reference',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function currency() 
    {
        return $this->hasOneThrough(
            Currency::class,
            Account::class,
            'id',
            'id',
            'account_id',
            'currency_id'
        );
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }
}