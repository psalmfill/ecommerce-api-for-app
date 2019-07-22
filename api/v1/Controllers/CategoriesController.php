<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\BaseController;
use Api\v1\Repositories\User\ProductRepository;
class CategoriesController extends BaseController
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
    public function index($id)
    {
        return $this->productRepository->productByCategory($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

}
