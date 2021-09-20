# laravel-uuid

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kdaws-com/laravel-uuid.svg?style=flat-square)](https://packagist.org/packages/kdaws-com/laravel-uuid)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/kdaws-com/laravel-uuid/run-tests?label=tests)](https://github.com/kdaws-com/laravel-uuid/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/kdaws-com/laravel-uuid/Check%20&%20fix%20styling?label=code%20style)](https://github.com/kdaws-com/laravel-uuid/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kdaws-com/laravel-uuid.svg?style=flat-square)](https://packagist.org/packages/kdaws-com/laravel-uuid)

A pair of Eloquent Model Traits for dealing with orderable UUID primary or secondary keys.

## Usage
### Primary Keys
*Model*
```injectablephp
Use \KDAWScom\LaravelUuid\HasUuidPrimary;

class MyModel extends Model
{
    Use HasUuidPrimary;
}
```
*Migration*
```injectablephp
return new class extends Migration
{
    public function up()
    {
        Schema::create('my_models', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            
            // OR
            
            $table->string('myKeyNameWillBeAutoDiscovered', 36)->primary();
        }
    }
}
```

### Secondary Keys
*Model*
```injectablephp
Use \KDAWScom\LaravelUuid\HasUuidSecondarys;

class MyModel extends Model
{
    Use HasUuidSecondary;
}
```
*Migration*
```injectablephp
return new class extends Migration
{
    public function up()
    {
        Schema::create('my_models', function (Blueprint $table) {
            /**
             * Default key name is uuid 
             */
            $table->string('uuid', 36);

            /**
             * You can also set your own key name, but you must remember to set the value of:
             *
             * $laravelUuidSecondaryKeyName
             * 
             * to the key name inside your models boot routine
             */

            $table->string('myUuidKey', 36);
        }
    }
}
```
