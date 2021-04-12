<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $userLevel = User::getLevel(json_decode($user, true)["user_xp"]);
        $nextLevel = User::getNextLevel(json_decode($user, true)["user_xp"]);
        $achievements = Achievement::getAchievementsWithProgress(json_decode($user, true)["id"]);
        return view('user.show', compact('user', 'userLevel', 'nextLevel', 'achievements'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required'
        ]);

        if($request->hasFile('picture')){
            $picture = $request->file('picture')->getRealPath();
            $filename = time() . '.jpg';
            Image::make($picture)->resize(300, 300)->save(public_path('avatars/' . $filename));
            $user->avatar = $filename;
        }
        $user->update($request->all());

        $userLevel = User::getLevel(json_decode($user, true)["user_xp"]);
        $nextLevel = User::getNextLevel(json_decode($user, true)["user_xp"]);
        
        return redirect()->route('user.show', compact('user', 'userLevel', 'nextLevel'))
                        ->with('success', 'Profilis sėkmingai atnaujintas!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
