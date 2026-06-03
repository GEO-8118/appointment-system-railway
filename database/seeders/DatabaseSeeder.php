<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Generate Administrators Profile Account
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@booking.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Generate Regular Customer Account
        User::create([
            'name' => 'Jane Doe',
            'email' => 'customer@booking.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
        ]);

        // Mock Testing Service Options
        Service::create([
            'name' => 'General Consultation',
            'description' => 'Initial medical checkup and structural evaluation.',
            'duration_minutes' => 30,
            'price' => 75.00
        ]);

        Service::create([
            'name' => 'Premium Strategy Consultation',
            'description' => 'Deep dive architectural technical design planning session.',
            'duration_minutes' => 60,
            'price' => 150.00
        ]);

        // Mock Open Available Schedule Slots
        Schedule::create(['available_date' => '2026-06-10', 'start_time' => '09:00:00', 'end_time' => '09:30:00', 'is_booked' => false]);
        Schedule::create(['available_date' => '2026-06-10', 'start_time' => '10:00:00', 'end_time' => '10:30:00', 'is_booked' => false]);
        Schedule::create(['available_date' => '2026-06-11', 'start_time' => '14:00:00', 'end_time' => '15:00:00', 'is_booked' => false]);
    }
}