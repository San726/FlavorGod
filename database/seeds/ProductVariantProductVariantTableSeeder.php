<?php

use Illuminate\Database\Seeder;

class ProductVariantProductVariantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$items = [
    		[
    			'parent_id' => 1,
    			'child_id'	=> 9,
    			'quantity'	=> 3,
    		],
    		[
    			'parent_id' => 2,
    			'child_id'	=> 10,
    			'quantity'	=> 3,
    		],[
    			'parent_id' => 3,
    			'child_id'	=> 11,
    			'quantity'	=> 3,
    		],[
    			'parent_id' => 4,
    			'child_id'	=> 12,
    			'quantity'	=> 3,
    		],[
    			'parent_id' => 6,
    			'child_id'	=> 13,
    			'quantity'	=> 3,
    		],[
    			'parent_id' => 1,
    			'child_id'	=> 15,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 2,
    			'child_id'	=> 15,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 3,
    			'child_id'	=> 15,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 4,
    			'child_id'	=> 15,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 1,
    			'child_id'	=> 16,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 2,
    			'child_id'	=> 16,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 3,
    			'child_id'	=> 16,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 4,
    			'child_id'	=> 16,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 8,
    			'child_id'	=> 16,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 1,
    			'child_id'	=> 17,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 2,
    			'child_id'	=> 17,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 3,
    			'child_id'	=> 17,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 4,
    			'child_id'	=> 17,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 6,
    			'child_id'	=> 17,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 1,
    			'child_id'	=> 18,
    			'quantity'	=> 1,
    		],
    		[
    			'parent_id' => 2,
    			'child_id'	=> 18,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 3,
    			'child_id'	=> 18,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 4,
    			'child_id'	=> 18,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 6,
    			'child_id'	=> 18,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 8,
    			'child_id'	=> 18,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 1,
    			'child_id'	=> 19,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 2,
    			'child_id'	=> 19,
    			'quantity'	=> 1,
    		],
    		[
    			'parent_id' => 3,
    			'child_id'	=> 19,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 7,
    			'child_id'	=> 19,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 1,
    			'child_id'	=> 20,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 2,
    			'child_id'	=> 20,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 3,
    			'child_id'	=> 20,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 4,
    			'child_id'	=> 20,
    			'quantity'	=> 1,
    		],
    		[
    			'parent_id' => 7,
    			'child_id'	=> 20,
    			'quantity'	=> 1,
    		],[
    			'parent_id' => 8,
    			'child_id'	=> 20,
    			'quantity'	=> 1,
    		],
    	];
    	foreach ($items as $item) {
    		\DB::insert('insert into product_variant_product_variant(parent_id, child_id, quantity)values(?, ?, ?)',
    			[
    				$item['parent_id'],
    				$item['child_id'],
    				$item['quantity']
    			]);
    	}
    }
}
