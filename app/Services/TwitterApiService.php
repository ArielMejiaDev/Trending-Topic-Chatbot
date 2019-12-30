<?php namespace App\Services;

use Thujohn\Twitter\Facades\Twitter;

class TwitterApiService 
{

    public function getAllTrends()
    {
        return Twitter::getTrendsAvailable();
    }

    public function getCitiesMap() :array
    {
        $trends = Twitter::getTrendsAvailable();
        $locations = [];
        foreach ($trends as $trend) {
            $locations[strtolower($trend->name)] = $trend->woeid;
        }
        return $locations;
    }

    public function getTrendsByCity($woeid)
    {
        return Twitter::getTrendsPlace(['id' => $woeid])[0]->trends;
    }
}