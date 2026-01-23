<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@instansi.go.id', // Gunakan email dummy Anda
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'), // Hash password
        ]);
    }
}
