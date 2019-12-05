<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\BaseController;
use Api\v1\Repositories\Requests\OrderRequest;
use Api\v1\Repositories\User\OrderRepository;

class OrdersController extends BaseController
{
    protected $orderRepository;
    
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getUserOrders()
    {
        return $this->orderRepository->getUserOrderItems();
    }

    public function createOrder(OrderRequest $request)
    {
        return $this->orderRepository->createOrder($request->all());
    }

    /**
     * User can Cancel order
     *
     * @param Request $request
     * @param [type] $order_id
     * @return void
     */
    public function cancelOrder(Request $request,$order_id)
    {
        return $this->orderRepository->cancelOrder($order_id);
    }
}
