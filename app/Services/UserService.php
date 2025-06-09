<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Stores a new user in the database
     *
     * Password is hashed before storing
     * Generates API token upon successful registration
     *
     * @param Request $request
     * @return object
     */
    public function store(Request $request): object
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        if(!$user){
            return response()->json([
                'message' => 'Something went wrong with this action. Please contact your admin!'
            ], 500);
        }
    
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Your successfully registered!',
            'token' => $token
        ]);
    }
}
