<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserTest extends TestCase
{

    public function test_giveXp(){
        $id = 1;
        $xpAdd = 10;

        $current_xp = User::select("users.user_xp")
        ->where("id", $id)
        ->get();

        $xp = User::giveXp($id, $xpAdd);

        $new_xp = $current_xp[0]['user_xp'] + $xpAdd;

        $this->assertEquals($new_xp, $xp);
    }

    public function test_getLevel(){
        $xp = 150;
        $levelDummy = DB::table("xp_levels")
        ->where("xp_needed", "<=", $xp)
        ->orderBy("xp_needed", "desc")
        ->limit("1")
        ->get();

        $level = User::getLevel($xp);
        
        $this->assertEquals($levelDummy[0], $level);

    }

    public function test_getNextLevel(){
        $xp = 150;

        $level = User::getNextLevel($xp);
        $levelDummy = DB::table("xp_levels")
                ->where("xp_needed", ">", $xp)
                ->orderBy("xp_needed", "asc")
                ->limit("1")
                ->get();

        $this->assertEquals($levelDummy[0]->xp_needed, $level);
    }

}
