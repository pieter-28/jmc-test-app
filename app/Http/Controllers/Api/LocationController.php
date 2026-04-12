<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;

class LocationController extends Controller
{
    /**
     * Get districts by province.
     */
    public function getDistricts($provinceId)
    {
        $districts = District::where('province_id', $provinceId)->select('id', 'name')->get();

        return response()->json($districts);
    }

    /**
     * Get sub-districts by district.
     */
    public function getSubDistricts($districtId)
    {
        $subDistricts = SubDistrict::where('district_id', $districtId)->select('id', 'name')->get();

        return response()->json($subDistricts);
    }
}
