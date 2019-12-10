<?php

namespace Api\v1\Repositories;

use Api\BaseRepository;
use App\City;
use App\Country;
use App\State;

class LocationRepository extends BaseRepository
{
    private $country;

    private $state;

    private $city;

    public function __construct(Country $country, State $state, City $city)
    {
       $this->country = $country;
       $this->state = $state;
       $this->city = $city;
    }

    public function getCountries()
    {
        return $this->country->all();
    }

    public function getStates($country_id)
    {
        return $this->country->findOrFail($country_id)->states;
    }

    public function getCities($state_id)
    {
        return $this->state->findOrFail($state_id)->cities;
    }



   
}
