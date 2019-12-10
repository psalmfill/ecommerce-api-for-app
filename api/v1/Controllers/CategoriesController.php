<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\BaseController;
use Api\v1\Repositories\CategoriesRepository;
use Api\v1\Repositories\User\ProductRepository;

class CategoriesController extends BaseController
{
    private $productRepository;

    private $categoriesRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoriesRepository $categoriesRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoriesRepository = $categoriesRepository;
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

    public function getAll()
    { 
        return $this->categoriesRepository->getAll();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->categoriesRepository->getSubCategory($id);        
    }
}
