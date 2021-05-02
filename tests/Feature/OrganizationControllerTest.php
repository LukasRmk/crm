<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Organization;
use App\Http\Controllers\OrganizationController;

class OrganizationControllerTest extends TestCase
{

    public function test_create(){

        $cont = new OrganizationController();
        $index = $cont->create();

        $this->assertNotNull($index);
    }

    public function test_store(){

        $cont = new OrganizationController();
        $req = new Request();

        $data = [
            'name' => 'testOrg',
            'admin' => '1'
        ];

        $req->replace($data);

        $index = $cont->store($req);

        $this->assertNotNull($index);
    }

    public function test_edit(){

        $Organization = new OrganizationController();
        $contactDummy = Organization::find(1);

        $index = $Organization->edit($contactDummy);

        $this->assertNotNull($index);
    }

    public function test_update(){

        $Organization = new OrganizationController();
        $contactDummy = Organization::find(1);

        $req = new Request();

        $data = [
            'name' => 'TestName'
        ];

        $req->replace($data);

        $index = $Organization->update($req, $contactDummy);

        $this->assertNotNull($index);
    }

    public function test_destroy(){

        $Organization = new OrganizationController();
        $contactDummy = Organization::find(9);

        $index = $Organization->destroy($contactDummy);

        $this->assertNotNull($index);
    }
}
