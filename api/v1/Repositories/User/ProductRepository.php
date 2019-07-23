<?php

namespace Api\v1\Repositories\User;

use App\Product;
use App\Traits\GenarateSlug;
use Api\v1\Transformers\ProductTransformer;
use Api\BaseRepository;
use App\Category;
use App\Review;
use Api\v1\Transformers\ProductWithReviewsTransformer;

class ProductRepository extends BaseRepository
{

    use GenarateSlug;

    private $product;
    private $productransformer;
    private $category;
    private $review;
    public function __construct(Product $product,Review $review,Category $category, ProductTransformer $productTransformer)
    {
        $this->product = $product;
        $this->category = $category;
        $this->productransformer = $productTransformer;
        $this->review = $review;
    }

    /**
     * get all the 
     */
    public function getAll()
    {
       $products =  $this->product->paginate(15);
        $products =  $this->transformCollection($products, $this->productransformer);
        return $this->createSerilizer($products);
    
    }

    public function find($id)
    {
        return  fractal($this->product->findOrFail($id), new ProductWithReviewsTransformer());

    }

    public function productByCategory($id)
    {
        $products = $this->category->find($id)->products;

        return fractal($products, $this->productransformer);
    }

    public function productReview($data)
    {
        if($this->product->where([
            ['user_id',$data['user_id']],
            ['product_id',$data['product_id']],
        ]))
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'You have already reviewed this product',
                ]
                );
       $review = new $this->review($data);
       
       if($review->save())
            return $review;
       
    }

}
