<?php

namespace Api\v1\Repositories\User;

use App\Product;
use Api\BaseRepository;
use App\User;
use App\Order;
use Api\v1\Transformers\OrderTransformer;

class OrderRepository extends BaseRepository
{


    protected $order;

    protected $user;

    protected $product;

    protected $orderTransformer;

    public function __construct(User $user, Order $order, OrderTransformer $orderTransformer, Product $product)
    {
        $this->order = $order;
        $this->user = $user;

        $this->orderTransformer = $orderTransformer;

        $this->product = $product;
    }

    public function getUserOrderItems()
    {
        $orderItems = $this->order->where('user_id', \auth()->user()->id)->get();

        return fractal($orderItems, $this->orderTransformer);
    }

    public function createOrder($data)
    {
        $data = (object) $data;
        foreach ($data->products as $product) {
            $product = (object) $product;

            $order = new $this->order();
            $order->user_id = auth()->user()->id;
            $order->product_id = $product->id;
            $order->quantity = $product->quantity;
            $order->price = $product->price;
            if ($order->save()) {
                //remve product from cart items
                auth()->user()->cartItems()->detach($product->id);
                
                //update the product stock
                $pro = $this->product->find($product->id);
                $pro->stock = $pro->stock - $product->quantity;
                $pro->save();
            }
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'order completed'
            ]
        );
    }
}
