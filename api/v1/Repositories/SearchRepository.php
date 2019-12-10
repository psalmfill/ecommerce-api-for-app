<?php

namespace Api\v1\Repositories;

use App\Role;
use App\Product;
use Api\BaseRepository;
use Api\v1\Transformers\ProductTransformer;
use App\Category;
use App\Traits\GenarateSlug;
use Illuminate\Http\Response;

class SearchRepository extends BaseRepository
{
    private $product;

    private $productTransformer;

    private $category;

    public function __construct(Product $product, Category $category, ProductTransformer $productTransformer)
    {
        $this->product = $product;
        $this->category = $category;
        $this->productTransformer = $productTransformer;
    }

    public function searchProduct()
    {
        $queries = (object) request()->query();
        $products = $this->product->query();
        $products = $products->where('name', 'like', '%' . $queries->q . '%');
        if (isset($queries->category_id))
            $products = $products->where('category_id', $queries->category_id);


        if ($queries->sort_by)
            $products = $products->orderBy($queries->sort_by, $queries->order);


        $products = $products->paginate(20);

        return $this->response->paginator($products, $this->productTransformer)->addMeta('status_code', Response::HTTP_OK);
    }
}
