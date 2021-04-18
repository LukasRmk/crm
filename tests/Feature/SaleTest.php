<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sale;

class SaleTest extends TestCase
{

    public function test_findByClient(){
        $client_id = 29;
        $sales = Sale::findByClient($client_id);
        $dummySales = Sale::select("sale.*")
        ->where("client_id", $client_id)
        ->orderBy("created_at", "DESC")
        ->get();
        $this->assertEquals($dummySales, $sales);

    }

    public function test_findJoined(){
        $id = 1;
        $sales = Sale::findJoined($id);
        $dummySales = Sale::select("sale.*", "sale_stages.name as stage_name", "sale_windows.name as window_name", "users.name as user_name")
        ->where("sale.id", $id)
        ->leftJoin("sale_stages", "sale_stages.id", "=", "sale.stage")
        ->leftJoin("sale_windows", "sale_windows.id", "=", "sale.window")
        ->leftJoin("users", "users.id", "=", "sale.added_by")
        ->get();

        $this->assertEquals($dummySales, $sales);

    }

    public function test_findJoinedAll(){
        $sales = Sale::findJoinedAll();
        $dummySales = Sale::select("sale.*", "sale_stages.name as stage_name", "sale_windows.name as window_name", "users.name as user_name", "clients.name as client_name")
        ->leftJoin("sale_stages", "sale_stages.id", "=", "sale.stage")
        ->leftJoin("sale_windows", "sale_windows.id", "=", "sale.window")
        ->leftJoin("users", "users.id", "=", "sale.added_by")
        ->leftJoin("clients", "clients.id", "=", "sale.client_id")
        ->get();

        $this->assertEquals($dummySales, $sales);

    }

    public function test_findByStage(){
        $stage = 5;
        $seller = 1;

        $sales = Sale::findByStage($stage, $seller);
        $dummySales = Sale::select("sale.*", "users.name as user_name", "clients.name as client_name")
        ->leftJoin("users", "users.id", "=", "sale.added_by")
        ->leftJoin("clients", "clients.id", "=", "sale.client_id")
        ->where("sale.stage", $stage)
        ->where("sale.added_by", $seller)
        ->where("sale.status", 0)
        ->orderBy("order_by", "ASC")
        ->get();

        $this->assertEquals($dummySales, $sales);

    }

    public function test_findByStageAll(){
        $stage = 5;
        
        $sales = Sale::findByStageAll($stage);
        $dummySales = Sale::select("sale.*", "users.name as user_name", "clients.name as client_name")
        ->leftJoin("users", "users.id", "=", "sale.added_by")
        ->leftJoin("clients", "clients.id", "=", "sale.client_id")
        ->where("sale.stage", $stage)
        ->where("sale.status", 0)
        ->orderBy("order_by", "ASC")
        ->get();

        $this->assertEquals($dummySales, $sales);

    }

    public function test_updateSalesOrder(){
        $orders = "1!2!3";
        $order = explode('!', $orders);

        $test = Sale::updateSalesOrder($order);
        $dummy = true;
        
        $this->assertEquals($dummy, $test);
    }

    public function test_findWonWithinPeriod(){
        $user = 1;
        $dateFrom = "2021-01-01";
        $dateTo = "2021-03-01";

        $sales = Sale::findWonWithinPeriod($dateFrom, $dateTo, $user);

        $dummySales = Sale::selectRaw("count(sale.id) as count")
        ->where("added_by", $user)
        ->where("status", 1)
        ->whereRaw("created_at BETWEEN '" . $dateFrom . " 00:00:01' AND '" . $dateTo . " 23:59:59'")
        ->get();

        $this->assertEquals($dummySales, $sales);

    }

    public function test_findWithinPeriod(){
        $user = 1;
        $dateFrom = "2021-01-01";
        $dateTo = "2021-03-01";

        $sales = Sale::findWithinPeriod($dateFrom, $dateTo, $user);

        $dummySales = Sale::selectRaw("count(sale.id) as count")
        ->where("added_by", $user)
        ->whereRaw("created_at BETWEEN '" . $dateFrom . " 00:00:01' AND '" . $dateTo . " 23:59:59'")
        ->get();

        $this->assertEquals($dummySales, $sales);

    }

    public function test_findYearlySales(){
        $user = 1;

        $sales = Sale::findYearlySales(1);

        $end = strtotime(date('Y-m-31'));
        $month = strtotime("-1 year", time());
        $index = 0; 

        while($month < $end){
            $from = date('Y-m-01', $month);
            $to = date('Y-m-t', $month);

            $dummySales[$index]['price'] = Sale::selectRaw(" IFNULL(SUM(price), 0) as profit")
                        ->whereRaw("status_change_date BETWEEN '" . $from . " 00:00:01' AND '" . $to . " 23:59:59' AND added_by = '". $user ."' AND status = '1'")
                        ->first()
                        ->profit;

            $dummySales[$index]['year'] = date('Y', $month);
            $dummySales[$index]['month'] = date('m', $month);

            $index++;
            $month = strtotime("+1 month", $month);
        } 

        $this->assertEquals($dummySales, $sales);

    }

}
