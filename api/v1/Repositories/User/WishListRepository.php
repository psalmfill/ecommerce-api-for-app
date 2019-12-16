<?php

namespace Api\v1\Repositories\User;

use App\Product;
use App\Traits\GenarateSlug;
use Api\BaseRepository;
use Api\v1\Transformers\ProductTransformer;
use App\User;
use App\WishList;

class WishListRepository extends BaseRepository
{

    use GenarateSlug;

    protected $wishList;

    protected $user;

    protected $productTransformer;

    public function __construct(User $user, WishList $wishList, ProductTransformer $productTransformer)
    {
        $this->wishList = $wishList;
        $this->user = $user;

        $this->productTransformer = $productTransformer;
    }

    public function getUserWishListItems()
    {
        $wishListItems = auth()->user()->wishListItems;
        return $wishListItems;

        return $this->response->collection($wishListItems, $this->productTransformer);
    }

    public function addToWishList($data)
    {
        $wishList = $this->wishList->where([
            ['user_id', auth()->user()->id],
            ['product_id', $data->product_id],
        ])->first();

        if ($wishList) {
            if (auth()->user()->wishListItems()->detach($data->product_id)) //$this->removeFromWishList($wishList->id);
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'Success removing from wishList'
                    ]
                );
        }

        auth()->user()->wishListItems()->attach($data->product_id);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Success adding item to wishList'
            ]
        );
    }

    public function removeFromWishList($id)
    {

        if ($this->wishList->destroy($id))
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Success removing from wishList'
                ]
            );
        response()->json(
            [
                'status' => 'error',
                'message' => 'Failed removing from wishList'
            ]
        );
    }
}
