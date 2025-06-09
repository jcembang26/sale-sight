<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{
    /**
     * Store a new user in the database
     *
     * hashes the password, and creates a user record
     *
     * @param Request $request
     * @return object
     */
    public function store(Request $request): object;
}
