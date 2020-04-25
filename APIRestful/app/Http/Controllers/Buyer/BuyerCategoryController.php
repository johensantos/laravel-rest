<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
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

        $categories = $buyer->transactions()
            ->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse()
            ->unique('id')
            ->values();
//CON VALUES LIMPIAMOS LA COLECCION DE ELEMNTOS VACIOS

        return $this->showAll($categories);
    }

}
