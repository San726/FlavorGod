<?php

namespace Flavorgod\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Flavorgod\Http\Requests;
use Flavorgod\Http\Services\ShoppingCart;
use Flavorgod\Http\Controllers\Controller;
use Flavorgod\Services\ChannelAttribution;
use Flavorgod\Models\Eloquent\ProductSearch;
use Flavorgod\Models\Repository\ProductRepository;

class StoreController extends Controller
{

    /**
     * The repository where the data is coming from
     *
     * @var Flavorgod\Models\Repository\ProductRepository $repo
     */
    protected $repo;

    /**
     * Current store sub domain
     */
    protected $sub_domain;

     /**
     * Create a new instance of StoreController
     * @param Flavorgod\Models\Repository\ProductRepository $repo
     */

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Search filter
        if($search = $request->input('search')){
            $keywords = array_filter(explode(' ', str_replace(',', ' ', $search)));
        }
        else $keywords = array();

        // Fetch products available for this store
        $products
        = $this->repo
        ->inProductSet()
        ->search($keywords)
        ->setChannel($this->attrs->getChannelId())
        ->setAgent($this->attrs->getAgentId())
        ->enabledOnly()
        ->take(1000)
        ->index();

        $results_number = sizeof($products);

        // Log search
        if(!empty($search)){
            ProductSearch::create([
                'store_id' => $this->attrs->getChannelId(),
                'raw_search' => $search,
                'keywords' => json_encode($keywords),
                'results_number' => $results_number,
            ]);
        }

        // If search don't bring any results, fetch all
        if($results_number==0){
          $products
          = ProductRepository::inProductSet()
          ->setChannel($this->attrs->getChannelId())
          ->setAgent($this->attrs->getAgentId())
          ->enabledOnly()
          ->take(1000)
          ->index();
        }

        // Fetch product categories for the store prodcuts
        $productSets
        = $this->repo
        ->setChannel($this->attrs->getChannelId())
        ->inProductSet()
        ->fetchProductSets(2 /* Categories */);

        $this->setViewName('storeindex');
        $this->setTitleName('Shop');
        return view('store.index', compact('products', 'productSets', 'search', 'results_number'));
     }

     /**
      * Display all products by product set Name
      * @param string $productSetName
      * @return \Illuminate\Http\Response
      *
      */
      public function byProductSetName($name)
      {
        $productSetName = str_replace("-", " ", $name);

        if (($products = $this->repo->setChannel(1)->fetchProductsBySet($productSetName)) === null) {
            $products = [];
        }

        $this->setTitleName($productSetName);
        $this->setViewName('storecategory');
        return view('store.category.index', compact('products'));
      }


    /**
     * Display the specified resource
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ShoppingCart $shoppingCart, $id_or_slug)
    {
        try {
            $product = $this->repo->setChannel(1)->setAgent($this->attrs->getAgentId())->EnabledOnly()->fetchOrFail('slug', $id_or_slug);

        } catch (Exception $e) {
            if (is_null($product = $this->repo->setChannel(1)->EnabledOnly()->fetch($id_or_slug))) {
                return redirect('/');
            }
        }

        if (!empty($request->input('coupon'))) {
            $coupon_applied = $request->input('coupon');
        } else {
            foreach ($shoppingCart->getCart()['discounts'] as $discount) {
              if (!empty($discount['code']) && is_null($discount['deleted_at'])) {
                $coupon_applied = $discount['code']; //get cart first coupon
                break;
              }
            }
        }

        $featured
        = $this->repo
        ->inProductSet(23)
        ->enabledOnly()
        ->take(1000)
        ->index();

        $this->setViewName('storeindex');
        if (!\App::environment('production')) {
            $this->setTitleName('Product #'.str_pad($product['id'], 5, '0', STR_PAD_LEFT));
        }
        return view('store.show', compact('product', 'viewName', 'featured', 'coupon_applied'));
    }

    public function newProductPage(Request $request, ShoppingCart $shoppingCart, $id_or_slug)
    {
        try {
            $product = $this->repo->setChannel(1)->setAgent($this->attrs->getAgentId())->EnabledOnly()->fetchOrFail('slug', $id_or_slug);

        } catch (Exception $e) {
            if (is_null($product = $this->repo->setChannel(1)->EnabledOnly()->fetch($id_or_slug))) {
                return redirect('/');
            }
        }

        if (!empty($request->input('coupon'))) {
            $coupon_applied = $request->input('coupon');
        } else {
            foreach ($shoppingCart->getCart()['discounts'] as $discount) {
              if (!empty($discount['code']) && is_null($discount['deleted_at'])) {
                $coupon_applied = $discount['code']; //get cart first coupon
                break;
              }
            }
        }

        $featured
        = $this->repo
        ->inProductSet(23)
        ->enabledOnly()
        ->take(1000)
        ->index();

        $this->setViewName('storeindex');
        if (!\App::environment('production')) {
            $this->setTitleName('Product #'.str_pad($product['id'], 5, '0', STR_PAD_LEFT));
        }
        return view('store.newProductPage', compact('product', 'viewName', 'featured', 'coupon_applied'));
    }

}
