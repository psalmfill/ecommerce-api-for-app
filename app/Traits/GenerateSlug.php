<?php
namespace App\Traits;

trait GenarateSlug 
{
    public function createSlug($model, $title, $id = null)
    {
        // Normalize title
        $slug = str_slug($title);
        
        $allSlugs = $this->getRelatedslugs($model, $slug,$id);

        if(!$allSlugs->contains('slug',$slug))
            return $slug;

        //get old model slug
        
        if($id !=null && $allSlugs->count() >0 ){
            return  $this->getSlug($model, $id);
        }
        return $slug .'-' . $allSlugs->count();

    }

    public function getRelatedSlugs($model, $slug, $id=null)
    {
        return $model->select('slug')->where('slug','like',$slug.'%')
                    ->where('id','<>',$id)
                    ->get();
    }

    public function getSlug($model,$id) {
        return $model->find($id)->slug;
    }
}