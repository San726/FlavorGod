<?php

namespace Flavorgod\Http\Controllers;

use Crypt;
use Auth;
use Illuminate\Http\Request;
use Flavorgod\Models\Eloquent\ProductSet;
use Flavorgod\Services\ChannelAttribution;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    protected $attrs;

    protected $mainReferer;

    protected $featuredLinks = [
        [
            'slug' => 'vip',
            'name' => 'Join the VIP list'
        ]
    ];

    public function __construct()
    {
        $this->attrs = new ChannelAttribution;
        $this->attrs->setReferer($_SERVER['HTTP_HOST']);
        $store = $this->attrs->getChannel();
        $store->load('assets');
        view()->share('store', $store);
    	$this->user = Auth::user();
      
    	view()->share('signedIn', Auth::check());
    	view()->share('user', $this->user);
    	view()->share('featuredLinks', $this->featuredLinks);
    	view()->share('productCategories', ProductSet::where('product_set_type_id', 2)->orderBy(\DB::raw('-`sort_order`'), 'desc')->get()->each(function ($category) {
    	    $category['slug'] = strtolower(preg_replace('/[^0-9a-z]+/i', '-', $category->name));
    	    $category->setVisible(['id', 'name', 'slug']);
    	})->toArray());

    	if ($alert = \Session::pull('sweet_alert.alert')) {
    	    view()->share('alert', json_decode($alert, true));
    	}
        $this->mainReferer = env('MAIN_URL');
        $userIdentity = Auth::check() ? Auth::user()->payer_email : \Session::getId();
        view()->share('userIdentity', Crypt::encrypt(json_encode($userIdentity)));
        view()->share('mainUrl', $this->mainReferer);

    }

    /**
     * Set the viewName variable shared in the views
     */
    public function setViewName($viewName)
    {
        if (isset($viewName)) {
            view()->share('viewName', $viewName);
        }
    }

    /**
     * Set the title variable shared in the views
     */
    public function setTitleName($title)
    {
        if(isset($title)){
            view()->share('title', $title);
        }
    }


    /**
     * Set the featured links to share with the views
     *
     * @param  array    $links  Featured links array to replace the default value
     * @return $this
     */
    public function setFeaturedLinks(array $links = [])
    {
        $this->featuredLinks = $links;
        // Reset the value of the shared variable
        view()->share('featuredLinks', $this->featuredLinks);

        return $this;
    }

    /**
     * Get the assigned featuredLinks
     *
     * @return array
     */
    public function getFeaturedLinks()
    {
        return $this->featuredLinks;
    }

    /**
     * Add a featured link or links
     *
     * @param  mixed    $url    Url or array of featured Links
     * @param  string   [$title = ''] Title of the url
     * @return $this
     */
    public function addFeaturedLink($url, $title = '')
    {
        if (is_array($url)) {
            $this->featuredLinks = array_merge($url, $this->featuredLinks);
        } else {
            array_unshift($this->featuredLinks, compact('url', 'title'));
        }
        // Reset the value of the shared variable
        view()->share('featuredLinks', $this->featuredLinks);

        return $this;
    }

}
