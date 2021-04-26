<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Contact;
use App\Http\Controllers\ContactController;

class ContactControllerTest extends TestCase
{
    public function test_create(){

        $cont = new ContactController();
        $index = $cont->create();

        $this->assertNotNull($index);
    }

    public function test_store(){

        $cont = new ContactController();
        $req = new Request();

        $data = [
            'contact_name' => 'name',
            'added_by' => 1,
            'client_id' => 1
        ];

        $req->replace($data);

        $index = $cont->store($req);

        $this->assertNotNull($index);
    }

    public function test_edit(){

        $contact = new ContactController();
        $contactDummy = Contact::find(3);

        $index = $contact->edit($contactDummy);

        $this->assertNotNull($index);
    }

    public function test_update(){

        $contact = new ContactController();
        $contactDummy = Contact::find(3);

        $req = new Request();

        $data = [
            'contact_name' => 'TestName',
            'client_id' => 1
        ];

        $req->replace($data);

        $index = $contact->update($req, $contactDummy);

        $this->assertNotNull($index);
    }

    public function test_destroy(){

        $contact = new ContactController();
        $contactDummy = contact::find(22);

        $index = $contact->destroy($contactDummy);

        $this->assertNotNull($index);
    }
}
