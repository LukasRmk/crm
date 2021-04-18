<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Stage;
use Tests\TestCase;

class StageTest extends TestCase
{
 
    public function test_updateOrder(){
        $order = "1!2!3!4";
        $order = explode('!', $order);

        $stage = Stage::updateOrder($order);
        $dummy = true;
        
        $this->assertEquals($dummy, $stage);
    }
    
    public function test_getOrdered(){
        $stages = Stage::getOrdered();
        $dummyStages = Stage::select("sale_stages.*")
        ->orderBy("order_by", "ASC")
        ->get();

        $this->assertEquals($dummyStages, $stages);

    }

    public function test_findByWindow(){
        $window = 1;

        $stages = Stage::findByWindow($window);
        $dummyStages = Stage::select("sale_stages.*")
        ->where('window_id', $window)
        ->orderBy("order_by", "ASC")
        ->get();

        $this->assertEquals($dummyStages, $stages);
    }

}
