<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'task_name',
        'task_description',
        'task_datetime',
        'client_id',
        'task_completed',
        'task_succesful',
        'added_by',
        'sale_id'
    ];

    public static function findByClient($client_id){
        
        $tasks = Task::select("tasks.*", "task_types.type_name")
                    ->where("client_id", $client_id)
                    ->leftJoin("task_types", "task_types.id", "=", "tasks.type_id")
                    ->orderBy("task_datetime")
                    ->get();
    
        return $tasks;          
    }

    public static function findTaskType($type_id){

        $task_type = DB::table("task_types")->where("id", "=", $type_id)->get();
    
        return $task_type;  

    }

    public static function completeXpGiven($task_id){
        $given = Task::select("tasks.complete_xp")
                    ->where("id", $task_id)
                    ->get();
    
        return $given[0]['complete_xp'];
    }

    public static function setCompleteXpGiven($task_id){
        Task::where("id", $task_id)
        ->update(["complete_xp" => 1]);
    }

    public static function successXpGiven($task_id){
        $given = Task::select("tasks.success_xp")
                    ->where("id", $task_id)
                    ->get();
    
        return $given[0]['success_xp'];
    }

    public static function setSuccessXpGiven($task_id){
        Task::where("id", $task_id)
        ->update(["success_xp" => 1]);
    }

}
