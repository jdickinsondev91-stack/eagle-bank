<?php

use App\Models\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'line_1',
        'line_2',
        'line_3',
        'town',
        'county', 
        'postcode',
        'is_current'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}