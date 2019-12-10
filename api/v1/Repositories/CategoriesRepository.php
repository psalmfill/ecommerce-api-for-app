<?php

namespace Api\v1\Repositories;

use App\Role;
use App\Product;
use Api\BaseRepository;
use Api\v1\Transformers\CategoryTransformer;
use Api\v1\Transformers\ProductTransformer;
use Api\v1\Transformers\SubCategoryTransformer;
use App\Category;
use App\Traits\GenarateSlug;
use Illuminate\Http\Response;

class CategoriesRepository extends BaseRepository
{
    private $product;

    private $productTransformer;

    private $category;

    private $categoryTransformer;

    private $subCategoryTransformer;
    

    public function __construct(Product $product, Category $category, ProductTransformer $productTransformer,
                            CategoryTransformer $categoryTransformer,
                            SubCategoryTransformer $subCategoryTransformer)
    {
        $this->product = $product;
        $this->category = $category;
        $this->productTransformer = $productTransformer;
        $this->categoryTransformer = $categoryTransformer;
        $this->subCategoryTransformer = $subCategoryTransformer;
    }

    public function getAll()
    {
        $categories = $this->category->noSubCategories();
        return fractal($categories, new $this->categoryTransformer);
    }

    public function getSubCategory($id)
    {
        $subCategories = $this->category->subCategories($id);
        return  fractal($subCategories, new $this->subCategoryTransformer);
    }
}
