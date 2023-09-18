<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->products->map(function ($product) {
            $productData['id'] = $product->id;
            $productData['name'] = $product->name;
            $productData['stock'] = $product->stock;
            $productData['category_name'] = $product->category->name;
            $productData['expired_at'] = $product->expired_at;
            return $productData;
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Stock',
            'Category Name',
            'Expiration Date',
        ];
    }
}
