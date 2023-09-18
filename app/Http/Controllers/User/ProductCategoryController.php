<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use App\Service\ProductCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends Controller
{
    protected ProductCategoryService $categoryService;

    public function __construct(ProductCategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getCategories();

        return view("user.category.index", ["categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategoryList = $this->categoryService->getParentCategories();
        return view("user.category.create", ["productCategoryList" => $productCategoryList]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request)
    {
        if ($this->categoryService->storeCategory($request, new ProductCategory()))
            return redirect()->route("category.index")->with('success', 'cập nhật thành công');

        return redirect()->route("category.index")->with('error', 'cập nhật thất bại');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->categoryService->finCategoryById($id);
        if (!$category)
            return redirect()->route("category.index")->with("error", "Có lỗi xảy ra");

        $productCategoryList = $this->categoryService->getParentCategoriesWhereNot($category->parent_id);

        return view("user.category.edit", ["category" => $category, "productCategoryList" => $productCategoryList]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = $this->categoryService->finCategoryById($id);
        if (!$category)
            return redirect()->route("category.index")->with("error", "Có lỗi xảy ra");

        if ($this->categoryService->storeCategory($request, $category))
            return redirect()->route("category.index")->with('success', 'cập nhật thành công');

        return redirect()->route("category.index")->with('error', 'cập nhật thất bại');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->categoryService->finCategoryById($id);
        if ($category->isEmpty())
            return redirect()->route("category.index")->with("error", "Có lỗi xảy ra");

        if ($this->categoryService->deleteCategories($category))
            return redirect()->route("category.index");

        return redirect()->route("category.index")->with('error', 'có lỗi sảy ra');
    }
}
