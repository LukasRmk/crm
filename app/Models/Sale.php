<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sale';

    protected $fillable = [
        'client_id',
        'window',
        'stage',
        'price',
        'added_by',
        'info',
        'name',
        'order_by',
        'status'
    ];

    public static function findByClient($client_id){
        
        $sales = Sale::select("sale.*")
                    ->where("client_id", $client_id)
                    ->orderBy("created_at", "DESC")
                    ->get();
    
        return $sales;          
    }

    public static function findJoined($id){
        $sale = Sale::select("sale.*", "sale_stages.name as stage_name", "sale_windows.name as window_name", "users.name as user_name")
                    ->where("sale.id", $id)
                    ->leftJoin("sale_stages", "sale_stages.id", "=", "sale.stage")
                    ->leftJoin("sale_windows", "sale_windows.id", "=", "sale.window")
                    ->leftJoin("users", "users.id", "=", "sale.added_by")
                    ->get();
        return $sale;
    }

    public static function findJoinedAll(){
        $sale = Sale::select("sale.*", "sale_stages.name as stage_name", "sale_windows.name as window_name", "users.name as user_name", "clients.name as client_name")
                    ->leftJoin("sale_stages", "sale_stages.id", "=", "sale.stage")
                    ->leftJoin("sale_windows", "sale_windows.id", "=", "sale.window")
                    ->leftJoin("users", "users.id", "=", "sale.added_by")
                    ->leftJoin("clients", "clients.id", "=", "sale.client_id")
                    ->get();
        return $sale;
    }

    public static function findByStage($stage, $seller){
        $sales = Sale::select("sale.*", "users.name as user_name", "clients.name as client_name")
                ->leftJoin("users", "users.id", "=", "sale.added_by")
                ->leftJoin("clients", "clients.id", "=", "sale.client_id")
                ->where("sale.stage", $stage)
                ->where("sale.added_by", $seller)
                ->where("sale.status", 0)
                ->orderBy("order_by", "ASC")
                ->get();

        return $sales;
    }

    public static function findByStageAll($stage){
        $sales = Sale::select("sale.*", "users.name as user_name", "clients.name as client_name")
                ->leftJoin("users", "users.id", "=", "sale.added_by")
                ->leftJoin("clients", "clients.id", "=", "sale.client_id")
                ->where("sale.stage", $stage)
                ->where("sale.status", 0)
                ->orderBy("order_by", "ASC")
                ->get();

        return $sales;
    }

    public static function updateSalesOrder($orders){
        foreach($orders as $order => $id){
            Sale::where("id", $id)
                ->update(["order_by" => $order]);
        }
    }

}
