<?php

namespace Api\v1\Repositories\User;

use App\Product;
use App\Traits\GenarateSlug;
use Api\v1\Transformers\ProductTransformer;
use Api\BaseRepository;
use App\Category;

class ProductRepository extends BaseRepository
{

    use GenarateSlug;

    private $product;
    private $productransformer;
    private $category;

    public function __construct(Product $product,Category $category, ProductTransformer $productTransformer)
    {
        $this->product = $product;
        $this->category = $category;
        $this->productransformer = $productTransformer;
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
        return  fractal($this->product->findOrFail($id), $this->productransformer);

    }

    public function productByCategory($id)
    {
        $products = $this->category->find($id)->products;

        return fractal($products, $this->productransformer);
    }

}
