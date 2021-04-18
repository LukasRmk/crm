<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Achievement;

class AchievementTest extends TestCase
{
    
    public function test_getAchievementsWithProgress(){
        $user = 1;
        $achievements = Achievement::getAchievementsWithProgress($user);
        $achievementsDummy = Achievement::all();

        foreach($achievementsDummy as $key => $achievement){
            switch($achievement->achievement_type){
                case 1: // Added clients

                    $achievementsDummy[$key]->progress = DB::table("clients")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->first()
                    ->progress;
                    
                    break;
                
                case 2: // Added sales

                    $achievementsDummy[$key]->progress = DB::table("sale")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->first()
                    ->progress;
                    
                    break;

                case 3: // Succesful sales

                    $achievementsDummy[$key]->progress = DB::table("sale")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->where("status", "=", "1")
                    ->first()
                    ->progress;
                    
                    break;

                case 4: // Calls created

                    $achievementsDummy[$key]->progress = DB::table("tasks")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->where("type_id", "=", $achievement->task_type)
                    ->first()
                    ->progress;
                    
                    break;

                case 5: // Calls successful

                    $achievementsDummy[$key]->progress = DB::table("tasks")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->where("task_succesful", "=", "1")
                    ->where("type_id", "=", $achievement->task_type)
                    ->first()
                    ->progress;
                    
                    break;

                case 6: // Meets created

                    $achievementsDummy[$key]->progress = DB::table("tasks")
                    ->selectRaw("COUNT(id) as progress")
                    ->where("added_by", "=", $user)
                    ->where("type_id", "=", $achievement->task_type)
                    ->first()
                    ->progress;
                    
                    break;

                case 7: // Meets successful

                    $achievementsDummy[$key]->progress = DB::table("tasks")
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


        $this->assertEquals($achievementsDummy, $achievements);
    }

}
