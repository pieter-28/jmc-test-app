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

    /**
     * Search sub-districts by name (autocomplete).
     */
    public function searchSubDistricts(\Illuminate\Http\Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $subDistricts = SubDistrict::where('name', 'like', "%$query%")
            ->with('district.province')
            ->select('id', 'name', 'district_id')
            ->limit(20)
            ->get()
            ->map(function ($subDistrict) {
                return [
                    'id' => $subDistrict->id,
                    'text' => $subDistrict->name,
                ];
            });

        return response()->json($subDistricts);
    }

    /**
     * Get district and province information from sub-district.
     */
    public function getLocationFromSubDistrict($id)
    {
        $subDistrict = SubDistrict::with('district.province')->find($id);

        if (!$subDistrict) {
            return response()->json(['error' => 'Sub-district not found'], 404);
        }

        return response()->json([
            'sub_district_id' => $subDistrict->id,
            'sub_district_name' => $subDistrict->name,
            'district_id' => $subDistrict->district->id,
            'district_name' => $subDistrict->district->name,
            'province_id' => $subDistrict->district->province->id,
            'province_name' => $subDistrict->district->province->name,
        ]);
    }
}
