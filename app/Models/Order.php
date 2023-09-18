<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = ['id', 'customer_id', 'quantity', 'total', 'created_at', 'updated_at'];

    protected $primaryKey = 'id';

    public $timestamps = true;

    const NUMBER_OF_PAGE = 15;

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
