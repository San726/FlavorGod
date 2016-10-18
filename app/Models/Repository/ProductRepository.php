<?php

namespace Flavorgod\Models\Repository;

use Cache;
use FitlifeGroup\Models\Repository\ProductRepository as BaseRepo;
use Flavorgod\Models\Eloquent\Product;
use Flavorgod\Models\Eloquent\ProductSet;
use Flavorgod\Models\Eloquent\ProductVariant;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends BaseRepo
{
	protected $baseModel = Product::class;

    /**
     * Apply transformation (visibility) rules to the Asset model
     *
     * @param  FitlifeGroup\Models\Eloquent\Asset    $asset
     * @param  array     [$extend = []]      Additional attributes to make visible on the model
     * @return void
     */
    protected static function transformAsset($asset, array $extend = [])
    {
        $asset->setVisible(array_merge([
            'name',
            'path',
            // 'relation_type',
            'extension'
        ], $extend));

        $asset['relation_type'] = $asset->pivot->relation_type_name;

        return $asset;
    }

    protected static function normalizeProductCategories($categories)
     {   $normalizedCategories = [];
        if(!is_array($categories)){
            $categories->each(function($category) use (&$normalizedCategories){
                if(!isset($normalizedCategories[$category->name])){
                    $normalizedCategories[] = $category->name;
                }
            });
        }
        return $normalizedCategories;
    }

    protected static function normalizeAssets($assets)
    {
    	$normalizedAssets = [];
        if(!is_array($assets)){
            $assets->each(function ($asset) use (&$normalizedAssets) {
                static::transformAsset($asset);
                if (!isset($normalizedAssets[$asset->relation_type])) {
                    $normalizedAssets[$asset->relation_type] = [];
                }

                $normalizedAssets[$asset->relation_type][] = $asset;
            });
        }

    	return $normalizedAssets;
    }

    protected static function slugify($text)
    {
        return preg_replace('/[^0-9a-z]+/i', '-', strtolower($text));
    }

    /**
     * Overloaded function for normalizing the output of the repository
     *
     * @param  Illuminate\Database\Eloquent\Collection   $products
     * @return array
     */
    protected function getNormalizedIndex()
    {
        $products = $this->getRawIndex();
        $products
        ->each(function ($product) {
            // Load relationships for index results
            $product->load('productSets.type', 'baseVariant.assets', 'assets', 'categories');
            // ProductSet Transformation
            $productSets = [];
            $product->productSets->each(function ($set) use (&$productSets) {
                $type = $this->slugify($set->type->name);
                if (!isset($productSets[$type])) {
                    $productSets[$type] = [];
                }
                $productSets[$type][] = $this->slugify($set->name);
            });
            unset($this->productSets);
            $product['product_sets'] = $productSets;
            // Base Variant Transformation
            $this->attachProductPrices($product->baseVariant);

            $variantAssets = $this->normalizeAssets($product->baseVariant->assets);
            unset($product->baseVariant->assets);
            $product->baseVariant['assets'] = $variantAssets;
            $productAssets = $this->normalizeAssets($product->assets);
            $productCategories = $this->normalizeProductCategories($product->categories);
            unset($product->assets);
            unset($product->categories);
            $product['assets'] = $productAssets;
            $product['category'] = $productCategories;
            static::transformVariant($product->baseVariant);
            // Product Transformation
            static::transformProduct($product, ['baseVariant', 'product_sets']);
        });
        return json_decode(json_encode($products), true);
    }

    /**
     * Overloaded function for normalizing the output of the repository
     *
     * @param  Fitlifegroup\Models\Eloquent\Product         $product
     * @return array
     */
    protected function getNormalizedModel($withoutTransformations = false)
    {
        $product = $this->getRawModel();
        // Define the relationships required to create
        // the composite model
        $product->load('productSets.type', 'variants.children.assets', 'assets', 'variants.assets', 'featuredProducts', 'variants.product.productSets.type');
        // Build the composite model structure
        $product->variants->each(function ($variant) {
            // Attach pricing for the specific variant
            $this->attachProductPrices($variant);
            // Attach bundle breakdown as 'includes'
            $variant['includes'] = $variant->children->each(function ($child) {
                $childAssets = $this->normalizeAssets($child->assets);
                unset($child->assets);
                $child['assets'] = $childAssets;
                // set tranformation rules for bundle items
                static::transformVariantChild($child, ['name', 'assets']);
            });

	        $variantAssets = $this->normalizeAssets($variant->assets);
	        unset($variant->assets);
	        $variant['assets'] = $variantAssets;
            // ProductSet Transformation for variants
            $productSets = [];
            $variant->product->productSets->each(function($set) use (&$productSets){
                $type = $this->slugify($set->type->name);
                if(!isset($productSets[$type])){
                   $productSets[$type] = [];
                }
                $productSets[$type][] = $this->slugify($set->name);
            });
            unset($variant->product);
            $variant['product_sets'] = $productSets;
            // set transformation rules for variants
            static::transformVariant($variant, ['includes', 'assets', 'product_type_id', 'shippable', 'product_combo_count', 'sub_name', 'product_sets']);
        });
        // ProductSet Transformation for product
        $productSets = [];
        $product->productSets->each(function ($set) use (&$productSets) {
            $type = $this->slugify($set->type->name);
            if (!isset($productSets[$type])) {
                $productSets[$type] = [];
            }
            $productSets[$type][] = $this->slugify($set->name);
        });
        unset($this->productSets);
        $product['product_sets'] = $productSets;
        //Get Featured Products
        if($product->variants->count() == 1){
            if($product->featuredProducts()->count()){
                $featuredProducts = $this->getFeaturedProducts($product->featuredProducts);
                    foreach ($featuredProducts as $key => $featuredProduct) {
                        $product->variants->push($featuredProduct);
                        if($key == 1) break;
                    }
            }

        }else if($product->variants->count() == 2){
            if($product->featuredProducts()->count()){
                $featuredProducts = $this->getFeaturedProducts($product->featuredProducts);
                foreach ($featuredProducts as $key => $featuredProduct) {
                    $product->variants->push($featuredProduct);
                    if($key == 0) break;
                }
            }
        }
        //Get Relevant Combos
        if($product->variants->count() == 1){
            $combos = $this->getMostRelevantCombo($product);
            foreach ($combos as $key => $combo) {
                $product->variants->push($combo);
                if($key == 1) break;
            }
        }else if($product->variants->count() == 2){
            $combos = $this->getMostRelevantCombo($product);
            foreach ($combos as $key => $combo) {
                $product->variants->push($combo);
                if($key == 0) break;
            }
        }

        $productAssets = $this->normalizeAssets($product->assets);
        unset($product->assets);
        $product['assets'] = $productAssets;
        // set transformation rules for products
        static::transformProduct($product, ['product_sets', 'variants', 'assets', 'name', 'titlename', 'external_url']);
        //dd(json_decode(json_encode($product), true));
        return json_decode(json_encode($product), true);
    }

    /**
     * Get the Featured products attached to the current product
     * @param Collention $featuredProducts
     * @return array
     */
    public function getFeaturedProducts($featuredProducts)
    {
        $variants = [];
        foreach ($featuredProducts as $featuredProduct) {
            $featuredProduct->load('ProductVariant');
            $variants[] = $featuredProduct->productVariant;
        }
        //Transform each variant
        foreach ($variants as $variant) {
            $variant->load('assets', 'children.assets', 'product.productSets.type');
            // Attach pricing for the specific variant
            $this->attachProductPrices($variant);
            // Attach bundle breakdown as 'includes'
            $variant['includes'] = $variant->children->each(function ($child) {
                $childAssets = $this->normalizeAssets($child->assets);
                unset($child->assets);
                $child['assets'] = $childAssets;
                // set tranformation rules for bundle items
                static::transformVariantChild($child, ['name', 'assets']);
            });
            $variantAssets = $this->normalizeAssets($variant->assets);
            unset($variant->assets);
            $variant['assets'] = $variantAssets;
            // ProductSet Transformation for variants
            $productSets = [];
            $variant->product->productSets->each(function($set) use (&$productSets){
                $type = $this->slugify($set->type->name);
                if(!isset($productSets[$type])){
                   $productSets[$type] = [];
                }
                $productSets[$type][] = $this->slugify($set->name);
            });
            unset($variant->product);
            $variant['product_sets'] = $productSets;
            // set transformation rules for variants
            static::transformVariant($variant, ['product_sets', 'includes', 'assets', 'product_type_id', 'shippable', 'product_combo_count', 'sub_name']);

        }
        return $variants;
    }

    /**
     * Find the most relevant combo by looking at our current baseVariant's childten ids
     * and find other combos that share the same variant id's as children of them
     * @param Flavorgod\Models\Eloquent\ProductVariant $variant
     * @param int $vCount
     *
     * @return array
     */
    public function getMostRelevantCombo($product)
    {
        $currentVariant = $product->BaseVariant;
        if($currentVariant->children->count() <= 1){
            $currentVariantChildren = [$currentVariant->id];
        }else{
            $childrenIds = [];
            foreach ($currentVariant->children as $child) {
                $childrenIds[] = $child->id;
            }
            $currentVariantChildren = $childrenIds;
        }
        if(!Cache::has('productSetForRelevantCombos')){
            Cache::put('productSetForRelevantCombos', ProductSet::withTrashed()->where('name', 'Index')->with('products.variants.children.assets')->first(), 30);
            $productSetForRelevantCombos = Cache::get('productSetForRelevantCombos');
        }else{
            $productSetForRelevantCombos = Cache::get('productSetForRelevantCombos');
        }
        $allVariants = New Collection;
        $productSetForRelevantCombos->products->each(function($product) use ($allVariants) {
            $product->variants->each(function($variant) use ($allVariants){
                $allVariants->push($variant);
            });
        });
        foreach ($allVariants as $key => $variant) {
            //We wanna work with the bigger combos or variants that have more than 3 children or more
            //and with enabled variants only
            if($variant->children->count() < 2 || $variant->enabled == 0){
                $allVariants->offsetUnset((string) $key);
            }
        }
        $variantsAndChildren = [];
        foreach ($allVariants as $key => $variant) {
            foreach ($variant->children as $child) {
                $variantsAndChildren[$variant->id][] = $child->id;
            }
        }
        //compare both the current variant and each of our selected variants
        //To find out how different they are by comparing their id's
        $comparison = [];
        foreach ($variantsAndChildren as $variantId => $childrenIdList) {
            $comparison[$variantId] = count(array_diff( $childrenIdList, $currentVariantChildren));
        }
        //sort the comparison array by variant id
        ksort($comparison);
        $allVariants->sortBy('id');
        foreach ($comparison as $variantId => $difference) {
            foreach ($allVariants as $variantKey => $variant) {
                if($variant->id == $variantId){
                    //Remove those variants that really have no related id's at all
                    if($variant->children->count() == $difference){
                        $allVariants->offsetUnset((string) $variantKey);
                        unset($comparison[$variantId]);
                    }
                }
            }
        }
        $selectedVariants = [];
        foreach ($comparison as $variantId => $difference) {
            foreach ($allVariants as $allVariantKey => $variant) {
                if($variant->id == $variantId){
                    //process all variants except the current
                    if($currentVariant->id != $variant->id){
                        if($currentVariant->children->count() == 0){
                            if($difference < 20 ){
                                $selectedVariants[$difference] = $variant;
                            }
                        }else if($currentVariant->children->count() >= 1){
                            if($difference == 0){
                                $selectedVariants[] = $variant;
                            }else{
                                $selectedVariants[$difference] = $variant;
                            }
                        }
                    }
                }
            }
        }
        ksort($selectedVariants);
        $mostRelevantCombos = [];
        foreach ($selectedVariants as $variant) {
            $mostRelevantCombos[] = $variant;
        }
        $uniqueNames = [];
        foreach ($mostRelevantCombos as $relevantCombo) {
            $uniqueNames[$relevantCombo->id] = $relevantCombo->name;
        }
        $uniqueNames = array_flip(array_unique($uniqueNames));
        //Now let's transform our relevant combos
        foreach ($mostRelevantCombos as $index => $mostRelevantCombo) {
            $mostRelevantCombo->load('product.productSets.type');
            //Get rid of repeated combos by checking their names
            if(!in_array($mostRelevantCombo->id, $uniqueNames) || $currentVariant->name == $mostRelevantCombo->name){
                unset($mostRelevantCombos[$index]);
            }
            $this->attachProductPrices($mostRelevantCombo);
            // Attach bundle breakdown as 'includes'
                $mostRelevantCombo['includes'] = $mostRelevantCombo->children->each(function ($child) {
                    $childAssets = $this->normalizeAssets($child->assets);
                    unset($child->assets);
                    $child['assets'] = $childAssets;
                    // set tranformation rules for bundle items
                    static::transformVariantChild($child, ['name', 'assets']);
                });
                $variantAssets = $this->normalizeAssets($mostRelevantCombo->assets);
                unset($mostRelevantCombo->assets);
                $mostRelevantCombo['assets'] = $variantAssets;
                // ProductSet Transformation for variants
                $productSets = [];
                $mostRelevantCombo->product->productSets->each(function($set) use (&$productSets){
                    $type = $this->slugify($set->type->name);
                    if(!isset($productSets[$type])){
                       $productSets[$type] = [];
                    }
                    $productSets[$type][] = $this->slugify($set->name);
                });
                unset($mostRelevantCombo->product);
                $mostRelevantCombo['product_sets'] = $productSets;
                // set transformation rules for variants
                static::transformVariant($mostRelevantCombo, ['product_sets', 'includes', 'assets', 'product_type_id', 'shippable', 'product_combo_count', 'sub_name']);
        }
        $comboCollection = new Collection($mostRelevantCombos);
        $comboCollectionSortedByChildren = $comboCollection->sortByDesc(function($combo, $key){
            return $combo->children->count();
        });
        return array_values($comboCollectionSortedByChildren->toArray());
    }

    /**
     * Scope method for specifying which product set to pull
     * validate product from
     *
     * @param  Illuminate\Database\Eloquent\Builder     $builder
     * @param  mixed    [$productSet = null]    Product Set ID or Instance
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeInProductSet($builder, $productSet = null)
    {
        // Is a product set specified?
        // Retrieve products from product set
        if (isset($productSet)) {
            // Is it already an instance for ProductSet?
            // assume it's an id if not and retrieve the actual product set
            if (!$productSet instanceof ProductSet) {
                // Force an error when product set is not found
                $productSet = ProductSet::findOrFail($productSet);
            }
        }

        // Do we have a channel and/or agent assigned?
        // Get the prduct set from the channel or agent
        elseif (isset($this->channel) && $this->channel->exists) {
            if (isset($this->agent) && $this->agent->exists && !$this->channel->override) {
                $productSet = ProductSet::find($this->agent->product_set_id) ?: null;
            } else {
                $productSet = ProductSet::find($this->channel->product_set_id) ?: null;
            }
        }

        // No product set specified?
        // Attempt to get default product set
        if (!$productSet) {
            // Force error if no defaults set
            $productSet = ProductSet::findOrFail(config('custom.defaultProductSet'));
        }

        return $productSet->products();
    }

    public function scopeEnabledOnly($query)
    {
        return $query->has('baseVariant')->whereHas('variants', function ($q) {
            $q->where('enabled', 1);
        })->where('enabled', 1);
    }

    public function scopeHasBaseVariant($query)
    {
        return $query->has('baseVariant');
    }

    /**
     * Get a single productSet by name or id
     *
     * @param string | int $id_or_name
     *
     * return array $sets
     *
     */
    public static function fetchProductSet($id_or_name, $type = null)
    {
        $set = isset($type) ?
            ProductSet::where('product_set_type_id', $type)->where(function ($query) use ($id_or_name) {
                $query
                ->where('id', $id_or_name)
                ->orWhere('name', $id_or_name);
            })-first() :
            ProductSet::where('id', $id_or_name)->orWhere('name', $id_or_name)->first();
        if ($set) {
            $set['slug'] = static::slugify($set->name);
            $set->setVisible([
                'id',
                'name',
                'slug'
            ]);
        }

        return json_decode(json_encode($set), true);
    }

    /**
     * Get All products that belong to a set or productSet
     *
     * @param string | int $id_or_name
     *
     * @return mixed
     */
    public function fetchProductsBySet($id_or_name)
    {
        $set = static::fetchProductSet($id_or_name);

        if (isset($set) && count($products = $this->hasBaseVariant()->enabledOnly()->inProductSet($set['id'])->index())) {
            return $products;
        }

        return [];
    }

    /**
     * Get all productSets by display status
     *
     * @param bool $publicOnly
     *
     * @return array $sets
     */
    public static function fetchProductSets($type = null)
    {
        if (isset($type)) {
            $sets = ProductSet::where('product_set_type_id', $type)
                ->orderBy(\DB::raw('-`sort_order`'), 'desc')->get();
        } else {
            $sets = ProductSet::all();
        }

        $sets->each(function ($set) {
            $set['slug'] = static::slugify($set->name);
            $set->setVisible([
                'id',
                'name',
                'slug'
            ]);
        });

        return json_decode(json_encode($sets), true);
    }

    /**
     * Get each productSet or set with products attached
     *
     * @param bool $publicOnly
     *
     * @return array $sets
     *
     */
    public function fetchProductsBySets($type = null)
    {
        $setList = static::fetchProductSets($type);

        $sets = [];
        foreach($setList as $set) {
            if (count($products = $this->hasBaseVariant()->enabledOnly()->inProductSet($set['id'])->index())) {
                $sets[$set['name']] = $products;
            }
        }

        return $sets;
    }

    /**
     * Scope method for specifying search words which the returned 
     * product variants should contain
     *
     * @param  Illuminate\Database\Eloquent\Builder     $builder
     * @param  mixed                                    $keywords
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($builder, $keywords)
    {   
        $keywords = is_array($keywords) ? $keywords : [$keywords];
        foreach ($keywords as $keyword) {
            $builder->where(function($query) use ($keyword){
                $query->where(function($qry) use($keyword){
                    $qry->where('name', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%");
                    })->orWhereHas('variants', function($q) use ($keyword){
                        $joinTable = $q->getModel()->getTable();
                        $q->where('product_variants.name', 'like', "%$keyword%");

                    })->orWhereHas('variants.children', function($q) use ($keyword){ 
                        $alias = explode(' as ', $q->getQuery()->from)[1];
                        $joinTable = $q->getModel()->getTable();
                        
                        $q->join('product_variants as variants', $alias.'.parent_id', '=', 'variants.id')
                            ->where('variants.name', 'like', "%$keyword%")
                            ->where('variants.enabled',1)
                            ->whereNull('variants.deleted_at');
                    });
                });

        }
        return $builder;
    }
}
