<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;

    protected $table = 'task_types';

    protected $fillable = [
        'type_name'
    ];


    public static function findTaskType($id){
        $type = TaskType::select("task_types.type_name")
        ->where("id", $id)
        ->get();

        return $type;
    }

}
