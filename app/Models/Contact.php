<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'contact_name',
        'position',
        'phone_no',
        'email'
    ];

    public static function findByClient($client_id){
        
        $tasks = Contact::select("contacts.*")
                    ->where("client_id", $client_id)
                    ->orderBy("created_at", "desc")
                    ->get();
    
        return $tasks;          
    }
}
