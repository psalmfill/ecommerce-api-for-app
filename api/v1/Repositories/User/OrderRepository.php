<?php

namespace Api\v1\Repositories\User;

use App\Product;
use Api\BaseRepository;
use App\User;
use App\Order;
use Api\v1\Transformers\OrderTransformer;
use App\Notifications\OrderCancelled;
use App\Notifications\OrderCompleted;
use Illuminate\Http\Response;

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

                //Created order history
                $order->history()->create([
                    'comment' => 'New order created',
                    'user_id' => auth()->user()->id
                ]);

                auth()->user()->notify(new OrderCompleted($order));
      
            }
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'order completed'
            ]
        );
    }

    public function cancelOrder($order_id)
    {
        $order = $this->order_>findOrFail($order_id);
        if($order->user_id === auth()->user()->id)
        {
            
            if($order->update(['status'=>'cancelled']))
            {
                //created an order history
                $order->history()->create([
                    'comment' => 'order was cancelled',
                    'user_id' => auth()->user()->id
                ]);

                auth()->user()->notify(new OrderCancelled($order));


                return response()->json([
                    'status' => 'success',
                    'message' => 'Order cancel successfully'
                ],200);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Fail to cancel order'
            ]);
        }
        return response()->json([
            'status'=> 'error',
            'message' => 'You don\'t have the permission to cancel this order'
        ],Response::HTTP_FORBIDDEN);
    }
}
