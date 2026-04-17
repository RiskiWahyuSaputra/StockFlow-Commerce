<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
    ) {
    }

    public function index(Request $request): View
    {
        return view('frontend.cart.index', [
            'cart' => $this->cartService->getActiveCart($request->user()),
        ]);
    }
}
