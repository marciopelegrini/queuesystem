<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login_frm');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'username' => 'required|email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,16}$/'
        ],
        [
            'username.required' => 'O usuario é obrigatorio',
            'username.email'=> 'o usuario deve ser um email valido',
            'password.required' => 'A senha é obrigatoria',
            'password.regex'=> 'A senha deve ter entre 6 e 16 caracteres, ter uma maiuscula e uma minuscula',
        ]);

        echo "ok";
    }

    public function logout()
    {
        //Logout do usuario
    }
}
