<?php

use Illuminate\Database\Seeder;

class ProductPriceProductVariantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$items = 
    		[
    			[
       				'product_price_id' => 1,
    				'product_variant_id' => 1,
    				'price'	=> 9.99
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 1,
    				'price'	=> 8.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 2,
    				'price'	=> 9.99
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 2,
    				'price'	=> 8.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 3,
    				'price'	=> 9.99
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 3,
    				'price'	=> 8.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 4,
    				'price'	=> 9.99
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 4,
    				'price'	=> 8.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 6,
    				'price'	=> 29.99
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 6,
    				'price'	=> 14.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 7,
    				'price'	=> 29.99
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 7,
    				'price'	=> 14.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 8,
    				'price'	=> 29.95
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 8,
    				'price'	=> 9.95
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 9,
    				'price'	=> 29.97
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 9,
    				'price'	=> 25.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 10,
    				'price'	=> 29.97
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 10,
    				'price'	=> 25.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 11,
    				'price'	=> 29.97
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 11,
    				'price'	=> 25.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 12,
    				'price'	=> 29.97
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 12,
    				'price'	=> 25.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 13,
    				'price'	=> 89.97
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 13,
    				'price'	=> 41.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 14,
    				'price'	=> 89.97
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 14,
    				'price'	=> 41.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 15,
    				'price'	=> 39.96
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 15,
    				'price'	=> 27.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 16,
    				'price'	=> 69.99
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 16,
    				'price'	=> 34.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 17,
    				'price'	=> 69.95
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 17,
    				'price'	=> 29.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 18,
    				'price'	=> 99.99
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 18,
    				'price'	=> 36.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 19,
    				'price'	=> 69.95
    			],[
       				'product_price_id' => 3,
    				'product_variant_id' => 19,
    				'price'	=> 29.99
    			],[
       				'product_price_id' => 1,
    				'product_variant_id' => 20,
    				'price'	=> 99.99
    			],
    			[
       				'product_price_id' => 3,
    				'product_variant_id' => 20,
    				'price'	=> 36.99
    			],
    		];
    		foreach ($items as $item) {
    			\DB::insert('insert into product_price_product_variant(product_price_id, product_variant_id, price)values(?, ?, ?)', 
    				[
    					$item['product_price_id'],
    					$item['product_variant_id'],
    					$item['price']
    				]);
    		}
    }
}
