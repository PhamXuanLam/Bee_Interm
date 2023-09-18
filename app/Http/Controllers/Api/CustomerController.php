<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Service\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->only(['phone', 'password']), [
            'phone' => ['required'],
            'password' => ['required'],
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 442);
        }

        if (Auth::guard('customer')->attempt([
            'phone' => $request->get('phone'),
            'password' => $request->get('password')
        ])) {
            $customer = Auth::guard('customer')->user();
            $token = $customer->createToken('MyApp')->accessToken;
            return response()->json(['token' => $token]);
        }
        return response()->json(['email' => 'The provided credentials do not match our records.']);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $customer = Auth::guard('customer_api')->user();

        if ($customer)
            return response()->json(['data' => $customer]);
        return response()->json(['error' => 'vui long dang nhap']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request)
    {
        $response = $this->customerService->storeCustomer($request);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
