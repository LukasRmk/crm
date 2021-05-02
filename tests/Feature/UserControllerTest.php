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

    public function test_adminUpdate(){

        $contact = new UserController();
        $contactDummy = User::find(3);

        $req = new Request();

        $data = [
            'email' => "test@mail.com",
            'name' => 'testing'
        ];

        $req->replace($data);

        $index = $contact->adminUpdate($req, $contactDummy);

        $this->assertNotNull($index);
    }

    public function test_create(){

        $user = new UserController();
        $index = $user->create();

        $this->assertNotNull($index);
    }

    public function test_store(){

        $user = new UserController();
        $req = new Request();

        $data = [
            'name' => 'name',
            'email' => 'mail@mail',
            'password' => 'password',
            'avatar' => 'default.jpg'
        ];

        $req->replace($data);

        $index = $user->store($req);

        $this->assertNotNull($index);
    }

    public function test_adminEdit(){
        $contact = new UserController();
        $contactDummy = User::find(3);

        $index = $contact->adminEdit($contactDummy);

        $this->assertNotNull($index);
    }

    public function test_destroy(){
        $user = new UserController();
        $userDummy = User::find(18);

        $index = $user->destroy($userDummy);

        $this->assertNotNull($index);
    }
}
