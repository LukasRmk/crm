<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Client;
use App\Http\Controllers\ClientController;

class ClientControllerTest extends TestCase
{
    public function test_create(){

        $cont = new ClientController();
        $index = $cont->create();

        $this->assertNotNull($index);
    }

    public function test_store(){

        $cont = new ClientController();
        $req = new Request();

        $data = [
            'name' => 'name',
            'country' => 'country',
            'town' => 'town',
            'address' => 'address',
            'added_by' => 1
        ];

        $req->replace($data);

        $index = $cont->store($req);

        $this->assertNotNull($index);
    }

    public function test_show(){

        $Client = new ClientController();
        $TaskDummy = Client::find(1);
        $index = $Client->show($TaskDummy);

        $this->assertNotNull($index);
    }

    public function test_edit(){

        $Client = new ClientController();
        $TaskDummy = Client::find(1);

        $index = $Client->edit($TaskDummy);

        $this->assertNotNull($index);
    }

    public function test_update(){

        $contact = new ClientController();
        $contactDummy = Client::find(1);

        $req = new Request();

        $data = [
            'name' => 'required',
            'country' => 'required',
            'town' => 'required',
            'address' => 'required'
        ];

        $req->replace($data);

        $index = $contact->update($req, $contactDummy);

        $this->assertNotNull($index);
    }

    public function test_destroy(){

        $contact = new ClientController();
        $contactDummy = Client::find(56);

        $index = $contact->destroy($contactDummy);

        $this->assertNotNull($index);
    }

}
