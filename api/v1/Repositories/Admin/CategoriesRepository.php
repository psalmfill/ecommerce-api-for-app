<?php

namespace Api\v1\Repositories\Admin;

use App\Category;
use App\Traits\GenarateSlug;
use Api\BaseRepository;

class CategoriesRepository extends BaseRepository
{

    use GenarateSlug;

    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * get all the 
     */
    public function getAll()
    {
        return $this->category->where('parent_id',null)->paginate(15);
    }

    /**
     * get all the 
     */
    public function getChildren($id)
    {
        return $this->category->where('parent_id',$id)->paginate(15);
    }

    public function find($id)
    {

        return $this->category->findOrFail($id);
    }

    public function create($data)
    {
        $data = (array) $data;
        $category = new $this->category($data);
        $category->slug = $this->createSlug($this->category, $data['name']);

        //TODO create image Upload script

        return $category->save() ? $category : false;
    }

    public function update($id,$data)
    {
        $category = $this->category->find($id);
    
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
