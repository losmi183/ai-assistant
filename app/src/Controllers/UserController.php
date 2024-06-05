<?php

namespace App\Controllers;

class UserController
{
    public function show($params)
    {
        // Logika za prikaz korisnika
        echo "User ID: " . $params['id'];
    }
}