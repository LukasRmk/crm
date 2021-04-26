<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
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
            'contact_name' => 'required'
        ]);

        Contact::create($request->all());
        User::giveXp($request->input('added_by'), 1);

        $client = Client::find($request->input("client_id"));

        return redirect()->route('clients.show', compact("client"))->with('contact_success', 'Kontaktas pridėtas!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'contact_name' => 'required'
        ]);

        $contact->update($request->all());
        $client = Client::find($contact->client_id);

        return redirect()->route('clients.show', compact('client'))
                        ->with('contact_success','Kontaktas sėkmingai atnaujintas!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $client = Client::find($contact->client_id);
        $contact->delete();

        return redirect()->route('clients.show', compact('client'))
                        ->with('contact_success','Kontaktas ištrintas!');
    }
}
