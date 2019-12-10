<?php
namespace Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Product;
use Illuminate\Support\Facades\Storage;

class ProductWithReviewsTransformer extends TransformerAbstract
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
            "rating" => $product->rating,
            "total_sold" => $product->orders->count(),
            "images" =>  $this->formatImages($product->images),
            "reviews"=> fractal($product->reviews,new ReviewTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer()),
            "created" => ($product->created_at),
            "category" => fractal($product->category,new CategoryTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer()),
        ];
    }

    private function formatImages($images)
    {
        $imagesArray = [];
        foreach ($images as $image) {
            array_push($imagesArray, asset(Storage::url($image->url)));
        }
        return $imagesArray;
    }
}
