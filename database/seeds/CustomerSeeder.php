<?php

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i<5; $i++) {
            DB::table('customers')->insert([
                'first_name' => ucfirst(strtolower(Str::random(7))),
                'last_name' => ucfirst(strtolower(Str::random(10))),
                'email' => strtolower(Str::random(7)).'@gmail.com',
                'street' => ucfirst(strtolower(Str::random(7))). ' ' . rand(1, 99),
                'country' => 'Serbia',
            ]);
        } 
    }
}
