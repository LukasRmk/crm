<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesController;
use App\Models\Sale;
use Auth;
class SalesControllerTest extends TestCase
{
    public function test_create(){

        $sale = new SalesController();
        $index = $sale->create();

        $this->assertNotNull($index);
    }

    public function test_show(){

        $sale = new SalesController();
        $saleDummy = Sale::find(1);
        $index = $sale->show($saleDummy);

        $this->assertNotNull($index);
    }

    public function test_edit(){

        $sale = new SalesController();
        $saleDummy = Sale::find(1);

        $index = $sale->edit($saleDummy);

        $this->assertNotNull($index);
    }

    public function test_store(){

        $client = new SalesController();
        $req = new Request();

        $data = [
            'name' => 'required',
            'price' => 3.80,
            'window' => 1,
            'stage' => 1,
            'client_id' => 1,
            'added_by' => 1,
            'info' => 'required'
        ];

        $req->replace($data);

        $index = $client->store($req);

        $this->assertNotNull($index);
    }

    public function test_update(){

        $client = new SalesController();
        $clientDummy = Sale::find(23);

        $req = new Request();

        $data = [
            'name' => 'test',
            'price' => 1500,
            'info' => 'test'
        ];

        $req->replace($data);

        $index = $client->update($req, $clientDummy);

        $this->assertNotNull($index);
    }

    public function test_setNewOrder(){
        $sale = new SalesController();
        $resp = $sale->setNewOrder("1!2!3");
        $this->assertNotNull($resp);

    }

    public function test_setStatus(){
        $sale = new SalesController();
        $saleNew = Sale::find(1);
        $resp = $sale->setStatus(0, $saleNew);
        $this->assertNotNull($resp);
    }

    public function test_setNewStage(){
        $sale = new SalesController();
        $saleNew = Sale::find(1);
        $resp = $sale->setNewStage($saleNew, 3);
        $this->assertNotNull($resp);
    }

    public function test_getSalesWindow(){
        $sale = new SalesController();
        $saleNew = Sale::find(1);
        $resp = $sale->getSalesWindow(1, 1);
        $this->assertNotNull($resp);
        $resp = $sale->getSalesWindow(1, 0);
        $this->assertNotNull($resp);
    }

    public function test_destroy(){

        $sale = new SalesController();
        $saleDummy = Sale::find(38);

        $index = $sale->destroy($saleDummy);

        $this->assertNotNull($index);
    }

}
