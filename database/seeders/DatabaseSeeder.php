<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user = new User;

        $user->name     = 'Petrolida Admin';
        $user->email    = 'admin@petrolida.com';
        $user->password = Hash::make('G4tauP4ssnya');

        $user->save();
    }
}
