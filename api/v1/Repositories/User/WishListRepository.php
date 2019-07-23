<?php

namespace Api\v1\Repositories\User;

use App\Product;
use App\Traits\GenarateSlug;
use Api\BaseRepository;
use App\User;
use App\WishList;
use Api\v1\Transformers\WishListTransformer;

class WishListRepository extends BaseRepository
{

    use GenarateSlug;

    protected $wishList;

    protected $user;

    protected $productTransformer;

    public function __construct(User $user, WishList $wishList, WishListTransformer $productTransformer)
    {
        $this->wishList = $wishList;
        $this->user = $user;

        $this->productTransformer = $productTransformer;
    }

    public function getUserWishListItems($id)
    {
        $wishListItems = $this->wishList->where('user_id', $id)->get();

        return fractal($wishListItems, $this->productTransformer);
    }

    public function addToWishList($data)
    {
        $wishList = $this->wishList->where([
            ['user_id', $data->user_id],
            ['product_id', $data->product_id],
        ])->first();

        if ($wishList) {
            return   $this->removeFromWishList($wishList->id);
        }
        $wishList = new $this->wishList($data->all());
        // $wishList->product_id = $data->product_id;
        // $wishList->user_id = $data->user_id;

        if ($wishList->save())
            return fractal($wishList, $this->productTransformer);
        return response()->json(
            [
                'status' => 'error',
                'message' => 'Failed adding to wishList'
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
