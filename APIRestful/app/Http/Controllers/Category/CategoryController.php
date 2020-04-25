<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];
        $this->validate($request, $rules);
        $category = Category::create($request->all());
        return $this->showOne($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @return Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Category $category
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->only([
            'name',
            'description'
        ]));
        if ($category->isClean()) {
            return $this->errorResponse('Debe esepecificar al menos un valor diferente para actualizar', 422);
        }
        $category->save();
        return $this->showOne($category);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);

    }
}
