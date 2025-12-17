<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

    $user = User::factory()->create([
        'name' => 'admin',
        'email' => 'admin@nds.com',
        'password' => Hash::make('bkkbkk'),
        'email_verified_at' => now(),
        'two_factor_recovery_codes' => 'bkkbkk',
    ]);
    }
}
