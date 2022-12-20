<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    private $serviceAPi;

    public function __construct()
    {
    }
    function index()
    {
        // return "hello";
        return view('login', ["title" => "Login"]);
    }

    function login(Request $request)
    {

        $username = $request->input("username");
        $password = $request->input("password");

        // return dd($body);


        $user = DB::table('users')->where('username', $username)->first();

        if($user->username == 'admin'&& Hash::check($password, $user->password)) {
            session([
                "login"=>true,
                "name"=>'admin',
            ]);
            return redirect()->intended('/dashboard');
        }else {
            return back()->with('loginError', 'Username dan Password Salah!');
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('');
    }
}
