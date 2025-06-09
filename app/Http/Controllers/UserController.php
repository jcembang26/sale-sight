<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Register a new user
     *
     * Validates required parameters
     * Delegates request handling to the UserService store method
     *
     * @param UserInterface $userInterface
     * @param Request $request
     * @return object
     */
    public function register(UserInterface $userInterface, Request $request): object
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'password' => 'required|min:6'
        ]);

        return $userInterface->store($request);
    }
}
