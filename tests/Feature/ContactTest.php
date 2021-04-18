<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contact;

class ContactTest extends TestCase
{
 
    public function test_findByClient(){
        $client = 29;
        $contacts = Contact::findByClient($client);
        $dummyContacts = Contact::select("contacts.*")
                    ->where("client_id", $client)
                    ->orderBy("created_at", "desc")
                    ->get();

        $this->assertEquals($dummyContacts, $contacts);
    } 
    
}
