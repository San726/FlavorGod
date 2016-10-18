<?php

use Illuminate\Database\Seeder;

class ProductPricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        	['name' => 'MSRP'],
        	['name' => '10% Off'],
        	['name' => 'Sale Price']
        ];
        foreach ($data as $key) {
            \DB::insert('insert into product_prices(name)values(?)', [$key['name']]);           
        }
    }
}
