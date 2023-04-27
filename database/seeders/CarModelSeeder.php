<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $car_models = DB::connection('car_registration')
    //     ->table('users')
    //     ->join('car_models', 'users.id', '=', 'car_models.id')
    //     ->select('users.id as user_id', 'car_models.id as car_model_id')
    //     ->get();

        
    //     foreach ($car_models as $car_model) {
    //         DB::table('owners')->insert([
    //             'user_id' => $car_model->user_id,
    //             'car_model_id' => $car_model->car_model_id
    //         ]);
    //     }
    // }

    public function run(): void
    {
        $user_ids = DB::connection('car_registration')->table('users')->pluck('id');
        $car_model_ids = DB::connection('car_registration')->table('car_models')->pluck('id');

        $owners = [];

        for ($i = 0; $i < 100; $i++) {
            $owners[] = [
                'user_id' => $user_ids->random(),
                'car_model_id' => $car_model_ids->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('owners')->insert($owners);
    }

}
