<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' =>"ADMINISTRADOR",
            'email' => "admin@admin.com",
            'password' => bcrypt('secret'),
            'miembro_id' => 1,
            'estatus_id' => 2,
            'role_id' => 1,
        ]);
    }
}
