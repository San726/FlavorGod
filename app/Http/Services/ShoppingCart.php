<?php

namespace Flavorgod\Http\Services;

use Auth;
use Flavorgod\Models\Repository\CartRepository;
use Illuminate\Http\Request;
use Exception;
use Log;

class ShoppingCart {

    protected $repo;

    public function __construct(CartRepository $repo, Request $request) {
        $sid = Auth::check() ? Auth::user()->payer_email : $request->session()->getId();
        $this->repo = $repo;
        $this->repo->setSessionId($sid);
    }

    public function getCart()
    {
        return $this->repo->fetch();
    }

    public function getCartQuantity()
    {
        $cart = $this->repo->fetch();

        return $cart['item_count'];
    }

}