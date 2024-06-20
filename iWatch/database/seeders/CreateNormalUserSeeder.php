<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class CreateNormalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Manolo',
            'email' => 'manolo@demo.com',
            'password' => bcrypt('12345678')
        ]);

        $user = User::create([
            'name' => 'Ramon',
            'email' => 'ramon@demo.com',
            'password' => bcrypt('12345678')
        ]);

        $user = User::create([
            'name' => 'Pepe',
            'email' => 'pepe@demo.com',
            'password' => bcrypt('12345678')
        ]);

        $user = User::create([
            'name' => 'Hernesto',
            'email' => 'hernesto@demo.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
