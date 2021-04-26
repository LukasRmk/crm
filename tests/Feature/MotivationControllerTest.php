<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Http\Controllers\MotivationController;

class MotivationControllerTest extends TestCase
{
    public function test_index(){

        $mot = new MotivationController();
        $index = $mot->index();
        $this->assertNotNull($mot);

        $response = $this->get(route('motivation.index'));
        $this->assertIsInt($response->status());
    }

    public function test_showResults(){

        $mot = new MotivationController();
        $periods = ['year', 'month', 'week', 'custom'];
        $customFrom = date('Y-m-d');
        $customTo = date('Y-m-t');
        foreach($periods as $period){
            $index = $mot->showResults($period, $customFrom, $customTo);
            $this->assertIsInt($index->status());
        }

    }
}
