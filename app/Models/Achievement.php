<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Achievement extends Model
{
    use HasFactory;

    public static function getAchievementsWithProgress($user){

        $achievements = Achievement::all();

        foreach($achievements as $key => $achievement){
            switch($achievement->achievement_type){
                case 1: // Added clients

                    $achievements[$key]->progress = DB::table("clients")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->first()
                    ->progress;
                    
                    break;
                
                case 2: // Added sales

                    $achievements[$key]->progress = DB::table("sale")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->first()
                    ->progress;
                    
                    break;

                case 3: // Succesful sales

                    $achievements[$key]->progress = DB::table("sale")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->where("status", "=", "1")
                    ->first()
                    ->progress;
                    
                    break;

                case 4: // Calls created

                    $achievements[$key]->progress = DB::table("tasks")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->where("type_id", "=", $achievement->task_type)
                    ->first()
                    ->progress;
                    
                    break;

                case 5: // Calls successful

                    $achievements[$key]->progress = DB::table("tasks")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->where("task_succesful", "=", "1")
                    ->where("type_id", "=", $achievement->task_type)
                    ->first()
                    ->progress;
                    
                    break;

                case 6: // Meets created

                    $achievements[$key]->progress = DB::table("tasks")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->where("type_id", "=", $achievement->task_type)
                    ->first()
                    ->progress;
                    
                    break;

                case 7: // Meets successful

                    $achievements[$key]->progress = DB::table("tasks")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->where("task_succesful", "=", "1")
                    ->where("type_id", "=", $achievement->task_type)
                    ->first()
                    ->progress;
                    
                    break;

                default:
            }
        }

        return $achievements;

    }

}
