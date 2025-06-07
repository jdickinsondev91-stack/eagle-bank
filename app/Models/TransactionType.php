<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasUuid, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}