<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\BaseController;
use Api\v1\Repositories\User\OrderRepository;

class OrdersController extends BaseController
{
    protected $orderRepository;
    
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getUserOrders($id)
    {
        return $this->orderRepository->getUserOrderItems($id);
    }

    public function createOrder(Request $request)
    {
        return $this->orderRepository->createOrder($request->all());
    }
}
