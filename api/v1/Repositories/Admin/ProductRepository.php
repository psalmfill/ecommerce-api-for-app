<?php

namespace Api\v1\Repositories\Admin;

use App\Product;
use App\Traits\GenarateSlug;
use Api\BaseRepository;

class ProductRepository extends BaseRepository
{

    use GenarateSlug;

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * get all the 
     */
    public function getAll()
    {
        return $this->product->paginate(15);
    }

    public function find($id)
    {

        return $this->product->findOrFail($id);
    }

    public function create($data)
    {
        $data = (array) $data;
        $product = new $this->product($data);
        $product->slug = $this->createSlug($this->product, $data['name']);

        //TODO create image Upload script

        return $product->save() ? $product : false;
    }

    public function update($id,$data)
    {
        $product = $this->product->find($id);
    
        $product->slug = $this->createSlug($this->product,$data['name'],$id);
        $product->old_price = $product->price;
        if($product->update($data))
            return $product;

        return 'Fail updating product';
    }

    public function delete($id)
    {

        if ($this->product->destroy($id))
            return 'Delete Success';

        return  'Fail deleting';
    }
}
