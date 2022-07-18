<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        \App\Models\User::factory()->create([
            'name' => 'Test1',
            'email' => 'test1@example.com',
            'password' => password_hash('test', MHASH_MD5),
            'hasOtpOn' => false
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test2',
            'email' => 'test2@example.com',
            'password' => password_hash('test', MHASH_MD5),
            'hasOtpOn' => true
        ]);
    }
}
