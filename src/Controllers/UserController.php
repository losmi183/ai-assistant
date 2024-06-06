<?php

namespace App\Controllers;

class UserController
{
    public function index()
    {
        echo "List of users";
    }

    public function show($id)
    {
        echo "User with ID: $id";
    }
}