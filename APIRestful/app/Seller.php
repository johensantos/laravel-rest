<?php

namespace App;

use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Model;
use App\Product;
class Seller extends User
{
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope());
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
