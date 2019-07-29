<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\v1\Repositories\User\AuthRepository;
use Api\BaseController;

class AuthController extends BaseController
{
    private $authRepository; 

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository  = $authRepository;
    }
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        
        return $this->authRepository->createUser($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        return $this->authRepository->login($request);
    }
}
