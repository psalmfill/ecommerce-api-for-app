<?php
namespace Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Category;

class SubCategoryTransformer extends TransformerAbstract
{
    
    public function transform(Category $category)
    {
        return [
            "id" => $category->id,
            "name" => $category->name,
            "description" => $category->description,
            "created" => ($category->created_at),
            "category" => fractal($category->parent,new CategoryTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer()),
        ];
    }
}
