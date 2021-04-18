<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskType;

class TaskTypeTest extends TestCase
{

    public function test_findTaskType(){
        $id = 14;
        $type = TaskType::findTaskType($id);
        $typeDummy = TaskType::select("task_types.type_name")
        ->where("id", $id)
        ->get();

        $this->assertEquals($typeDummy, $type);

    }
}
