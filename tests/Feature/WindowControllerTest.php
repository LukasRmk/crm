<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Window;
use App\Http\Controllers\WindowController;


class WindowControllerTest extends TestCase
{
    public function test_index(){

        $client = new WindowController();
        $index = $client->index();

        $this->assertNotNull($index);

        $response = $this->get(route('windows.index'));
        $this->assertIsInt($response->status());
    }

    public function test_create(){

        $cont = new WindowController();
        $index = $cont->create();

        $this->assertNotNull($index);
    }

    public function test_store(){

        $cont = new WindowController();
        $req = new Request();

        $data = [
            'name' => 'TEstavimo laangas'
        ];

        $req->replace($data);

        $index = $cont->store($req);

        $this->assertNotNull($index);
    }

    
    public function test_edit(){

        $Task = new WindowController();
        $TaskDummy = Window::find(1);

        $index = $Task->edit($TaskDummy);

        $this->assertNotNull($index);
    }

    public function test_update(){

        $contact = new WindowController();
        $contactDummy = Window::find(3);

        $req = new Request();

        $data = [
            'name' => 'Testinis',
        ];

        $req->replace($data);

        $index = $contact->update($req, $contactDummy);

        $this->assertNotNull($index);
    }
}
