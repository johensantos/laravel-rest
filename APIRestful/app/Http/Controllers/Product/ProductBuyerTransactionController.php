<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{

    public function store(Request $request, Product $product, User $user)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];
        $this->validate($request, $rules);

        if ($user->id == $product->seller_id) {
            return $this->errorResponse('El comprador debe ser diferente al vendedor', 409);
        }
        dd($user->verified);
        if (!$user->esVerificado()) {
            return $this->errorResponse('El comprador debe ser un usuario verificado', 409);
        }
        if ($product->seller->esVerificado()) {
            return $this->errorResponse('El Vendedor debe ser un usuario verificado', 409);
        }
        if ($product->estaDisponible()) {
            return $this->errorResponse('el producto para esta transacción no está disponible', 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('El producto no tiene la cantidad disponible requerida para esta transacción', 409);
        }
        return DB::transaction(function () use ($request, $product, $user) {
            $product->quantity -= $request->quantity;
            $product->save();
            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return $this->showOne($transaction, 201);
        });
    }

}
