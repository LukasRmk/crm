<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Client;

class ClientTest extends TestCase
{
    public function test_findWithinPeriod(){
        $user = 1;
        $dateFrom = "2021-01-01";
        $dateTo = "2021-03-01";

        $clients = Client::findWithinPeriod($dateFrom, $dateTo, $user);

        $dummyClients = Client::selectRaw("count(clients.id) as count")
        ->where("added_by", $user)
        ->whereRaw("created_at BETWEEN '" . $dateFrom . " 00:00:01' AND '" . $dateTo . " 23:59:59'")
        ->get();

        $this->assertEquals($dummyClients, $clients);
    }
}