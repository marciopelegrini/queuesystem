<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        echo "Formulario de login";
    }

    public function loginSubmit(Request $request)
    {
        //Tratamento do formulario
    }

    public function logout()
    {
        //Logout do usuario
    }
}
