<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasUuid, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'string'
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}