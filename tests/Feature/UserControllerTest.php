<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\UserController;

class UserControllerTest extends TestCase
{
    public function test_show(){

        $controller = new UserController();
        $testdata = User::find(3);
        $index = $controller->show($testdata);

        $this->assertNotNull($index);
    }

    public function test_edit(){

        $contact = new UserController();
        $contactDummy = User::find(3);

        $index = $contact->edit($contactDummy);

        $this->assertNotNull($index);
    }

    public function test_update(){

        $contact = new UserController();
        $contactDummy = User::find(3);

        $req = new Request();

        $data = [
            'email' => "gytis@mail.com",
            'name' => 'Gytis Sniečkus'
        ];

        $req->replace($data);

        $index = $contact->update($req, $contactDummy);

        $this->assertNotNull($index);
    }
}
