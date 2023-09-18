<?php

namespace App\Service;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductCategoryService
{
    public function getParentCategories()
    {
        return ProductCategory::query()
            ->select(['id', 'avatar', 'name', 'sku', 'user_id', 'category_id', 'stock', 'expired_at'])
            ->whereNull('parent_id')
            ->get();
    }

    public function getParentCategoriesWhereNot(string $id)
    {
        return ProductCategory::query()
            ->whereNull('parent_id')
            ->whereNot('id', $id)
            ->get();
    }

    public function getChildrenCategories($categories)
    {
        $categoriesLv2 = [];
        foreach ($categories as $item) {
            $categoriesLv2[$item->id] = ProductCategory::query()->where("parent_id", $item->id)->get();
        }
        return $categoriesLv2;
    }

    public function getCategories()
    {
        return ProductCategory::query()->paginate(ProductCategory::NUMBER_OF_PAGE);
    }

    public function finCategoryById(string $id)
    {
        return ProductCategory::query()->find($id);
    }

    public function storeCategory(Request $request, ProductCategory $category)
    {
        DB::beginTransaction();
        try {
            $category->name = $request->get("name");
            $category->user_id = Auth::user()->getAuthIdentifier();
            $category->parent_id = $request->get("parent_id");
            $category->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return false;
        }
    }

    public function deleteCategories(ProductCategory $category)
    {
        DB::beginTransaction();
        try {
            $category->delete();

            $categoriesLv2 = ProductCategory::query()->where("parent_id", $category->id)->get();
            foreach ($categoriesLv2 as $item) {
                $item->delete();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return false;
        }
    }
}
