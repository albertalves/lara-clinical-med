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
        $cities = $this->city->where('name', 'like', "%$name%")->orderBy('name', 'asc')->paginate(10);

        return $cities;
    }

    public function getDoctorsFromCity(Request $request)
    {
        $query = $this->city->with(['doctors' => function ($query) use ($request) {
            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
        }]);

        $city = $query->where('id', $request->city_id)->first();

        if (!$city || $city->doctors->isEmpty()) {
            return [];
        }
        
        return $city->doctors;
    }
}