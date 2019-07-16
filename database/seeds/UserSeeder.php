<?php

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
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('11111111'),
            'api_token' => 'v4LFSmAxLxIZN3x7dVAIGvN83DNylRRRc3EqtjPWmAipEPKB2sfYpMQeZTSi',
        ]);
    }
}
