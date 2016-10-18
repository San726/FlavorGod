<?php

use Illuminate\Database\Seeder;

class ProductVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productVariants = [
        	1 => [
        		'product_id' => 1,
        		'variant_type' => 2,
        		'product_type_id' => 1,
        		'name' => 'Everything Seasoning',
        		'internal_sku' => '811207024269',
        		'sku' => '804879447856',
        		'upc' => '811207024269',
                'download_link' => '',        	
        		'free_product_tier_id' => 0,
        		'quantity' => 1,
        		'hide_options_from_display_name' => 0,
        		'customer_service_can_add' => 1,        		
        		'enabled' => 1    
        ],
        2 => [
                'product_id' => 1,
                'variant_type' => 3,
                'product_type_id' => 1,
                'name' => 'Everything Seasoning - 3 Bottles',
                'internal_sku' => '813327020398-3B',
                'sku' => '804879447856-3B',
                'upc' => '813327020398',
                'download_link' => '',          
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,                
                'enabled' => 1    
        ],
        3 => [
                'product_id' => 2,
                'variant_type' => 2,
                'product_type_id' => 1,
                'name' => 'Spicy Everything Seasoning',
                'internal_sku' => '811207024320',
                'sku' => '804879447863',
                'upc' => '811207024320',
                'download_link' => '',             
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,               
                'enabled' => 1     
        ],
        4 => [
                'product_id' => 2,
                'variant_type' => 3,
                'product_type_id' => 1,
                'name' => 'Spicy Everything Seasoning - 3 Bottles',
                'internal_sku' => '813327020374-3B',
                'sku' => '804879447863-3B',
                'upc' => '813327020374',
                'download_link' => '',             
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,               
                'enabled' => 1     
        ],
         5 => [
                'product_id' => 3,
                'variant_type' => 2,
                'product_type_id' => 1,
                'name' => 'Garlic Lover\'s Seasoning',
                'internal_sku' => '811207024306',
                'sku' => '804879389859',
                'upc' => '811207024306', 
                'download_link' => '',            
                'free_product_tier_id' => 1,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,               
                'enabled' => 1     
        ],
        6 => [
                'product_id' => 3,
                'variant_type' => 3,
                'product_type_id' => 1,
                'name' => 'Garlic Lover\'s Seasoning - 3 Bottles',
                'internal_sku' => '811207024306-3B',
                'sku' => '804879389859-3B',
                'upc' => '811207024306', 
                'download_link' => '',            
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,               
                'enabled' => 1     
        ],
          7 => [
                'product_id' => 4,
                'variant_type' => 2,
                'product_type_id' => 1,
                'name' => 'Lemon & Garlic Seasoning',
                'internal_sku' => '811207024283',
                'sku' => '804879153375',
                'upc' => '811207024283',
                'download_link' => '',             
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,             
                'enabled' => 1,
            
        ],
         8 => [
                'product_id' => 4,
                'variant_type' => 3,
                'product_type_id' => 1,
                'name' => 'Lemon & Garlic Seasoning - 3 Bottles',
                'internal_sku' => '811207024283-3B',
                'sku' => '804879153375-3B',
                'upc' => '811207024283',
                'download_link' => '',             
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,             
                'enabled' => 1,
            
        ],
        9 => [
                'product_id' => 5,
                'variant_type' => 2,
                'product_type_id' => 1,
                'name' => 'Chipotle Seasoning',
                'internal_sku' => '811207026720',
                'sku' => '811207026720',               
                'upc' => '811207026720', 
                'download_link' => '',            
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,
                'enabled' => 1    
        ],
         10 => [
                'product_id' => 5,
                'variant_type' => 3,
                'product_type_id' => 1,
                'name' => 'Chipotle Seasoning - 3 Bottles',
                'internal_sku' => '',
                'sku' => '811207026720-3B',                
                'upc' => '811207026720',
                'download_link' => '',             
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 0,
                'enabled' => 1    
        ],
          11 => [
                'product_id' => 6,
                'variant_type' => 3,
                'product_type_id' => 1,
                'name' => 'Pizza Seasoning',
                'internal_sku' => '813327020299',
                'sku' => '813327020299',                 
                'upc' => '813327020299',
                'download_link' => '',            
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,
                'enabled' => 1    
        ],
         12 => [
                'product_id' => 6,
                'variant_type' => 3,
                'product_type_id' => 1,
                'name' => 'Pizza Seasoning - 3 Bottles',
                'internal_sku' => '',
                'sku' => '813327020299-3B',                
                'upc' => '813327020299',
                'download_link' => '',             
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 1,             
                'enabled' => 1
                   
        ],
           13 => [
                'product_id' => 6,
                'variant_type' => 2,
                'product_type_id' => 1,
                'name' => 'Pizza Seasoning',
                'internal_sku' => 'PZA',
                'sku' => 'PZA',                
                'upc' => '813327020299',
                'download_link' => '',             
                'free_product_tier_id' => 0,
                'quantity' => 1,
                'hide_options_from_display_name' => 1,
                'customer_service_can_add' => 0,             
                'enabled' => 0
                   
        ],
        14 => [
        'product_id' => 7,
        'variant_type' => 4,
        'product_type_id' => 4,
        'name' => 'Flavor God Paleo Recipe Book',
        'internal_sku' => '',
        'sku' => 'FG-RECIPE01',
        'upc' => '',  
        'download_link' => 'http://download.flavorgod.com/flavorpurchase/flavorgodpaleoandglutenfreerecipebook.pdf',          
        'free_product_tier_id' => 0,
        'quantity' => 1,
        'hide_options_from_display_name' => 1,
        'customer_service_can_add' => 1,    
        'enabled' => 1
         
    ],
      15 => [
        'product_id' => 8,
        'variant_type' => 3,
        'product_type_id' => 1,
        'name' => 'Classic Combo Set',
        'internal_sku' => '811207024245',
        'sku' => 'COMBOPACK',
        'upc' => '811207024245',  
        'download_link' => '',          
        'free_product_tier_id' => 0,
        'quantity' => 1,
        'hide_options_from_display_name' => 1,
        'customer_service_can_add' => 1,    
        'enabled' => 1
         
    ],
        16 => [
        'product_id' => 8,
        'variant_type' => 3,
        'product_type_id' => 1,
        'name' => 'Classic Combo Set w/ Flavor God Paleo Recipe Book',
        'internal_sku' => '813327020244',
        'sku' => 'FGCOMBOBOOK-1',
        'upc' => '813327020244',  
        'download_link' => '',          
        'free_product_tier_id' => 0,
        'quantity' => 1,
        'hide_options_from_display_name' => 1,
        'customer_service_can_add' => 1,    
        'enabled' => 1
         
    ],
    17 => [
        'product_id' => 8,
        'variant_type' => 3,
        'product_type_id' => 5,
        'name' => 'Classic Combo Set w/ Apron (Grey) - 50% OFF',
        'internal_sku' => 'CLSCMB-GRAP-50',
        'sku' => 'CLSCMB-GRAP-50',
        'upc' => 'CLSCMB-GRAP-50',  
        'download_link' => '',          
        'free_product_tier_id' => 0,
        'quantity' => 1,
        'hide_options_from_display_name' => 1,
        'customer_service_can_add' => 1,    
        'enabled' => 1
         
    ],
    18 => [
        'product_id' => 9,
        'variant_type' => 3,
        'product_type_id' => 1,
        'name' => 'Chipotle Combo Set',
        'internal_sku' => '811207026713',
        'sku' => 'COMBO-CHIP',
        'upc' => '811207026713',  
        'download_link' => '',          
        'free_product_tier_id' => 0,
        'quantity' => 1,
        'hide_options_from_display_name' => 1,
        'customer_service_can_add' => 0,    
        'enabled' => 0
         
    ],
     19 => [
        'product_id' => 9,
        'variant_type' => 3,
        'product_type_id' => 1,
        'name' => 'Chipotle Combo Set w/ Flavor God Paleo Recipe Book',
        'internal_sku' => '811207026706',
        'sku' => 'COMBO-CHIP-EB',
        'upc' => '811207026706',  
        'download_link' => '',          
        'free_product_tier_id' => 0,
        'quantity' => 1,
        'hide_options_from_display_name' => 1,
        'customer_service_can_add' => 0,    
        'enabled' => 0         
    ],
     20 => [
        'product_id' => 10,
        'variant_type' => 3,
        'product_type_id' => 1,
        'name' => 'Pizza Combo Set',
        'internal_sku' => '813327020176',
        'sku' => 'COMBO-PZA',
        'upc' => '813327020176',  
        'download_link' => '',          
        'free_product_tier_id' => 0,
        'quantity' => 1,
        'hide_options_from_display_name' => 0,
        'customer_service_can_add' => 0,    
        'enabled' => 0         
    ],
     21 => [
        'product_id' => 10,
        'variant_type' => 3,
        'product_type_id' => 1,
        'name' => 'Pizza Combo Set w/ Flavor God Paleo Recipe Book',
        'internal_sku' => '813327020145',
        'sku' => 'COMBO-PZA-EB',
        'upc' => '813327020145',  
        'download_link' => '',          
        'free_product_tier_id' => 0,
        'quantity' => 1,
        'hide_options_from_display_name' => 1,
        'customer_service_can_add' => 0,    
        'enabled' => 0         
    ]
];
   
    foreach ($productVariants as $key => $value) {
        \DB::insert('insert into product_variants(product_id, variant_type, product_type_id, name, internal_sku, sku,
            upc, download_link, free_product_tier_id, quantity, hide_options_from_display_name, customer_service_can_add, enabled)values(
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $value['product_id'], 
            $value['variant_type'],
            $value['product_type_id'],
            $value['name'],
            $value['internal_sku'],
            $value['sku'],
            $value['upc'],
            $value['download_link'],
            $value['free_product_tier_id'],
            $value['quantity'],
            $value['hide_options_from_display_name'],
            $value['customer_service_can_add'],            
            $value['enabled']
        ]);
    }
    }
}
