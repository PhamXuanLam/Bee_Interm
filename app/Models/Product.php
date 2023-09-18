<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        "id", "user_id", "sku",
        "name", "stock", "avatar",
        "expired_at", "category_id", "flag_delete",
        "created_at", "updated_at"
    ];
    const stockRange = [
        '0' => 'Tất cả',
        '0-10' => 'Số lượng nhỏ hơn 10',
        '10-100' => 'Số lượng từ 10 -> 100',
        '100-200' => 'Số lượng từ 100 -> 200',
        '200' => 'Số lượng lớn hơn 200',
    ];

    protected $primaryKey = "id";

    public $timestamps = true;
    const NUMBER_OF_PAGE = 15;
    const DIRECTORY_AVATAR = 'upload/product/';

    const BASE_AVATAR = "upload/product/default/avatar.png";

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
