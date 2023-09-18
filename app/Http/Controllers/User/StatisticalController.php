<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\OrderService;
use Illuminate\Http\Request;

class StatisticalController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $products = $this->orderService->getProductsBySaleTime($start, $end);
        return view("user.statistical.index", ['products' => $products]);
    }

    /**
     * Display the specified resource.
     */
    public function chart()
    {
        $data = $this->orderService->getTotalProductForEachMonthOfYear();
        foreach ($data as $item) {
            $quantity = [];
            for ($i = 1; $i <= 12; $i++) {
                if ($item->month == $i) {
                    $quantity[] = (int) $item->quantity;
                } else {
                    $quantity[] = 0;
                }
            }
            $products[$item->product->name] = $quantity;
        }
        return view('user.statistical.chart', ['products' => $products]);
    }

    public function customers(string $id)
    {
        $listId = $this->orderService->getOrdersByProductId($id);
        $customers = $this->orderService->getCustomersByOrderId($listId);
        return view('user.statistical.customer', ['customers' => $customers]);
    }

}
