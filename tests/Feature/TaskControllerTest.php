<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Task;
use App\Models\TaskComment;
use App\Http\Controllers\TaskController;

class TaskControllerTest extends TestCase
{
    public function test_create(){

        $cont = new TaskController();
        $index = $cont->create();

        $this->assertNotNull($index);
    }

    public function test_store(){

        $cont = new TaskController();
        $req = new Request();

        $data = [
            'type_id' => 1,
            'task_name' => 'Testinis',
            'task_description' => 'Testinis',
            'task_datetime' => '2021-04-21 00:01:00',
            'added_by' => 1,
            'client_id' => 1
        ];

        $req->replace($data);

        $index = $cont->store($req);

        $this->assertNotNull($index);

        $data = [
            'type_id' => 1,
            'task_name' => 'Testinis',
            'task_description' => 'Testinis',
            'task_datetime' => '2021-04-21 00:01:00',
            'added_by' => 1,
            'client_id' => 1,
            'sale_id' => 1
        ];

        $req->replace($data);

        $index = $cont->store($req);

        $this->assertNotNull($index);
    }

    public function test_storeComment(){

        $cont = new TaskController();
        $req = new Request();

        $data = [
            'comment' => "testinis",
            'added_by' => 1,
            'task_id' => 14
        ];

        $req->replace($data);

        $index = $cont->storeComment($req);

        $this->assertNotNull($index);
    }

    public function test_show(){

        $Task = new TaskController();
        $TaskDummy = Task::find(14);
        $index = $Task->show($TaskDummy);

        $this->assertNotNull($index);
    }

    public function test_edit(){

        $Task = new TaskController();
        $TaskDummy = Task::find(14);

        $index = $Task->edit($TaskDummy);

        $this->assertNotNull($index);
    }

    public function test_update(){

        $contact = new TaskController();
        $contactDummy = Task::find(55);

        $req = new Request();

        $data = [
            'type_id' => 1,
            'task_name' => 'Testinis',
            'task_description' => 'Testinis',
            'task_datetime' => '2021-04-21 00:01:00',
            'client_id' => 1,
            'task_completed' => 1
        ];

        $req->replace($data);

        $index = $contact->update($req, $contactDummy);

        $this->assertNotNull($index);

        $data = [
            'type_id' => 1,
            'task_name' => 'Testinis',
            'task_description' => 'Testinis',
            'task_datetime' => '2021-04-21 00:01:00',
            'added_by' => 1,
            'client_id' => 1,
            'task_succesful' => 1
        ];

        $req->replace($data);

        $index = $contact->update($req, $contactDummy);

        $this->assertNotNull($index);
    }

    public function test_destroy(){

        $contact = new TaskController();
        $contactDummy = Task::find(52);

        $index = $contact->destroy($contactDummy);

        $this->assertNotNull($index);
    }

    public function test_destroyComment(){

        $contact = new TaskController();
        $contactDummy = TaskComment::find(25);

        $index = $contact->destroyComment($contactDummy);

        $this->assertNotNull($index);
    }
}
