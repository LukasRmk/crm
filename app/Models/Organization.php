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

    public static function findWithAdmin($id = false){
        if(!$id){
            $org = Organization::selectRaw('organizations.*, users.name as admin_name')
            ->leftJoin("users", "users.id", "=", "organizations.admin")
            ->get();
        } else {
            $org = Organization::selectRaw('organizations.*, users.name as admin_name')
            ->where("organizations.id", $id)
            ->leftJoin("users", "users.id", "=", "organizations.admin")
            ->get();
        }
        

        return $org;
    }
}
