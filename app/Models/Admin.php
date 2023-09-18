<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "admins";

    protected $fillable = [
        "id", 'email', "user_name", "birthday",
        "first_name", "last_name", "password",
        "reset_password", "status", "flag_delete",
        "created_at", "updated_at",
        ];

    protected $primaryKey = "id";

    public $timestamps = true;

    public function getNameAttribute() {
        return $this->user_name;
    }
}
