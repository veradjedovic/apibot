<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i<25; $i++) {
            DB::table('orders')->insert([
                'order_amount' => rand(99, 999),
                'shipping_amount' => rand(99, 999),
                'tax_amount' => rand(99, 999),
                'customer_id' => rand(1, 5),
            ]);
        }
    }
}
