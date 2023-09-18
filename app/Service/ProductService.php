<?php

namespace App\Service;

use App\Helpers\Common;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function getProductsWhereStockLessThanTen()
    {
        return Product::query()
            ->where('stock', '<', 10)
            ->get();
    }
    public function getProducts()
    {
        return Product::query()
            ->select(['*'])
            ->paginate(Product::NUMBER_OF_PAGE);
    }

    public function findProductById(string $id)
    {
        return Product::query()
            ->select(['*'])
            ->find($id);
    }

    public function getProductsByKeywordOrStock(Request $request)
    {
        $products = Product::query()
            ->with(['category'])
            ->select(['id', 'avatar', 'name', 'sku', 'user_id', 'category_id', 'stock', 'expired_at']);

        $keyword = $request->get("name");
        if (!empty($keyword)) {
            $products = $products->where("name", 'LIKE', "%{$keyword}%")
                ->orWhereHas('category', function ($query) use ($keyword) {
                    $query->where("name", 'LIKE', "%{$keyword}%");
                });
        }

        $stock = $request->get("stock");
        if (!empty($stock)) {
            $range = array_map('intval', explode('-', $stock)) ;
            if (count($range) == 1) {
                $products = $products->where("stock", '>', $range[0]);
            } elseif (count($range) == 2) {
                $products = $products->whereBetween("stock", $range);
            }
        }

        return $products->paginate(Product::NUMBER_OF_PAGE);
    }

    public function storeProduct(Request $request, Product $product, string $id = null)
    {
        DB::beginTransaction();
        try {
            $product->user_id = Auth::user()->getAuthIdentifier();
            $product->name = $request->get("name");
            $product->stock = $request->get("stock");
            $product->sku = $request->get("sku");
            $product->expired_at = $request->get("expired_at");
            $product->category_id = $request->get("category_id");
            $product->save();
            if ($request->hasFile("avatar") && $id == null) {
                $product->avatar = Common::uploadImage($product->id, Product::DIRECTORY_AVATAR, $request->file("avatar"));
            } elseif ($request->hasFile("avatar") && $id == null) {
                $product->avatar = Common::uploadImage($product->id, Product::DIRECTORY_AVATAR, $request->file("avatar"), $product->avatar);
            } elseif (!$request->hasFile("avatar")) {
                $product->avatar = time() . '.png';
            }
            $product->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return false;
        }
    }

    public function deleteProduct(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            $response = [
                'success' => true,
                'message' => 'Xóa sản phẩm thành công'
            ];
        } catch (\Exception $e) {
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => 'Xóa sản phẩm không thành công'
            ];
        }
        return $response;
    }
}
