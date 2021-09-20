<?php

namespace KDAWScom\LaravelUuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait HasUuidPrimary
 *
 * The model has an ordered UUID primary key
 *
 * @package KDAWScom\LaravelUuid
 */
trait HasUuidPrimary
{
    /**
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * @return void
     */
    public static function bootHasUuidPrimary()
    {
        /**
         * Make sure the model is using string PK and not auto incrementing
         *
         * If there is no key currently, generate a new UUID key
         */
        static::creating(function (Model $model) {
            $model->keyType = 'string';
            $model->incrementing = false;

            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::orderedUuid();
            }
        });

        /**
         * We check using an attribute for the key rather than the getKey() as getKey() won't hold the new value yet
         */
        static::saving(function (Model $model) {
            $originalKey = $model->getOriginal($model->getKeyName());
            if (! is_null($originalKey)) {
                if ($originalKey !== $model->{$model->getKeyName()}) {
                    $model->{$model->getKeyName()} = $originalKey;
                }
            }
        });
    }
}
