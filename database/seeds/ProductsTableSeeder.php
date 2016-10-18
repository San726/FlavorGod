<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carbon = new Carbon();
        $products = [
        	1 => [
        		'name' => 'Everything Seasoning',
        		'titlename' => 'Everything Seasoning',
        		'slug' => '804879447856',
        		'description' => 'Everything Seasoning',
        		'sku' => '804879447856',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			],
			2 => [
        		'name' => 'Spicy Everything Seasoning',
        		'titlename' => 'Spicy Everything Seasoning',
        		'slug' => '',
        		'description' => 'Spicy Everything Seasoning',
        		'sku' => '804879447863',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			],
			3 => [
        		'name' => 'Garlic Lover\'s Seasoning',
        		'titlename' => 'Garlic Lover\'s Seasoning',
        		'slug' => '',
        		'description' => 'Garlic Lover\'s Seasoning',
        		'sku' => '804879389859',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			],
			4 => [
        		'name' => 'Lemon & Garlic Seasoning',
        		'titlename' => 'Lemon & Garlic Seasoning',
        		'slug' => '',
        		'description' => '',
        		'sku' => '804879153375',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			],
			5 => [
        		'name' => 'Chipotle Seasoning',
        		'titlename' => 'Chipotle Seasoning',
        		'slug' => 'chipotle-seasoning',
        		'description' => 'Chipotle Seasoning',
        		'sku' => '811207026720',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			],
			6 => [
        		'name' => 'Pizza Seasoning',
        		'titlename' => 'Pizza Seasoning',
        		'slug' => 'pizza-seasoning',
        		'description' => 'Pizza Seasoning',
        		'sku' => '813327020299',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			],
			7 => [
        		'name' => 'Flavor God Paleo Recipe Book',
        		'titlename' => 'Flavor God Paleo Recipe Book',
        		'slug' => 'flavor-god-paleo-recipe-book',
        		'description' => 'Flavor God Paleo Recipe Book',
        		'sku' => 'FG-RECIPE01',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			],
			8 => [
        		'name' => 'Classic Combo Set',
        		'titlename' => 'Classic Combo Set',
        		'slug' => 'classic-combo-set',
        		'description' => 'Classic Combo Set',
        		'sku' => 'COMBOPACK',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			],
			9 => [
        		'name' => 'Chipotle Combo Set',
        		'titlename' => 'Chipotle Combo Set',
        		'slug' => 'chipotle-combo-set',
        		'description' => 'Chipotle Combo Set',
        		'sku' => 'COMBO-CHIP',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			],
			10 =>[
        		'name' => 'Pizza Combo Set',
        		'titlename' => 'Pizza Combo Set',
        		'slug' => 'pizza-combo-set',
        		'description' => 'Pizza Combo Set',
        		'sku' => 'COMBO-PZA',
        		'enabled' => 1,
                'created_at' => $carbon::today(),
                'updated_at' => $carbon::today() 
			]
        ];
        $id=1;
        foreach ($products as $product) {
            \DB::insert('insert into products(id, name, titlename, slug, description, sku, enabled, created_at, updated_at)values(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id, $product['name'], $product['titlename'], $product['slug'], $product['description'], $product['sku'], $product['enabled'], $product['created_at'], $product['updated_at']  ]);
            $id++;
        }
    }
}
