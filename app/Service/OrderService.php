<?php

namespace App\Service;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function storeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $order = new Order();
            $order->customer_id = Auth::guard("customer_api")->user()->getAuthIdentifier();
            $data['customer'] = Auth::guard("customer_api")->user()->full_name;
            $products = json_decode($request->products);
            $quantity = 0;
            $order->quantity = $quantity;
            $total = 0;
            $order->total = $total;
            $order->save();
            foreach (array_count_values($products) as $product_id => $count) {
                $product = Product::query()->find($product_id);
                $dataItem = [];
                $dataItem['id'] = $product_id;
                $dataItem['name'] = $product->name;
                $dataItem['price'] = $product->price;
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product_id;
                if ($product->stock <= $count) {
                    $orderDetail->quantity = $product->stock;
                    $product->stock = 0;
                    $dataItem['out_of_stock'] = true;
                } else {
                    $orderDetail->quantity = $count;
                    $product->stock -= $count;
                }
                $quantity += $orderDetail->quantity;
                $dataItem['quantity'] = $orderDetail->quantity;
                $data['products'][] = $dataItem;
                $orderDetail->price = $product->price;
                $orderDetail->status = 1;
                $total += $orderDetail->quantity * $orderDetail->price;
                $product->save();
                $orderDetail->save();
            }
            $order->total = $total;
            $order->quantity = $quantity;
            $order->save();
            $data= array_merge($data,$order->toArray());
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return ['error' => 'Tao hoa don that bai'];
        }
    }

    public function getCustomer()
    {
        return Order::query()
            ->selectRaw('customer_id, SUM(quantity) as quantity, SUM(total) as total')
            ->groupBy('customer_id')
            ->where('updated_at', '>=', Carbon::now()->subMonth())
            ->where('updated_at', '<=', Carbon::now()->subDay())
            ->get();
    }

    public function getOrdersByCustomerId(string $id)
    {
        return Order::query()
            ->select(['id'])
            ->where('customer_id', $id)
            ->get();
    }

    public function getOrderDetails($array)
    {
        return OrderDetail::query()
            ->selectRaw('product_id, SUM(quantity) as quantity')
            ->whereIn('order_id', $array)
            ->groupBy('product_id')
            ->get();
    }

    public function getProductsBySaleTime($start = null, $end = null)
    {
        $products = OrderDetail::query()
            ->selectRaw('product_id, SUM(quantity) as quantity')
            ->groupBy('product_id');

        if ($start != null)
            $products = $products->where('created_at', '>=', $start);

        if ($end != null)
            $products = $products->where('created_at', '<=', $end);

        return $products->paginate(Product::NUMBER_OF_PAGE);

    }

    public function getTotalProductForEachMonthOfYear()
    {
        return OrderDetail::select(
            'product_id',
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(quantity) as quantity')
        )
            ->groupBy('product_id', 'month')
            ->orderBy('month')
            ->get();
    }

    public function getOrdersByProductId(string $id)
    {
        return OrderDetail::where('product_id', $id)->pluck('order_id')->toArray();
    }

    public function getCustomersByOrderId($array)
    {
        return Order::whereIn('id', $array)
            ->with(['customer'])
            ->distinct('customer_id')
            ->paginate(15);
    }
}
