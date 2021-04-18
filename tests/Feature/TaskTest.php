<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use Illuminate\Support\Facades\DB;


class TaskTest extends TestCase
{
    
    public function test_findByClient()
    {
        $client_id = 29;

        $tasks = Task::findByClient($client_id);

        $dummyTask = Task::select("tasks.*", "task_types.type_name")
        ->where("client_id", $client_id)
        ->leftJoin("task_types", "task_types.id", "=", "tasks.type_id")
        ->orderBy("task_datetime", "DESC")
        ->get();

        
        $this->assertEquals($dummyTask, $tasks);
    }

    public function test_findBySale()
    {
        $sale_id = 1;

        $tasks = Task::findBySale($sale_id);

        $dummyTask = Task::select("tasks.*", "task_types.type_name")
        ->where("sale_id", $sale_id)
        ->leftJoin("task_types", "task_types.id", "=", "tasks.type_id")
        ->orderBy("task_datetime", "DESC")
        ->get();
        
        $this->assertEquals($dummyTask, $tasks);
    }

    public function test_findTaskType()
    {
        $type_id = 1;

        $type = Task::findTaskType($type_id);

        $dummyType = DB::table("task_types")->where("id", "=", $type_id)->get();
        
        $this->assertEquals($dummyType, $type);
    }

    public function test_completeXpGiven()
    {
        $task_id = 14;

        $test = Task::completeXpGiven($task_id);

        $dummy = Task::select("tasks.complete_xp")
        ->where("id", $task_id)
        ->get()[0]['complete_xp'];
        
        $this->assertEquals($dummy, $test);
    }

    public function test_setCompleteXpGiven()
    {
        $task_id = 14;
        $test = Task::setCompleteXpGiven($task_id);
        $dummy = true;
        
        $this->assertEquals($dummy, $test);
    }

    public function test_successXpGiven()
    {
        $task_id = 14;
        $test = Task::successXpGiven($task_id);
        $dummy = Task::select("tasks.success_xp")
        ->where("id", $task_id)
        ->get()[0]['success_xp'];
        
        $this->assertEquals($dummy, $test);
    }

    public function test_setSuccessXpGiven()
    {
        $task_id = 14;
        $test = Task::setSuccessXpGiven($task_id);
        $dummy = true;
        
        $this->assertEquals($dummy, $test);
    }

    public function test_findWonWithinPeriod()
    {
        $user = 1;
        $dateFrom = "2021-01-01";
        $dateTo = "2021-03-01";

        $test = Task::findWonWithinPeriod($dateFrom, $dateTo, $user);
        $dummy = Task::selectRaw("count(tasks.id) as count")
        ->where("added_by", $user)
        ->where("task_succesful", 1)
        ->whereRaw("task_datetime BETWEEN '" . $dateFrom . " 00:00:01' AND '" . $dateTo . " 23:59:59'")
        ->get();
        
        $this->assertEquals($dummy, $test);

        $test = Task::findWonWithinPeriod($dateFrom, $dateTo, $user, 1);
        $dummy = Task::selectRaw("count(tasks.id) as count")
        ->where("added_by", $user)
        ->where("task_succesful", 1)
        ->where("type_id", 1)
        ->whereRaw("task_datetime BETWEEN '" . $dateFrom . " 00:00:01' AND '" . $dateTo . " 23:59:59'")
        ->get();

        $this->assertEquals($dummy, $test);

    }

    public function test_findWithinPeriod()
    {
        $user = 1;
        $dateFrom = "2021-01-01";
        $dateTo = "2021-03-01";

        $test = Task::findWithinPeriod($dateFrom, $dateTo, $user);
        $dummy = Task::selectRaw("count(tasks.id) as count")
        ->where("added_by", $user)
        ->whereRaw("task_datetime BETWEEN '" . $dateFrom . " 00:00:01' AND '" . $dateTo . " 23:59:59'")
        ->get();
        
        $this->assertEquals($dummy, $test);

        $test = Task::findWithinPeriod($dateFrom, $dateTo, $user, 1);
        $dummy = Task::selectRaw("count(tasks.id) as count")
        ->where("added_by", $user)
        ->where("type_id", 1)
        ->whereRaw("task_datetime BETWEEN '" . $dateFrom . " 00:00:01' AND '" . $dateTo . " 23:59:59'")
        ->get();
        
        $this->assertEquals($dummy, $test);
    }

    public function test_getDashboardTasks()
    {
        $user = 1;
        $dateFrom = date('Y-m') . '-01';
        $dateTo = date('Y-m-t');
        $test = Task::getDashboardTasks($user);
        $dummy = Task::selectRaw("tasks.*, tasks.id as task_id, clients.name as client_name, task_types.type_name")
        ->where("tasks.added_by", $user)
        ->where("task_completed", '0')
        ->whereRaw("task_datetime BETWEEN '" . $dateFrom . " 00:00:01' AND '" . $dateTo . " 23:59:59'")
        ->leftJoin("task_types", "task_types.id", "=", "tasks.type_id")
        ->leftJoin("clients", "clients.id", "=", "tasks.client_id")
        ->orderBy("task_datetime", "DESC")
        ->get();
        
        $this->assertEquals($dummy, $test);
    }
}
