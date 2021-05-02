<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\User;
use Auth;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->is_admin){
            $organizations = Organization::findWithAdmin();
        } else {
            $organizations = Organization::findWithAdmin(Auth::user()->organization_id);
        }

        return view("organizations.index", compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::findNonAdmins();
        return view('organizations.create', compact('users'));
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

        Organization::create($request->all());
        $organizations = Organization::findWithAdmin();

        return redirect()->route('organizations.index', compact('organizations'))->with('success', 'Organizacija pridėta!');
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
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        $users = User::all();
        return view("organizations.edit", compact('users', 'organization'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $organization->update($request->all());
        $organizations = Organization::findWithAdmin();

        return redirect()->route('organizations.index', compact('organizations'))
                        ->with('success','Organizacija sėkmingai atnaujinta!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('organizations.index')
                        ->with('success','Organizacija ištrinta!');
    }
}
