<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $user = User::where('email', trim($request->username))
            ->where('active', true)
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('blocked_until')->orWhere('blocked_until', '<', now());
            })->first();

        if ($user && Hash::check(trim($request->password), $user->password)) {
            //Login sucessful
            $this->loginUser($user);
            return redirect()->route('home');
        } else{
            //Login failled
            return redirect()->back()->withInput()->with('server_error', 'Login invalido');
        }
    }

    private function loginUser(User $user)
    {
        //Update last login
        $user->last_login = now();
        $user->code = null;
        $user->code_expiration = null;
        $user->blocked_until = null;
        $user->save();

        //Place user in session
        auth()->login($user);
    }

    public function logout()
    {
        //Logout do usuario
        auth()->logout();

        //invalidate session
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
