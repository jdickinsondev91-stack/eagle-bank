<?php 

namespace App\Traits;

use Illuminate\Support\Str;

trait HasCustomId 
{
    protected static function bootHasCustomId(): void 
    {
        static::creating(function($model) {
            if (!$model->getKey()) {
                $prefix = property_exists($model, 'idPrefix') ? $model->idPrefix : '';
                $model->{$model->getKeyName()} = $prefix . Str::random(10);
            }
        });
    }
}