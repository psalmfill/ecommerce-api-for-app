<?php

namespace Api\v1\Repositories\Admin;

use App\Category;
use App\Traits\GenarateSlug;
use Api\BaseRepository;
use Api\v1\Transformers\CategoryTransformer;
use Api\v1\Transformers\SubCategoryTransformer;
use Illuminate\Http\Response;

class CategoriesRepository extends BaseRepository
{

    use GenarateSlug;

    private $category;
    private $categoryTransformer;
    private $subCategoryTransformer;

    public function __construct(Category $category, CategoryTransformer $categoryTransformer,
                                SubCategoryTransformer $subCategoryTransformer)
    {
        $this->category = $category;
        $this->categoryTransformer = $categoryTransformer;
        $this->subCategoryTransformer = $subCategoryTransformer;
    }

    /**
     * get all the 
     */
    public function getAll()
    {
        $categories = $this->category->where('parent_id',null)->paginate(15);
        return $this->response->paginator($categories, new $this->categoryTransformer);
    }

    /**
     * get all the 
     */
    public function getChildren($id)
    {
        $categories =  $this->category->where('parent_id',$id)->paginate(15);
        return $this->response->paginator($categories, new $this->subCategoryTransformer);
    }

    public function find($id)
    {

        return $this->response->paginator($this->category->findOrFail($id), new $this->categoryTransformer);
        
    }

    public function create($data)
    {
        // $data = (array) $data;
        $category = new $this->category($data);
        $category->slug = $this->createSlug($this->category, $data['name']);

        //TODO create image Upload script

        return $category->save() ? $this->response->item( $category, new $this->categoryTransformer)->setStatusCode(Response::HTTP_CREATED) : 
            $this->response->error;
    }

    public function update($id,$data)
    {
        $category = $this->category->findOrFail($id);
    
        $category->slug = $this->createSlug($this->category,$data['name'],$id);
        if($category->update($data))
            return $category;

        return 'Fail updating category';
    }

    public function delete($id)
    {

        if ($this->category->destroy($id))
            return 'Delete Success';

        return  'Fail deleting';
    }
}
