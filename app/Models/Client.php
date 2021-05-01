<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'town',
        'address',
        'postal_code',
        'added_by',
        'web'
    ];

    public static function findWithinPeriod($dateFrom, $dateTo, $user){
        $count = Client::selectRaw("count(clients.id) as count")
                    ->where("added_by", $user)
                    ->whereRaw("created_at BETWEEN '" . $dateFrom . " 00:00:01' AND '" . $dateTo . " 23:59:59'")
                    ->get();
        
        return $count;
    }

    public static function findByOrganization($organization_id){
        $clients = Client::selectRaw('clients.*')
            ->leftJoin("users", "users.id", "=", "clients.added_by")
            ->where("users.organization_id", "=", $organization_id)
            ->get();

        return $clients;

    }

}
