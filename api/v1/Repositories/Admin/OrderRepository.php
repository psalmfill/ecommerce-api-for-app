<?php

namespace Api\v1\Repositories\Admin;

use App\Product;
use Api\BaseRepository;
use App\User;
use App\Order;
use Api\v1\Transformers\OrderTransformer;

class OrderRepository extends BaseRepository
{


    protected $order;

    protected $user;

    protected $orderTransformer;

    public function __construct(User $user, Order $order, OrderTransformer $orderTransformer)
    {
        $this->order = $order;
        $this->user = $user;

        $this->orderTransformer = $orderTransformer;
    }

    public function getUserOrderItems($id)
    {
        $orderItems = $this->order->where('user_id', $id)->get();

        return fractal($orderItems, $this->orderTransformer);
    }

    public function createOrder($data)
    {
        $order = new $this->order($data);
        // $order->product_id = $data->product_id;
        // $order->user_id = $data->user_id;
        // $order->quantity = $data->quantity;
        // $order->price = $data->price;
        if ($order->save())
            return fractal($order, $this->orderTransformer);
        return response()->json(
            [
                'status' => 'error',
                'message' => 'Failed adding to order'
            ]
        );
    }

    public function cancelOrder($order_id)
    {
        $order = $this->order_ > findOrFail($order_id);

        if ($order->update(['status' => 'cancelled'])) {
            
            return response()->json([
                'status' => 'success',
                'message' => 'Order cancel successfully'
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Fail to cancel order'
        ]);
    }

    public function shipOrder($order_id, $shipping_details)
    {
        //TODO algorithm to ship product
    }

    public function deliverOrder($order_id)
    {
        $order = $this->order_ > findOrFail($order_id);

        if ($order->update(['status' => 'delivered'])) {

             //created an order history
             $order->history()->create([
                'comment' => 'rder has been delivered ',
                'user_id' => auth()->user()->id
            ]);

            
            return response()->json([
                'status' => 'success',
                'message' => 'Your order has been delivered successfully'
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Fail to cancel order'
        ]);
    }

    
}
