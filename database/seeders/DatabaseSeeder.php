<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

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

        $admin = Role::create([
            'name' => 'admin'
        ]);

        $dispora = Role::create([
            'name' => 'dispora'
        ]);

        $organisasi = Role::create([
            'name' => 'organisasi'
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => $admin->id,
            'password' => bcrypt('admin'),
            'no_hp' => '000000000',
        ]);
    }
}
