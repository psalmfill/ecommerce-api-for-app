<?php
namespace Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Review;

class ReviewTransformer extends TransformerAbstract
{
    
    public function transform(Review $review)
    {
        return [
            "id" => $review->id,
            "body" => $review->body,
            "rating" => $review->rating,
            "created" => ($review->created_at),
            "user" => fractal($review->user,new UserTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer()),
        ];
    }
}
