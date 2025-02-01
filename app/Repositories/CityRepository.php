<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Http\Request;

class CityRepository
{
    protected $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function getCities(Request $request)
    {
        $name = $request->query('name');
        $cities = City::where('name', 'like', "%$name%")->orderBy('name', 'asc')->paginate(10);

        return $cities;
    }
}