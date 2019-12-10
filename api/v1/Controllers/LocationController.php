<?php

namespace Api\v1\Controllers\User;

use Illuminate\Http\Request;
use Api\BaseController;
use Api\v1\Repositories\LocationRepository;

class LocationController extends BaseController
{
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository  = $locationRepository;
    }

    public function getCountries()
    {
        return $this->locationRepository->getCountries();
    }

    public function getStates($country_id)
    {
        return $this->locationRepository->getStates($country_id);
    }

    public function getCities($state_id)
    {
        return $this->locationRepository->getCities($state_id);
    }
}
