<?php
namespace Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Product;

class ProductTransformer extends TransformerAbstract
{
    
    public function transform(Product $product)
    {
        return [
            "id" => $product->id,
            "name" => $product->name,
            "slug" => $product->slug,
            "description" => $product->description,
            "price" => $product->price,
            "discount" => $product->discount,
            'hasDiscount' => $product->discount !=0,
            "status" => $product->quantity?"In stock": "out of stock",
            "rating" => $product->rating,
            "total_sold" => $product->orders->count(),
            "created" => ($product->created_at),
            "category" => fractal($product->category,new CategoryTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer()),
        ];
    }
}
