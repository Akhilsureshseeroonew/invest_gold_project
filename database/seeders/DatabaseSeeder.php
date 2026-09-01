<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@investgoldfinance.com'],
            [
                'name' => 'Site Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ],
        );

        $this->call(DesignContentSeeder::class);
    }
}
