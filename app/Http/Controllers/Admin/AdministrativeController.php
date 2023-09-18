<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CommunesImport;
use App\Imports\DistrictsImport;
use App\Imports\ProvincesImport;
use App\Models\Commune;
use App\Models\District;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdministrativeController extends Controller
{
    public function showUpload()
    {
        return view('admin.administrative.upload');
    }

    public function import(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $path = $request->file('csv_file')->getRealPath();
            Excel::import(new ProvincesImport(), $path);
            Excel::import(new DistrictsImport(), $path);
            Excel::import(new CommunesImport(), $path);
            return redirect()->back()->with('success', 'CSV file imported successfully.');
        }
        return redirect()->back()->with('error', 'Please upload a CSV file.');
    }

    public function getDistricts($id)
    {
        $districts = District::query()
            ->select(['*'])
            ->where("province_id", $id)
            ->get();
        return response()->json($districts);
    }

    public function getCommunes($id)
    {
        $communes = Commune::query()
            ->select(['*'])
            ->where("district_id", $id)
            ->get();
        return response()->json($communes);
    }
}
