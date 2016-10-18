<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
     protected $tables = [
        'products',
        'product_variants',
        'product_types',
        'product_sets',
        'product_variant_product_variant',
        'product_prices',
        'product_price_product_variant'      
        
    ];
     protected $seeders = [
        'ProductsTableSeeder',
        'ProductVariantsTableSeeder',
        'ProductTypesTableSeeder',
        'ProductSetsTableSeeder',
        'ProductVariantProductVariantTableSeeder',
        'ProductPricesTableSeeder',
        'ProductPriceProductVariantTableSeeder'        
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
         $this->cleanDatabase();
        foreach ($this->seeders as $seed) {
            $this->call($seed);
        }
        Eloquent::reguard();
    }
    /**
     * Clean up database
     */
    public function cleanDatabase()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->tables as $table) {
            \DB::table($table)->truncate();
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
