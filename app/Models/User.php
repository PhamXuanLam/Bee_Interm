<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    protected $fillable = [
        "id", 'email', "user_name", "birthday",
        "first_name", "last_name", "password",
        "reset_password", "status", "flag_delete",
        "created_at", "updated_at", "avatar", 'address',
        'province_id', 'district_id', 'commune_id'
    ];

    protected $primaryKey = "id";

    public $timestamps = true;
    const NUMBER_OF_PAGE = 15;
    const DIRECTORY_AVATAR = 'upload/user/';
    const BASE_AVATAR = 'upload/user/default/avatar.png';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE_LABEL = "Active";
    const STATUS_INACTIVE_LABEL = "InActive";
    public function getStatusLabel(): string
    {
        switch ($this->status) {
            case static::STATUS_ACTIVE:
                return static::STATUS_ACTIVE_LABEL;
            case static::STATUS_INACTIVE:
                return static::STATUS_INACTIVE_LABEL;

            default:
                return "N/A";
        }
    }
    public function province()
    {
        return $this->hasOne(Province::class, "id", "province_id");
    }
    public function district()
    {
        return $this->hasOne(District::class, "id", "district_id");
    }
    public function commune()
    {
        return $this->hasOne(Commune::class, "id", "commune_id");
    }
}
