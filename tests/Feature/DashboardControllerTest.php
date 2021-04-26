<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Contact;
use App\Models\User;
use App\Http\Controllers\DashboardController;

class DashboardControllerTest extends TestCase
{
    public function test_index(){

        $dash = new DashboardController();
        $user = User::find(1);

        $response = $this->be($user)
        ->withSession(['foo' => 'bar'])
        ->get(route('dashboard.index'));

        $this->assertIsInt($response->status());
    }
}
