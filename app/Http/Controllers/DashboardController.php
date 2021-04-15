<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Task;
use App\Models\Client;
use Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::getDashboardTasks(Auth::user()->id);
        
        $dateFrom = date('Y-m') . '-01';
        $dateTo = date('Y-m-t');
        
        $salesWon = Sale::findWonWithinPeriod($dateFrom, $dateTo, Auth::user()->id);
        $salesTotal = Sale::findWithinPeriod($dateFrom, $dateTo, Auth::user()->id);

        $callsWon = Task::findWonWithinPeriod($dateFrom, $dateTo, Auth::user()->id, 1);
        $callsTotal = Task::findWithinPeriod($dateFrom, $dateTo, Auth::user()->id, 1);

        $meetsWon = Task::findWonWithinPeriod($dateFrom, $dateTo, Auth::user()->id, 2);
        $meetsTotal = Task::findWithinPeriod($dateFrom, $dateTo, Auth::user()->id, 2);
        
        $yearlySales = Sale::findYearlySales(Auth::user()->id);
        
        return view('dashboard.index', compact('tasks', 'salesWon', 'salesTotal', 'callsWon', 'callsTotal', 'meetsWon', 'meetsTotal', 'yearlySales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
