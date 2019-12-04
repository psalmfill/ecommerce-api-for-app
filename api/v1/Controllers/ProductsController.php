<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\v1\Repositories\User\ProductRepository;
use Api\BaseController;
use Api\v1\Repositories\Requests\ReviewRequest;

class ProductsController extends BaseController
{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->productRepository->getAll();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        return $this->productRepository->find($product_id);
    }

    public function productReview(ReviewRequest $request)
    {
        return $this->productRepository->productReview( $request->all());

    }
}
