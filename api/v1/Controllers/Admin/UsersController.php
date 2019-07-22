<?php

namespace Api\v1\Controllers\Admin;

use Illuminate\Http\Request;
use Api\BaseController;
use Api\v1\Repositories\Admin\UsersRepository;

class UsersController extends BaseController
{
    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {   
        $this->usersRepository = $usersRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->usersRepository->getAll();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->usersRepository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->usersRepository->update($id,$request->except(['password','email']));
    }

    public function orders($id){
        return $this->usersRepository->orders($id);
    }

    public function wishList($id){
        return $this->usersRepository->wishList($id);
    }
    
    public function cartItems($id){
        return $this->usersRepository->cartItems($id);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
