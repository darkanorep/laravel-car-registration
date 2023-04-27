<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'car_id',
        'car_model',
        'car_year',
        'top_speed'
    ];

    public function car() {
        return $this->belongsTo(Car::class);
    }

    // public function users() {
    //     return $this->belongsToMany(User::class, 'owners', 'car_model_id', 'user_id');
    // }

    public function users() {
        return $this->belongsToMany(User::class, 'owners', 'car_model_id', 'user_id')->withPivot('id');
    }
    
    public function plateNumbers() {
        return $this->hasOne(PlateNumber::class, 'owner_id', 'id');
    }
    
}
