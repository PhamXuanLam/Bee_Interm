<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'customers';

    protected $fillable =
        ['id', 'phone', 'email',
            'full_name', 'status',
            'password', 'reset_password',
            'address', 'province_id',
            'district_id', 'commune_id',
            'flag_delete', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';


    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = true;
}
