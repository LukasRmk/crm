<?php

namespace App\Http\Controllers;

use App\Models\Window;
use App\Models\Stage;
use Illuminate\Http\Request;

class WindowController extends Controller
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
        return view('windows.index', compact('windows', 'stages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('windows.create');
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
            'name' => 'required'
        ]);
        
        Window::create($request->all());

        return redirect()->route('windows.index')->with('success', 'Langas sukurtas!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Window  $window
     * @return \Illuminate\Http\Response
     */
    public function show(Window $window)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Window  $window
     * @return \Illuminate\Http\Response
     */
    public function edit(Window $window)
    {
        return view('windows.edit', compact('window'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Window  $window
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Window $window)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $window->update($request->all());

        return redirect()->route('windows.index')
                        ->with('success','Langas sėkmingai atnaujintas!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Window  $window
     * @return \Illuminate\Http\Response
     */
    public function destroy(Window $window)
    {
        //
    }
}
