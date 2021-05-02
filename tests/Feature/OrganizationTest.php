<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Organization;

class OrganizationTest extends TestCase
{
    public function test_findWithAdmin(){
        $id = 1;

        $org  = Organization::findWithAdmin();

        $orgdum  = Organization::selectRaw('organizations.*, users.name as admin_name')
        ->leftJoin("users", "users.id", "=", "organizations.admin")
        ->get();

        $this->assertEquals($orgdum, $org );

        $org  = Organization::findWithAdmin($id);

        $orgdum = Organization::selectRaw('organizations.*, users.name as admin_name')
        ->where("organizations.id", $id)
        ->leftJoin("users", "users.id", "=", "organizations.admin")
        ->get();

        $this->assertEquals($orgdum, $org);
    }
}
