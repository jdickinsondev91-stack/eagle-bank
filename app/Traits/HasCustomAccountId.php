<?php

namespace App\Traits;

trait HasCustomAccountId
{
    protected static function bootHasCustomAccountId()
    {
        static::creating(function ($model) {
            do {
                $id = '01' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (self::where($model->getKeyName(), $id)->exists());

            $model->{$model->getKeyName()} = $id;
        });
    }
}