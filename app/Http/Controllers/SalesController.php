<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stage;
use App\Models\Window;
use App\Models\User;
use App\Models\Client;
use App\Models\Task;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $windows = Window::all();
        $stages = Stage::all();
        $sales = Sale::findJoinedAll();
        $users = User::all();
        return view('sales.index', compact('users', 'sales', 'windows', 'stages'));
    }

    public function getSalesWindow($window, $seller){

        $stages = Stage::findByWindow($window);

        $table = "<table class='sales_window' id='main_sales_window'><thead><tr>";

        foreach($stages as $ind => $stage){
            $table .= "<th><b>" . $stage->name . "</b></th>";
        }
        $table .= "</tr><tr>";

        $width = (100 / count($stages)) . "%";

        foreach($stages as $ind => $stage){
            if($seller != 0){
                $sales = Sale::findByStage($stage->id, $seller);
            } else {
                $sales = Sale::findByStageAll($stage->id);
            }

            $table .= "<td id='head' style='width: ".$width."; max-width: ".$width."; '> <center> <table style='width: 100%;' class='table_to_sort' id='table_to_sort_$ind' stage_id='".$stage->id."'><tbody>"; 

            foreach($sales as $sind => $sale){
                $table .= "<tr value='$sale->id' id='$sale->id' ><td class='sale' id='sale_$sale->id' value='$sale->id' style='display:block;'><b style='font-size: 16px'><a href='".route('sales.show', $sale->id)."'>" . $sale->name . "</a></b><br>" . $sale->price . " €<br><a href='".route('clients.show', $sale->client_id)."'>" . $sale->client_name . "</a><br><i>" . $sale->user_name . "</i></td></tr>";
            }

            $table .= "<tfoot> <tr id='foot' style='border: 1px solid black'> <td id='foot' style='visibility: hidden; height:50px;'></td></tr></tfoot></tbody></table></center></td>";


        }

        $table .= "</tbody> </table>";

        return response()->json(['window'=>$table]);
    }

    public function setNewStage($sale, $stage){
        Sale::where("id", $sale)->update(["stage" => $stage]);
        return response("Done");
    }

    public function setNewOrder($order){
        $order = explode('!', $order);
        Sale::updateSalesOrder($order);
        
        return response('Done');
    }

    public function setStatus($status, $sale){
        Sale::where("id", $sale)->update(["status" => $status]);
        
        return response("done " . $status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $windows = Window::all();
        $stages = Stage::all();
        return view('sales.create', compact('windows', 'stages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'window' => 'required',
            'stage' => 'required',
            'info' => 'required'
        ]);

        Sale::create($request->all());
        $client = Client::find($request->input("client_id"));
        User::giveXp($request->input('added_by'), 5);

        return redirect()->route('clients.show', compact("client"))->with('sale_success', 'Pardavimas sukurtas!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $tasks = Task::findBySale($sale->id);
        $contacts = Contact::findByClient($sale->client_id);
        $sale = Sale::findJoined($sale->id)[0];
        return view('sales.show', compact(['sale', 'tasks', 'contacts']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $sale = Sale::findJoined($sale->id)[0];
        return view('sales.edit', compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'info' => 'required'
        ]);

        $sale->update($request->all());
        $sale = Sale::findJoined($sale->id)[0];

        return redirect()->route('sales.show', compact('sale'))
                        ->with('success','Pardavimas sėkmingai atnaujintas!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('clients.show', $sale->client_id)
                        ->with('sale_success','Pardavimas ištrintas!');
    }
}
