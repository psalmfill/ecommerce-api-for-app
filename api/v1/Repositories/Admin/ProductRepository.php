<?php

namespace Api\v1\Repositories\Admin;

use App\Product;
use App\Traits\GenarateSlug;
use Api\BaseRepository;
use Api\v1\Transformers\ProductTransformer;
use App\Traits\FileUpload;
use Illuminate\Http\Response;

class ProductRepository extends BaseRepository
{
    use GenarateSlug, FileUpload;

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
        $products =  $this->product->query();
        /**
         * handle filter
         */
        $sort = request('sort_by');
        $dir = request('order');

        if ($sort && ($sort == 'price' || $sort == 'name'))
            $products = $products->orderBy($sort, $dir);

        $products = $products->paginate(15);

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
        $images = $data['images'];
        unset($data['images']);
        $product = new $this->product($data);
        $product->slug = $this->createSlug($this->product, $data['name']);
        if ($product->save()) {

            if (isset($images)) {

                $paths = $this->uploadMultipleFiles('products', $images);
                $allPaths = [];
                foreach ($paths as $path) {
                    array_push($allPaths, [
                        'url' => $path
                    ]);
                }
                $product->images()->createMany($allPaths);
            }
            return $this->response->item($product, new $this->productTransformer);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Cannot create product'
        ]);
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
        $productImages = $this->product->findOrFail($id)->images;
        if ($this->product->destroy($id))

            foreach ($productImages as $image) {
                $this->removeFile($image->url);
            }
        return $this->response->error('Success Deleting Product', Response::HTTP_OK);

        return  $this->response->error('Failed Deleting Product', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
