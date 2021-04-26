<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function giveXp($id, $xp){
        $current_xp = User::select("users.user_xp")
        ->where("id", $id)
        ->get();

        User::where('id', $id)
        ->update(['user_xp' => ($current_xp[0]['user_xp'] + $xp)]);
    }

    public static function getLevel($xp){
        $level = DB::table("xp_levels")
                ->where("xp_needed", "<=", $xp)
                ->orderBy("xp_needed", "desc")
                ->limit("1")
                ->get();

        return $level[0];
    }

    public static function getNextLevel($xp){
        $level = DB::table("xp_levels")
        ->where("xp_needed", ">", $xp)
        ->orderBy("xp_needed", "asc")
        ->limit("1")
        ->first();

        
        if(!isset($level)){
            $level = DB::table("xp_levels")
                ->where("xp_needed", "<=", $xp)
                ->orderBy("xp_needed", "desc")
                ->limit("1")
                ->first();
        }

        return $level->xp_needed;
    }
}
