<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\BaseController;
use Api\v1\Repositories\SearchRepository;

class SearchController extends BaseController
{
    private $searchRepository; 

    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository  = $searchRepository;
    }

    public function search(){
        return $this->searchRepository->searchProduct();
    }
     
}
