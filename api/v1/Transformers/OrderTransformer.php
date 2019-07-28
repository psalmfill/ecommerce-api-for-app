<?php

namespace Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Order;

class OrderTransformer extends TransformerAbstract
{

    public function transform(Order $order)
    {
        return [
            "id" => $order->id,
            "product" => fractal($order->product,new ProductTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer()),
            "quantity" => $order->quantity,
            "price"    => $order->price,
            "total_price" => $order->total,
            "created" => ($order->created_at),
        ];
    }
}
