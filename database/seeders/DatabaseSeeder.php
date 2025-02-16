<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(15)->create();

        User::factory()->create([
            'username' => 'admin',
            'phone_mobile' => '07451324578',
            'user_type' => 101,
            'system_access' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'admin@email.com',
            'email_verified_at' => now(),
            'password' => 'password',
            'user_type' => 100,
        ]);

        $this->call([
            VehicleSeeder::class,
            IncomeSeeder::class,
            ExpenseSeeder::class,
        ]);

    }
}
