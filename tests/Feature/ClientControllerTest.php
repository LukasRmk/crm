<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Client;
use App\Http\Controllers\ClientController;
class ClientControllerTest extends TestCase
{
    public function test_index(){

        $client = new ClientController();
        $index = $client->index();

        $this->assertNotNull($index);

        $response = $this->get(route('clients.index'));
        $this->assertIsInt($response->status());
    }

    public function test_create(){

        $client = new ClientController();
        $index = $client->create();

        $this->assertNotNull($index);
    }

    public function test_store(){

        $client = new ClientController();
        $req = new Request();

        $data = [
            'name' => 'name',
            'country' => 'country',
            'town' => 'town',
            'address' => 'address',
            'added_by' => 1
        ];

        $req->replace($data);

        $index = $client->store($req);

        $this->assertNotNull($index);
    }

    public function test_show(){

        $client = new ClientController();
        $clientDummy = Client::find(1);
        $index = $client->show($clientDummy);

        $this->assertNotNull($index);
    }

    public function test_edit(){

        $client = new ClientController();
        $clientDummy = Client::find(1);

        $index = $client->edit($clientDummy);

        $this->assertNotNull($index);
    }

    public function test_update(){

        $client = new ClientController();
        $clientDummy = Client::find(28);

        $req = new Request();

        $data = [
            'name' => 'TestName',
            'country' => 'TestCountry',
            'town' => 'TestTown',
            'address' => 'TestAddress'
        ];

        $req->replace($data);

        $index = $client->update($req, $clientDummy);

        $this->assertNotNull($index);
    }

    public function test_destroy(){

        $client = new ClientController();
        $clientDummy = Client::find(38);

        $index = $client->destroy($clientDummy);

        $this->assertNotNull($index);
    }
}
