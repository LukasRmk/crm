<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\DB;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'avatar' => 'default.jpg',
        ])->validate();

        
        $org_id = (DB::table('organizations')->select('id')->orderBy('id', 'desc')->limit(1)->first()->id) + 1;
        $user_id = (DB::table('users')->select('id')->orderBy('id', 'desc')->limit(1)->first()->id) + 1;
        DB::insert('INSERT INTO organizations (id, name, admin, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', [$org_id, 'Nauja Organizacija', $user_id, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'avatar' => 'default.jpg',
            'organization_id' => $org_id 
        ]);
    }
}
