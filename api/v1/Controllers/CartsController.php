<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\v1\Repositories\User\CartRepository;
use Api\BaseController;
use Api\v1\Repositories\Requests\CartRequest;

class CartsController extends BaseController
{
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
      $this->cartRepository = $cartRepository;  
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->cartRepository->getUserCartItems();
    }

   
    public function show($id)
    {
        //
    }

    public function store(CartRequest $request)
    {
        return $this->cartRepository->addToCart($request);
    }

    public function removeFromCart($id)
    {
        return $this->cartRepository->removeFromCart($id);
    }

}
