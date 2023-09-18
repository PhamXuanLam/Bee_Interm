<?php

namespace App\Http\Controllers\User;

use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Service\ProductCategoryService;
use App\Service\ProductService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    protected ProductService $productService;

    protected ProductCategoryService $categoryService;

    public function __construct(ProductService $productService, ProductCategoryService $categoryService)
    {
        $this->productService = $productService;

        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productService->getProductsByKeywordOrStock($request);
        return view("user.product.index", ["products" => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->getParentCategories();
        if ($categories->isEmpty())
            return redirect()->route("product.index")->with("error", "có lỗi xảy ra");

        $categoriesLv2 = $this->categoryService->getChildrenCategories($categories);

        return view("user.product.create", ["categories" => $categories, "categoriesLv2" => $categoriesLv2]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        if ($this->productService->storeProduct($request, new Product()))
            return redirect()->route("product.index")->with('success', "Xử lý dữ liệu thành công!");
        return redirect()->route("product.index")->with('error', "Xử lý dữ liệu thất bại!");
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
        $product = $this->productService->findProductById($id);

        $categories = $this->categoryService->getParentCategoriesWhereNot($product->categoory_id);

        $categoriesLv2 = $this->categoryService->getChildrenCategories($categories);

        if (!$product || !$categories)
            return redirect()->route("product.index")->with("error", "có lỗi xảy ra");

        return view("user.product.edit", ["product" => $product, "categories" => $categories, "categoriesLv2" => $categoriesLv2]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = $this->productService->findProductById($id);
        if ($product->isEmpty())
            return redirect()->route('product.index')->with('error', 'có lỗi xảy ra');

        if ($this->productService->storeProduct($request, $product, $id))
            return redirect()->route("product.index")->with('success', "Xử lý dữ liệu thành công!");

        return redirect()->route("product.index")->with('error', "Xử lý dữ liệu thất bại!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->productService->findProductById($id);
        if ($product->isEmpty())
            return redirect()->route('product.index')->with('error', 'có lỗi xảy ra');

        $response = $this->productService->deleteProduct($product);
        return response()->json($response);
    }
    public function downloadCSV($products)
    {
        return Excel::download(new ProductsExport($products), 'products.csv');
    }

    public function downloadPDF($products)
    {
        $pdf = PDF::loadView('user.product.pdf', compact('products'));

        return $pdf->download('products.pdf');
    }

    public function download(Request $request)
    {
        $products = Product::with(['category'])
            ->select('id', 'name', 'category_id', 'stock', 'expired_at')
            ->get();

        $format = $request->get('format');

        if ($format === 'csv') {
            return $this->downloadCSV($products);
        } elseif ($format === 'pdf') {
            return $this->downloadPDF($products);
        }
    }

    public function showImage(string $id, $avatar)
    {
        return Common::showImage(Product::DIRECTORY_AVATAR, $id . '/' .$avatar, Product::BASE_AVATAR);
    }
}
