<?php
namespace Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Cart;

class CartTransformer extends TransformerAbstract
{
    
    public function transform(Cart $cart)
    {
        return [
            "id" => $cart->id,
            "product" => $cart->product,
            "quantity" => $cart->quantity,
            "created" => ($cart->created_at),
        ];
    }
}
