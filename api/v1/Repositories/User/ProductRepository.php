<?php

namespace Api\v1\Repositories\User;

use App\Product;
use App\Traits\GenarateSlug;
use Api\v1\Transformers\ProductTransformer;
use Api\BaseRepository;
use App\Category;
use App\Review;
use Api\v1\Transformers\ProductWithReviewsTransformer;
use Illuminate\Http\Request;
use Api\v1\Transformers\ReviewTransformer;
use Illuminate\Http\Response;

class ProductRepository extends BaseRepository
{

    use GenarateSlug;

    private $product;
    private $productTransformer;
    private $category;
    private $review;
    public function __construct(Product $product,Review $review,Category $category, ProductTransformer $productTransformer)
    {
        $this->product = $product;
        $this->category = $category;
        $this->productTransformer = $productTransformer;
        $this->review = $review;
    }

    /**
     * get all the 
     */
    public function getAll()
    {   $products =  $this->product->query();
        /**
         * handle pr
         */
        $sort = request('sort_by');
        $dir = request('dir');
         if( $sort && ($sort == 'price' || $sort == 'name'))
            $products = $products->orderBy($sort,$dir);
        
      $products = $products->paginate(15);
      return $products;
        $products =  $this->transformCollection($products, $this->productTransformer);
        return $this->createSerilizer($products);
    
    }

    public function find($id)
    {
        return  $this->response->item($this->product->findOrFail($id), new ProductWithReviewsTransformer());

    }

    public function productByCategory($id)
    {
        $products = $this->product->query();
        $products = $products->where('category_id',$id);
        $sort = request('sort_by');
        $dir = request('dir');
         if( $sort && ($sort == 'price' || $sort == 'name'))
            $products = $products->orderBy($sort,$dir);


        $products = $products->paginate(12);

        return $this->response->paginator($products, $this->productTransformer)->addMeta('status_code',Response::HTTP_OK);
    }

    public function productReview($data)
    {
        if($this->review->where([
            ['user_id',$data['user_id']],
            ['product_id',$data['product_id']],
        ])->first())
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'You have already reviewed this product',
                ]
                );
       $review = new $this->review($data);
       
       if($review->save())
            return $this->response->item($review, new ReviewTransformer());
       
    }

}
