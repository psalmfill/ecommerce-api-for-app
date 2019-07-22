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
            "description" => $product->description,
            "price" => $product->price,
            "discount" => $product->discount,
            'hasDiscount' => $product->discount !=0,
            "status" => $product->quantity?"In stock": "out of stock",
            "created" => ($product->created_at),
            "category" => $product->category,
        ];
    }
}
