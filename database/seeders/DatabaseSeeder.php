<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /** Seed the application's database. */
    use WithoutModelEvents;

    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name'     => 'Test User',
        //     'email'    => 'personalia@pindadmedika.com',
        //     'password' => Hash::make('12345678'),
        // ]);
        // \App\Models\User::create([
        //     'name'     => 'Test User',
        //     'email'    => 'personalia@pindadmedika.com',
        //     'password' => Hash::make(config('app.seeder_default')),
        // ]);

        $this->call([
            PermissionsSeeder::class
        ]);
    }
}
