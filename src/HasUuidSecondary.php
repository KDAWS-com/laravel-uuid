<?php

namespace KDAWScom\LaravelUuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait HasUuidPrimary
 *
 * The model has an ordered UUID secondary key
 *
 * @package KDAWScom\LaravelUuid
 */
trait HasUuidSecondary
{
    /**
     * Are we protecting the UUID from change?
     *
     * @var bool
     */
    protected $laravelUuidSecondaryLocked = true;

    protected $laravelUuidSecondaryKeyName = 'uuid';

    /**
     * @return void
     */
    public static function bootHasUuidSecondary()
    {
        /**
         * If there is no key currently, generate a new UUID key
         */
        static::creating(function (Model $model) {
            if (! $model->{static::$laravelUuidSecondaryKeyName}) {
                $model->{static::$laravelUuidSecondaryKeyName} = (string)Str::orderedUuid();
            }
        });

        /**
         * Check to see if we are protecting the UUID key against change.  If we are, reset the key value back to
         * the original value.
         */
        static::saving(function (Model $model) {
            $originalKey = $model->getOriginal($model->{static::$laravelUuidSecondaryKeyName});
            if (! is_null($originalKey) && $model->laravelUuidSecondaryLocked) {
                if ($originalKey !== $model->{static::$laravelUuidSecondaryKeyName}) {
                    $model->{static::$laravelUuidSecondaryKeyName} = $originalKey;
                }
            }
        });
    }
}
