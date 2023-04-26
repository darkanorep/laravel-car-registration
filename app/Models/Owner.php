<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'car_model_id'
    ];

    public function getCars() {
        return $this->hasMany(CarModel::class, 'id', 'car_model_id');
    }

    public function car() {
        return $this->hasOne(CarModel::class, 'id', 'car_model_id');
    }

    public function plateNumber() {
        return $this->hasOne(PlateNumber::class, 'owner_id', 'id');
    }

    public function users() {
        return $this->belongsTo(User::class);
    }

}
