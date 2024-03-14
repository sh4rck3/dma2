<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\NewrolesSeeder;
use Database\Seeders\NewrolefinanSeeder;
use Database\Seeders\CodedddstateSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RolesSeeder::class,
            UserSeeder::class, 
            NewrolesSeeder::class,
            NewrolefinanSeeder::class,
            CodedddstateSeeder::class
        ]);
    }
}
