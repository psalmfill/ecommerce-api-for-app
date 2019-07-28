<?php

namespace Api\v1\Repositories\Admin;

use App\Product;
use App\Traits\GenarateSlug;
use Api\BaseRepository;
use Api\v1\Transformers\ProductTransformer;
use Illuminate\Http\Response;

class ProductRepository extends BaseRepository
{

    use GenarateSlug;

    private $product;
    private $productTransformer;

    public function __construct(Product $product, ProductTransformer $productTransformer)
    {
        $this->product = $product;
        $this->productTransformer = $productTransformer;
    }

    /**
     * get all the 
     */
    public function getAll()
    {
        $products = $this->product->paginate(15);
        return  $this->response->paginator($products, new $this->productTransformer);
    }

    public function find($id)
    {

        $product = $this->product->findOrFail($id);
        return  $this->response->item($product, new $this->productTransformer)->setStatusCode(200);
    }

    public function create($data)
    {
        $data = (array) $data;
        $product = new $this->product($data);
        $product->slug = $this->createSlug($this->product, $data['name']);

        //TODO create image Upload script

        return $product->save() ? $this->response->item($product, new $this->productTransformer) : false;
    }

    public function update($id, $data)
    {
        $product = $this->product->findOrFail($id);

        $product->slug = $this->createSlug($this->product, $data['name'], $id);
        $product->old_price = $product->price;
        if ($product->update($data))
            return $this->response->item($product, new $this->productTransformer);
    }

    public function delete($id)
    {

        if ($this->product->destroy($id))
            return $this->response->error('Success Deleting Product',Response::HTTP_OK);

        return  $this->response->error('Failed Deleting Product',Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
