<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskComment;

class TaskCommentTest extends TestCase
{

    public function test_findTaskComment(){
        $task_id = 14;

        $comments = TaskComment::findTaskComment($task_id);
        $dummyComments = TaskComment::select("task_comments.*", "users.name")
        ->where("task_id", $task_id)
        ->leftJoin("users", "users.id", "=", "task_comments.added_by")
        ->orderBy("created_at", "desc")
        ->get();
        $this->assertEquals($dummyComments, $comments);
    }

}
