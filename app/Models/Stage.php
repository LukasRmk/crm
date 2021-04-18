<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $table = 'sale_stages';

    protected $fillable = [
        'window_id',
        'name'
    ];

    public static function updateOrder($orders){
        foreach($orders as $order => $id){
            Stage::where("id", $id)
                ->update(["order_by" => $order]);
        }
        return true;
    }

    public static function getOrdered(){
        
        $stages = Stage::select("sale_stages.*")
                    ->orderBy("order_by", "ASC")
                    ->get();
    
        return $stages;          
    }

    public static function findByWindow($window){
        $stages = Stage::select("sale_stages.*")
                ->where('window_id', $window)
                ->orderBy("order_by", "ASC")
                ->get();

        return $stages; 
    }


}
