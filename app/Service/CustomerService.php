<?php

namespace App\Service;

use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function storeCustomer(Request $request)
    {
        DB::beginTransaction();
        try {
            $customer = Auth::guard('customer_api')->user();
            $customer->phone = $request->phone;
            $customer->full_name = $request->full_name;
            $customer->email = $request->email;
            $customer->status = $request->status;
            $customer->birthday = $request->birthday;
            $customer->commune_id = $request->commune;
            $customer->district_id = $request->district;
            $customer->province_id = $request->province;
            $customer->address =
                AdministrativeService::getAddress($request->province, $request->district, $request->commune);
            $customer->save();
            DB::commit();
            return ['data' => $customer];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return ['error' => 'cap nhat that bai'];
        }
    }
}
