<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
       $buyers = $product->transactions()
           ->with('buyer')
           ->get()
           ->pluck('buyer')
           ->unique('id')
           ->values();
       return $this->showAll($buyers);
    }

}
