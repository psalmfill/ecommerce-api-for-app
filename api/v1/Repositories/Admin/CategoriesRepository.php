<?php

namespace Api\v1\Repositories\Admin;

use App\Category;
use App\Traits\GenarateSlug;
use Api\BaseRepository;
use Api\v1\Transformers\CategoryTransformer;
use Api\v1\Transformers\SubCategoryTransformer;
use App\Traits\FileUpload;
use Illuminate\Http\Response;

class CategoriesRepository extends BaseRepository
{

    use GenarateSlug, FileUpload;

    private $category;
    private $categoryTransformer;
    private $subCategoryTransformer;

    public function __construct(
        Category $category,
        CategoryTransformer $categoryTransformer,
        SubCategoryTransformer $subCategoryTransformer
    ) {
        $this->category = $category;
        $this->categoryTransformer = $categoryTransformer;
        $this->subCategoryTransformer = $subCategoryTransformer;
    }

    /**
     * get all the 
     */
    public function getAll()
    {
        $categories = $this->category->where('parent_id', null)->paginate(15);
        return $this->response->paginator($categories, new $this->categoryTransformer);
    }

    /**
     * get all the 
     */
    public function getChildren($id)
    {
        $categories =  $this->category->where('parent_id', $id)->paginate(15);
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


        if ($category->save()) {
            if(isset($data['image'])){
                $image = $this->uploadSingleFile('categories',$data['image']);
                $category->image()->create(['url' => $image]);
            }
           return $this->response->item($category, new $this->categoryTransformer)->setStatusCode(Response::HTTP_CREATED);
        }
        return  $this->response->error;
    }

    public function update($id, $data)
    {
        $category = $this->category->findOrFail($id);

        $category->slug = $this->createSlug($this->category, $data['name'], $id);
        if ($category->update($data))
            return fractal($category, new $this->categoryTransformer);

        return $this->response()->error("Failure updating Category",Response::HTTP_BAD_REQUEST);
    }

    public function delete($id)
    {

        if ($this->category->destroy($id))
            return response()->json([
                'message' => 'Category deleted successfully'
            ],Response::HTTP_OK);

        return  $this->response()->error("Failure updating Category",Response::HTTP_BAD_REQUEST);
    }
}
