<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'car_model' => $this->car->car_model,
            'attribute' => [
                'id' => optional($this->plateNumber)->id,
                'plate_number' => optional($this->plateNumber)->plate_number,
                'is_approved' => optional($this->plateNumber)->is_approved,
                'remarks' => optional($this->plateNumber)->remarks,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
