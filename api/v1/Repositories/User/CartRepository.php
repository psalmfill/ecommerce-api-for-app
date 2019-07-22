<?php

namespace Api\v1\Repositories\User;

use App\Product;
use App\Traits\GenarateSlug;
use Api\BaseRepository;
use App\User;
use App\Cart;
use Api\v1\Transformers\CartTransformer;

class CartRepository extends BaseRepository
{

    use GenarateSlug;

    protected $cart;

    protected $user;

    protected $cartTransformer;

    public function __construct(User $user, Cart $cart, CartTransformer $cartTransformer)
    {
        $this->cart = $cart;
        $this->user = $user;

        $this->cartTransformer = $cartTransformer;
    }

    public function getUserCartItems($id)
    {
        $cartItems = $this->cart->where('user_id',$id)->get();

        return fractal($cartItems, $this->cartTransformer);
        // return $this->us
    }

    public function addToCart($data)
    {
        $cart = $this->cart->where([
            ['user_id', $data->user_id],
            ['product_id', $data->product_id],
        ])->first();

        if ($cart) {
            return   $this->updateCart($cart->id, $data);
        }
        $cart = new $this->cart;
        $cart->product_id = $data->product_id;
        $cart->user_id = $data->user_id;
        $cart->quantity = $data->quantity;
        if ($cart->save())
            return fractal($cart, $this->cartTransformer);
        return response()->json(
            [
                'status' => 'error',
                'message' => 'Failed adding to cart'
            ]
        );
    }

    public function updateCart($id, $data)
    {
        $cart = $this->cart->find($id);

        if ($cart->update(['quantity' => $data['quantity']]))
            return fractal($cart, $this->cartTransformer);

        return response()->json(
            [
                'status' => 'error',
                'message' => 'Failed updating cart'
            ]
        );
    }

    public function removeFromCart($id)
    {

        if ($this->cart->destroy($id))
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Success removing from cart'
                ]
            );
        response()->json(
            [
                'status' => 'error',
                'message' => 'Failed removing from cart'
            ]
        );
    }
}
