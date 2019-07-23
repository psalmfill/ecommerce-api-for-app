<?php
namespace Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use App\WishList;
use League\Fractal;
class WishListTransformer extends TransformerAbstract
{
    
    public function transform(WishList $wishList)
    {
        return [
            "id" => $wishList->id,
            "product" => fractal($wishList->product,new ProductTransformer)->serializeWith(new \Spatie\Fractalistic\ArraySerializer()),
            "created" => ($wishList->created_at),
        ];
        // Fractal
    }
}
