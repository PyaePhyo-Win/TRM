<?php

namespace Database\Seeders;

use App\Models\AppointmentType;
use Illuminate\Database\Seeder;

class AppointmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointment_types = [
            ['name' => 'milling', 'description' => 'Milling appointment type'],
            ['name' => 'drying', 'description' => 'Drying appointment type'],
        ];

        foreach ($appointment_types as $appointment_type) {
            AppointmentType::updateOrCreate(
                ['name' => $appointment_type['name']], // Unique identifier
                $appointment_type
            );
        }
    }
}
