<?php

namespace Api\v1\Repositories\Admin;

use App\Traits\GenarateSlug;
use Api\BaseRepository;
use App\Coupon;
use Illuminate\Http\Response;

class CouponsRepository extends BaseRepository
{

    use GenarateSlug;

    private $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * get all the 
     */
    public function getAll()
    {
        $coupons = $this->coupon->all();
        return response()->json([
            'status' => 'success',
            'data' => $coupons
        ], 200);
    }


    public function find($id)
    {

        $coupon = $this->coupon->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $coupon
        ], 200);
    }

    public function create($data)
    {
        $data = (array) $data;
        $coupon = new $this->coupon($data);
        $coupon->slug = $this->createSlug($this->coupon, $data['name']);

        return $coupon->save() ?  response()->json([
            'status' => 'success',
            'data' => $coupon
        ], 200) : $this->response->error('Failed creating coupon', Response::HTTP_ACCEPTED);
    }

    public function update($id, $data)
    {
        $coupon = $this->coupon->findOrFail($id);

        $coupon->slug = $this->createSlug($this->coupon, $data['name'], $id);

        return $coupon->update($data) ?  response()->json([
            'status' => 'success',
            'data' => $coupon
        ], 200) : $this->response->error('Failed updating coupon', Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {

        return $this->coupon->destroy($id) ?  response()->json([
            'status' => 'success',
            'message' => 'coupon deleted'
        ], 200) : $this->response->error('Failed creating coupon', Response::HTTP_ACCEPTED);
    }
}
