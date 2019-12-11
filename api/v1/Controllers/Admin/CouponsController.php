<?php

namespace Api\v1\Controllers\Admin;

use Api\BaseController;
use Api\v1\Repositories\Admin\CouponsRepository;
use Api\v1\Repositories\Requests\CouponRequest;

class CouponsController extends BaseController
{
    private $couponsRepository;

    public function __construct(CouponsRepository $couponsRepository)
    {
        $this->couponsRepository = $couponsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->couponsRepository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        return $this->couponsRepository->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->couponsRepository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, $id)
    {
        return $this->couponsRepository->update($id,$request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->couponsRepository->delete($id);
    }
}
