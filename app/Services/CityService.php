<?php

namespace App\Services;

use App\Repositories\CityRepository;
use Illuminate\Http\Request;

class CityService
{
    protected $cityRepository;

    public function __construct(CityRepository $repository)
    {
        $this->cityRepository = $repository;
    }

    public function getCities(Request $data)
    {
        return $this->cityRepository->getCities($data);
    }
}