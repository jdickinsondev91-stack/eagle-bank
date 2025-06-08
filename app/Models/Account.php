<?php

namespace App\Models;

use App\Models\User;
use App\Traits\HasCustomAccountId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasCustomAccountId, HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sort_code',
        'name',
        'balance', 
        'open'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }
}