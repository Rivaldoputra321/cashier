<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function indexadmin(Request $request)
    {
        return view('login');
    }
    public function indexowner(Request $request)
    {
        return view('login_owner');
    }

    public function indexstaff(Request $request)
    {
        return view('loginStaff');
    }


    public function indexreg(Request $request)
    {
        return view('register');
    }


    public function register(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|unique:users,name',
        'email'=> 'required|email|unique:users,email',
        'password'=> 'required|min:6',
    ]);

    // If validation passes, create the new user
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'role' => 'admin',
        'status' => 'inactive',
    ]);

    // Redirect to the login page with a success message
    return redirect('login')->with('success', 'Registration successful. Waiting Owner To Active Account');
}


    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required',],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            if(Auth::user()->status != 'active'){
                Auth::logout();
                return redirect('login')->with('error', 'Your Account Is Not Active Yet. Contact Owner');
            }
            $role = Auth::user()->role;
                switch ($role){
                    case 'admin':
                        return redirect('dashboard');
                }
        }
        Auth::logout();
        return redirect('login')->with('error', 'Invalid email or password.');

    }
    public function loginowner(Request $request){
        $credentials = $request->validate([
            'email' => ['required',],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $role = Auth::user()->role;
                switch ($role){
                    case 'owner':
                        return redirect('dashboard');
                }
        }
        Auth::logout();
        return redirect('loginowner')->with('error', 'Invalid email or password.');

    }
    public function loginstaff(Request $request){
        $credentials = $request->validate([
            'email' => ['required',],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $role = Auth::user()->role;
                switch ($role){
                    case 'staff':
                        return redirect('dashboard');
                }
        }
        Auth::logout();
        return redirect('loginstaff')->with('error', 'Invalid email or password.');

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('begin');
    }
}
