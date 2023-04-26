<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlateNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'plate_number'
    ];

    public function plateNumber() {
        return $this->hasOne(Owner::class, 'id', 'owner_id');
    }
}
