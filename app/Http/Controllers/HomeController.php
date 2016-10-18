<?php

namespace Flavorgod\Http\Controllers;

use Cache;
use Instagram;
use Illuminate\Http\Request;
use Flavorgod\Http\Requests;
use Flavorgod\Http\Controllers\Controller;
use Flavorgod\Models\Repository\ProductRepository;
use Flavorgod\Models\Eloquent\ProductSet;
use Flavorgod\Accounts\Providers\Contracts\Provider;
use Flavorgod\Services\ChannelAttribution;

class HomeController extends Controller
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
     * Create a new instance of HomeController
     * @param Flavorgod\Models\Repository\ProductRepository $repo
     */
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }


    public function getLogin(Provider $provider)
    {
        return $provider->authorize();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        $product_cache_key = 'home_products_' . md5($request->fullUrl());
        $products = Cache::remember($product_cache_key, 60, function() {
            $products
            = $this->repo
            ->inProductSet()
            ->setChannel($this->attrs->getChannelId())
            ->setAgent($this->attrs->getAgentId())
            ->enabledOnly()
            ->take(1000)
            ->index();

            return $products;
        });

        // $productSets_cache_key = 'home_productSets_' . md5($request->fullUrl());
        // $productSets = Cache::remember($productSets_cache_key, 60, function() {
            $productSets
            = $this->repo
            ->setChannel($this->attrs->getChannelId())
            ->inProductSet()
            ->fetchProductSets(2 /* Categories */);

            foreach($productSets as &$prodSet){
                $prodSet['products'] = $this->repo
                                        ->hasBaseVariant()
                                        ->enabledOnly()
                                        ->inProductSet($prodSet['id'])
                                        ->index();
            }

        //     return $productSets;
        // });

        $this->setViewName('homeindex');
        $this->setTitleName('Products');
        //instagram feeds
        if(!Cache::has('instaThumbnails')){
            Cache::put('instaThumbnails', (array) Instagram::getUserMedia('262082626', 9), 20);
            $instaThumbnails = Cache::get('instaThumbnails');
        }else{
            $instaThumbnails = Cache::get('instaThumbnails');
        }

        return view('home.index', compact('products', 'productSets', 'instaThumbnails'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newHomePage(Request $request)
    {
        // Fetch products available for this store
        $products
        = $this->repo
        ->inProductSet()
        ->setChannel($this->attrs->getChannelId())
        ->setAgent($this->attrs->getAgentId())
        ->enabledOnly()
        ->take(1000)
        ->index();

        // Fetch product categories for the store prodcuts
        $productSets
        = $this->repo
        ->setChannel($this->attrs->getChannelId())
        ->inProductSet()
        ->fetchProductSets(2 /* Categories */);

        foreach($productSets as &$prodSet){
            $prodSet['products'] = $this->repo
                                    ->hasBaseVariant()
                                    ->enabledOnly()
                                    ->inProductSet($prodSet['id'])
                                    ->index();
        }
        
        array_unshift($productSets, array(
                                        'id'=>'all',
                                        'name'=>'All',
                                        'slug'=>'all',
                                        'products'=>$products
                                        )
        );

        $this->setViewName('homeindex');
        $this->setTitleName('Products');
        //instagram feeds
        if(!Cache::has('instaThumbnails')){
            Cache::put('instaThumbnails', (array) Instagram::getUserMedia('262082626', 9), 20);
            $instaThumbnails = Cache::get('instaThumbnails');
        }else{
            $instaThumbnails = Cache::get('instaThumbnails');
        }
        return view('home.newhomepage', compact('products', 'productSets', 'instaThumbnails'));
    }

    /**
     * Display the about page
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $this->setViewName('homeabout');
        $this->setTitleName('more about flavorgod');
        return view('home.about');
    }


    /**
     * Display the vipreview page
     *
     * @return \Illuminate\Http\Response
     */
    public function vipreview()
    {
        $this->setViewName('homeabout');
        $this->setTitleName('vip list');

        return view('home.vipreview');
    }

    /**
     * Display the vipreview page
     *
     * @return \Illuminate\Http\Response
     */
    public function postVipreview(Request $request)
    {
        $input = $request->all();
        $email_to = 'vipreview@flavorgod.com';
        $form_name = 'vipreview';

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'contact_phone' => 'required',
            'address_line1' => 'required',
            'address_city' => 'required',
            'address_zipcode' => 'required',
            'address_state' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('vipreview#form_error')
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            unset($input['_token']);

            Mail::send('home.vipreview-email-template', compact('input'), function($m) use ($email_to){
                $m->to($email_to)->subject('Flavorgod - Vipreview Form Data');
            });

            \DB::table('form_inputs')->insert(array(
                'form_name'=>$form_name, 
                'email_to'=>$email_to, 
                'json_response' => json_encode($input),
                'created_at' => Carbon::now()
                )
            );
        }

        return redirect('vipreview/submitted');
    }

    /**
     * Display the vipreview page 2
     *
     * @return \Illuminate\Http\Response
     */
    public function vipreviewThankyou()
    {
        $this->setViewName('homeabout');
        $this->setTitleName('vip list');
        return view('home.vipreview-thankyou');
    }

    /**
     * Display the page
     *
     * @return \Illuminate\Http\Response
     */
    public function rafPages($page)
    {
        $this->setViewName('homeabout');
        $this->setTitleName('manage my account');
        return view('raf.' . $page);
    }


    /**
     * Display the reviews page
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews()
    {   //instagram feeds
        if(!Cache::has('instaReviews')){
            Cache::put('instaReviews', (array) Instagram::getUserMedia('1733883886', 9), 20);
            $instaReviews = Cache::get('instaReviews');
        }else{
            $instaReviews = Cache::get('instaReviews');
        }
        $this->setViewName('homereviews');
        $this->setTitleName('consumer reviews');
        return view('home/reviews', compact('instaReviews'));
    }

    /**
     * Display the faqs page
     *
     * @return \Illuminate\Http\Response
     */
    public function faqs()
    {
        $this->setViewName('homefaqs');
        $this->setTitleName('common questions');
        return view('home/faqs');
    }

     /**
     * Display the contact page
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        $this->setViewName('homecontact');
        $this->setTitleName('contact flavorgod');
        return view('home/contact');
    }

    /**
     * Display the return policy page
     *
     * @return \Illuminate\Http\Response
     */
    public function returnpolicy()
    {
        $this->setViewName('homecontact');
        $this->setTitleName('return policy');
        return view('home/return');
    }

     /**
     * Display the terms page
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        $this->setViewName('hometerms');
        $this->setTitleName('terms and conditions');
        return view('home/terms');
    }

    /**
     * Display subscription policy page
     *
     * @return \Illuminate\Http\Response
     */
    public function subscriptionPolicy()
    {
        $this->setViewName('homesubscriptionpolicy');
        $this->setTitleName('subscription policy');
        return view('home/subscriptionpolicy');
    }

    /**
     * Display privacy policy page
     *
     * @return \Illuminate\Http\Response
     */
    public function privacyPolicy()
    {
        $this->setViewName('homeprivacypolicy');
        $this->setTitleName('privacy policy');
        return view('home/privacypolicy');
    }

     /**
     * Redirect to the correct thankyou page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function thankyou(Request $request)
    {
        $tx = $request->input('tx');
        return redirect()->to('http://dev.flavorgod.com/thankyou?tx=' . $tx);
    }








}
