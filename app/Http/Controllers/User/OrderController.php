<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::query()->select(['*'])->paginate(Order::NUMBER_OF_PAGE);
        return view('user.order.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orderDetails = OrderDetail::query()
            ->select(['*'])
            ->where('order_id', $id)
            ->get();
        if (!$orderDetails)
            return redirect()->route('order.index')->with('error', 'có lỗi xảy ra');

        return view('user.order.show', ['orderDetails' => $orderDetails]);
    }

    public function download(string $id)
    {
        $orderDetails = OrderDetail::query()
            ->select(['*'])
            ->where('order_id', $id)
            ->get();
        $pdf = PDF::loadView('user.order.pdf', compact("orderDetails"));

        return $pdf->download('orderDetails.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
