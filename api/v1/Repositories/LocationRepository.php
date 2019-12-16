<?php

namespace Api\v1\Repositories;

use Api\BaseRepository;
use App\City;
use App\Country;
use App\State;
use Illuminate\Http\Response;

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
        $data = $this->country->all();
        return response()->json(compact('data'),Response::HTTP_ACCEPTED);
    }

    public function getStates($country_id)
    {
        $data = $this->country->findOrFail($country_id)->states;
        return response()->json(compact('data'),Response::HTTP_ACCEPTED);

    }

    public function getCities($state_id)
    {
        $data = $this->state->findOrFail($state_id)->cities;
        return response()->json(compact('data'),Response::HTTP_ACCEPTED);

    }



   
}
