<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasCustomId;

    protected $idPrefix = 'usr-';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function currentAddress()
    {
        return $this->hasOne(Address::class)->where('is_current', true);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
