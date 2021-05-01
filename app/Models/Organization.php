<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'admin'
    ];

    public static function findWithAdmin(){
        $org = Organization::selectRaw('organizations.*, users.name as admin_name')
                    ->leftJoin("users", "users.id", "=", "organizations.admin")
                    ->get();

        return $org;
    }
}
