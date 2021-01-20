<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Services\Territory as TerritoryService;
use App\Presenter\Api\Territories\Province as ProvincePresenter;

class Territory extends Controller
{   
    use Helpers;
    
    private function getTerritoryService()
    {
        $service = new TerritoryService();

        return $service;
    }

    public function getProvinces()
    {
        $territoryService = $this->getTerritoryService();
        $result = $territoryService->searchProvinces(1,0);

        return response()->json($result,200);
    }

    public function getRegencies($province_id)
    {
        $territoryService = $this->getTerritoryService();
        $result = $territoryService->searchRegencies(['province_id'=>$province_id],1,0);

        return response()->json($result,200);
    }

    public function getDistricts($province_id,$regency_id)
    {
        $territoryService = $this->getTerritoryService();
        $result = $territoryService->searchDistricts(['province_id'=>$province_id,'regency_id'=>$regency_id],1,0);
        return response()->json($result,200);
    }

    public function getVillages($province_id,$regency_id,$district_id)
    {
        $territoryService = $this->getTerritoryService();
        $result = $territoryService->searchVillages(['province_id'=>$province_id,'regency_id'=>$regency_id,'district_id'=>$district_id],1,0);
        return response()->json($result,200);
    }
}
