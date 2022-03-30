<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'email',
        'address',
        'dob',
        'gender',
        'course_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::guard(config('app.guards.api'))->user()->id;
        });
    }
}
