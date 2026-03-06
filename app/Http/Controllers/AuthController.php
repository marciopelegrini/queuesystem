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
            //errors message
            [
                'username.required' => 'O usuario é obrigatorio',
                'username.email' => 'o usuario deve ser um email valido',
                'password.required' => 'A senha é obrigatoria',
                'password.regex' => 'A senha deve ter entre 6 e 16 caracteres, ter uma maiuscula e uma minuscula',
            ]);

        //User authentication
        $user = User::where('email', trim($request->username))
            ->where('active', true)
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('blocked_until')->orWhere('blocked_until', '<', now());
            })->first();

        //Check if users exists and password matches
        if ($user && Hash::check(trim($request->password), $user->password)) {
            //Login User
            $this->loginUser($user);
            //Redirect to HomePage
            return redirect()->route('home');
        } else {
            //Login failed
            return redirect()->back()->withInput()->with('server_error', 'Login inválido');
        }
    }

    private function loginUser(User $user)
    {
        //Update last login and reset other fields
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

    public function changePassword()
    {
        return view('auth.change_password_frm', ['subtitle' => 'Alterar senha']);
    }

    public function changePasswordSubmit(Request $request)
    {
        //form Validation
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,16}$/|confirmed'
        ],
        [
            'current_password' => 'A senha atual é obrigatória',
            'new_password.required' => 'A nova senha é obrigatoria',
            'new_password.regex' => 'A nova senha deve ter entre 6 e 16 caracteres, ter uma maiuscula e uma minuscula e um numero',
            'new_password.confirmed' => 'A nova senha e a confirmação não são iguais'
        ]);
        // get Authenticate user
        $user = auth()->user();

        //Check if the passwords matchs
        if (Hash::check($request->current_password, $user->password)){
            //Atualiza a senha
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('home')->with('message', 'Senha alterada com sucesso');
        } else {
            return redirect()->back()->with('server_error', 'Senha atual inválida');
        }
    }
}
