<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    use HasFactory;

    protected $table = 'task_comments';

    protected $fillable = [
        'task_id',
        'added_by',
        'comment'
    ];

    public static function findTaskComment($task_id){
        
        $comments = TaskComment::select("task_comments.*", "users.name")
                    ->where("task_id", $task_id)
                    ->leftJoin("users", "users.id", "=", "task_comments.added_by")
                    ->orderBy("created_at", "desc")
                    ->get();
    
        return $comments;          
    }

}
