<?php

use Illuminate\Database\Seeder;

class ProductTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        'Seasoning',
        'Apparel',
        'Accessory',
        'Ebook',
        'Seasoning Pack',
        'Custom Ebook',
        ];
        foreach ($data as $key) {
        	\DB::insert('insert into product_types (name) values (?)', [$key]);
        }
    }
}
