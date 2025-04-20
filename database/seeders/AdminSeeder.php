<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'email' => 'admin@quiz.app',
            'password' => bcrypt('admin'),
            'role'  => 3,
            'name' => 'Admin',
            'semester' => 1,
        ];

        $check = User::whereEmail($data['email'])->first();
        if (!$check) {
            User::create($data);
        }
    }
}
