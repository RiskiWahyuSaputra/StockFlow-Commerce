<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\StorefrontData;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __invoke(): View
    {
        return view('frontend.checkout.index', [
            'checkout' => StorefrontData::checkout(),
        ]);
    }
}
