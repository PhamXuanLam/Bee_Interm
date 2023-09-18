<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    const NUMBER_OF_PAGE = 15;

    protected $table = "product_category";

    protected $fillable = [
        "id", "user_id", "name",
        "parent_id", "created_at", "updated_at"
    ];

    protected $primaryKey = "id";

    public $timestamps = true;

    public function getParentId() {
        if ($this->parent_id == null) {
            return "N/A";
        }
        return $this->parent_id;
    }

    public function getParentName(string $id)
    {
        return ProductCategory::query()->find($id)->name;
    }

    public function children()
    {
        return $this->hasOne(ProductCategory::class, 'parent_id', 'id');
    }
}
