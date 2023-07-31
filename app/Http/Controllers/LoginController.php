<?php
 
namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

 
class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */

    public function formLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }else{
            return view('login');
        }
    }

    public function actionLogin(Request $request)
    {
        $user = User::where('username', $request->username)
                  ->where('password',md5($request->password))
                  ->first();

        if ($user) {

        Auth::login($user);
        return redirect('/dashboard');

        } else {

        return redirect('/login')->with('danger', 'Username atau password salah!');
    }

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');
    }
}