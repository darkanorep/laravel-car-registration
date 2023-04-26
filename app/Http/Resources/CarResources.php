<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return [
        //     'id' => $this->id,
        //     'car_model' => $this->car_model,
        //     'car_year' => $this->car_year,
        //     'model' => [
        //         'car_id' => $this->car->id,
        //         'car_brand' => $this->car->car_brand
        //     ]
        // ];

        return [
            'id' => $this->id,
            'attribute' => [
                'car_model' => $this->car_model,
                'car_year' => $this->car_year,
            ],
            'relationship' => [
                'car_id' => $this->car->id,
                'car_brand' => $this->car->car_brand
            ]
        ];
    }
}
