<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\v1\Repositories\User\UserRepository;
use Api\BaseController;

class UsersController extends BaseController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return $this->userRepository->getProfile();
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'image'=> 'required|mimes:jpeg,jpg,png'
        ]);

        return $this->userRepository->updateImage($request->all());
    }
}
