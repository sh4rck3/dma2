<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@dunice.adv.br',
                'password' => 'P#ssw0rd3',
                'role' => 'admin'
            ],
            [
                'name' => 'Jhon',
                'email' => 'jhon@dunice.adv.br',
                'password' => 'P#ssw0rd3',
                'role' => 'standard'
            ]
        ];

        foreach ($users as $user){
            $create_user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password'])
            ]);

            $create_user->assignRole($user['role']);
        }
    
    }
}
