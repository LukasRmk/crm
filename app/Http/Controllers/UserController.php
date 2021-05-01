<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Achievement;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::findWithOrganization();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = Organization::all();
        return view('users.create', compact('organizations'));
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
            'email' => 'required',
            'password' => 'required',
            'avatar' => 'required'
        ]);

        $request->merge([
            'password' => bcrypt($request->password)
        ]);

        User::create($request->all());
        $users = User::findWithOrganization();

        return redirect()->route('users.index', compact('users'))->with('success', 'Klientas pridėtas!');
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

        $first = DB::table('period_awards')->where("user_id", "=", $user->id)->where("place", "=", "1")->get();
        $second = DB::table('period_awards')->where("user_id", "=", $user->id)->where("place", "=", "2")->get();
        $third = DB::table('period_awards')->where("user_id", "=", $user->id)->where("place", "=", "3")->get();


        return view('user.show', compact('user', 'userLevel', 'nextLevel', 'achievements', 'first', 'second', 'third'));
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function adminEdit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function adminUpdate(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required'
        ]);

        $users = User::findWithOrganization();
        
        return redirect()->route('users.index', compact('users'))
                        ->with('success', 'Profilis sėkmingai atnaujintas!');
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
        
        if(Auth::user()->is_admin && $user->id != Auth::user()->id){
            $users = User::findWithOrganization();
        
            return redirect()->route('users.index', compact('users'))
                        ->with('success', 'Profilis sėkmingai atnaujintas!');
        } else {
            return redirect()->route('user.show', compact('user', 'userLevel', 'nextLevel'))
            ->with('success', 'Profilis sėkmingai atnaujintas!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                        ->with('success','Vartotojas ištrintas!');
    }
}
