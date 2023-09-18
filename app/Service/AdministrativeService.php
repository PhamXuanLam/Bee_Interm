<?php

namespace App\Service;

use App\Models\Commune;
use App\Models\District;
use App\Models\Province;

class AdministrativeService
{
    public function getProvinces()
    {
        return Province::query()
            ->select(['*'])
            ->with(['districts', 'districts.communes'])
            ->get();
    }

    public function getProvincesWhereNotId(string $province_id)
    {
        return Province::query()
            ->select(['*'])
            ->with(['districts', 'districts.communes'])
            ->whereNot("id", $province_id)
            ->get();
    }

    public function getDistrictsWhereNotId(string $province_id, string $district_id)
    {
        return District::query()
            ->select(['*'])
            ->where("province_id", $province_id)
            ->whereNot("id", $district_id)
            ->get();
    }

    public function getCommunesWhereNotId(string $district_id, string $commune_id)
    {
        return Commune::query()
            ->select(['*'])
            ->where("district_id", $district_id)
            ->whereNot('id', $commune_id)
            ->get();
    }

    public static function getAddress(string $province_id, $district_id, $commune_id)
    {
        return
            Province::query()->select(['name'])->find($province_id)->name . " - " .
            District::query()->select(['name'])->find($district_id)->name . " - " .
            Commune::query()->select(['name'])->find($commune_id)->name;
    }
}
