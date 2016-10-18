<?php

use Illuminate\Database\Seeder;

class ProductSetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        	'Default',
        	'Thank You Array'
        ];
        
        foreach ($data as $key) {
            \DB::insert('insert into product_sets(name)values(?)', [$key]);
            
        }
    }
}
