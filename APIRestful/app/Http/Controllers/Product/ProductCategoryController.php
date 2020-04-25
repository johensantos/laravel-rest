<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param Category $category
     * @return Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
        //opciones: sync, atach, syncwithoutbetachhing

        //SYNC ACTUALIZA TODA LA LISTA DE CATEGORIAS, POR LA CATEGORIA ENVIADA
        /*  $product->categories()->sync([$category->id]);*/

        //attach agrega una categoria mas, pero nos permite agregar la misma categoria muchas veces
        /*$product->categories()->attach([$category->id]); */

        //attach agrega una categoria mas, pero nos permite agregar la misma categoria muchas veces
        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param Category $category
     * @return Response
     * @throws \Exception
     */
    public function destroy(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('La categoría especificada no es una categoria de este producto', 404);
        }
        $product->categories()->detach([$category->id]);
        return $this->showAll($product->categories);

    }

}
