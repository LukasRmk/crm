<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Controllers\StageController;
use App\Models\Stage;

class StageControllerTest extends TestCase
{
    public function test_create(){

        $Stage = new StageController();
        $index = $Stage->create();

        $this->assertNotNull($index);
    }

    public function test_store(){

        $Stage = new StageController();
        $req = new Request();

        $data = [
            'name' => 'Test',
            'window_id' => 1,
        ];

        $req->replace($data);
        $index = $Stage->store($req);
        $this->assertNotNull($index);
    }

    public function test_edit(){

        $Stage = new StageController();
        $StageDummy = Stage::find(2);

        $index = $Stage->edit($StageDummy);

        $this->assertNotNull($index);
    }

    public function test_update(){

        $Stage = new StageController();
        $StageDummy = Stage::find(2);

        $req = new Request();

        $data = [
            'name' => 'test',
        ];

        $req->replace($data);
        $index = $Stage->update($req, $StageDummy);
        $this->assertNotNull($index);
    }

    public function test_updateStageOrder(){
        $Stage = new StageController();
        $index = $Stage->updateStageOrder("1!2!3!4");
        $this->assertNotNull($index);
    }

    public function test_destroy(){

        $sale = new StageController();
        $saleDummy = Stage::find(12);

        $index = $sale->destroy($saleDummy);

        $this->assertNotNull($index);
    }
}
