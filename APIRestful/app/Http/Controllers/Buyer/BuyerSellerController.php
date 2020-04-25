<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Buyer $buyer
     * @return void
     */
    public function index(Buyer $buyer)
    {
      /*Puede ser, pero solo necesitamos los sellers
       * $sellers = $buyer->transactions()
          ->with('product.seller')->get();*/

        $sellers = $buyer->transactions()
            ->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values();
//CON VALUES LIMPIAMOS LA COLECCION DE ELEMNTOS VACIOS

      return $this->showAll($sellers);

    }

}
