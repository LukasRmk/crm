<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sale;
use App\Models\Task;
use App\Models\Client;

class MotivationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('motivation.index');
    }

    public function showResults($period, $customFrom, $customTo){

        switch ($period) {
            case 'year':
                $dateFrom = date('Y') . '-01-01';
                $dateTo = date('Y') . '-12-31';
                break;
            case 'month':
                $dateFrom = date('Y-m') . '-01';
                $dateTo = date('Y-m-t');
                break;
            case 'week':
                $dateFrom = date('Y-m-d', strtotime('monday this week'));
                $dateTo = date('Y-m-d', strtotime('sunday this week'));
                break;
            case 'custom':
                $dateFrom = $customFrom;
                $dateTo = $customTo;
                break;
        }

        $users = User::all();

        $usersResults = [];

        foreach($users as $user){
            $salesWon = Sale::findWonWithinPeriod($dateFrom, $dateTo, $user->id);
            $salesTotal = Sale::findWithinPeriod($dateFrom, $dateTo, $user->id);

            $tasksWon = Task::findWonWithinPeriod($dateFrom, $dateTo, $user->id);
            $tasksTotal = Task::findWithinPeriod($dateFrom, $dateTo, $user->id);

            $clientsAdded = Client::findWithinPeriod($dateFrom, $dateTo, $user->id);

            $ranking = $salesWon[0]->count * 5 + $salesTotal[0]->count * 2 + $tasksWon[0]->count * 3 + $tasksTotal[0]->count * 2 + $clientsAdded[0]->count * 3;

            $userResults = [
                "avatar" => $user->avatar,
                "id" => $user->id,
                "name" => $user->name,
                "xp" => $user->user_xp,
                "salesWon" => $salesWon[0]->count,
                "salesTotal" => $salesTotal[0]->count,
                "tasksWon" => $tasksWon[0]->count,
                "tasksTotal" => $tasksTotal[0]->count,
                "clientsAdded" => $clientsAdded[0]->count,
                "ranking" => $ranking
            ];

            array_push($usersResults, $userResults);

        }

        $ranking = array_column($usersResults, 'ranking');

        array_multisort($ranking, SORT_DESC, $usersResults);

        $table = "<table class='table table'><thead class='thead-light'><tr> 
        <th>Vieta</th> 
        <th>Vartotojas</th> 
        <th>Laimėti pardavimai</th> 
        <th>Laimėtos užduotys</th> 
        <th>Nauji klientai</th> 
        </tr></thead>"; 
        
        foreach($usersResults as $index => $user){
            if($index == 0){
                $color = 'gold';
            } else if($index == 1){
                $color = 'silver';
            } else if($index == 2){
                $color = '#CD7F32';
            } else {
                $color = 'transparent';
            }

            $table .= "<tr>
            <td><i class='fas fa-medal' style='color: $color'></i>&nbsp;<b>" . ($index + 1) . ". </b></td>
            <td><img src=". asset('avatars/'.$user['avatar'])." alt='Avatar' style='width: 40px; height:40px; float:left; border-radius:50%; ". User::getLevel($user['xp'])->border . " ' >&nbsp; &nbsp;" . $user['name'] . "</td>
            <td>" . $user['salesWon'] . "/" . $user['salesTotal'] . "</td>
            <td>" . $user['tasksWon'] . "/" . $user['tasksTotal'] . "</td>
            <td>" . $user['clientsAdded'] . "</td>
            </tr>";
        }

        $table .= "</tbody></table>";

        return response()->json(['results'=>$table]);

    }
   
}
