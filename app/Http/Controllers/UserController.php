<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show Register/Create Form
    public function create() {
        return view('users.register');
    }

    // Create New User
    public function store(Request $request) {
        $formFields = $request->validate([
            'name'=> ['required', 'min:3'],
            'email'=> ['required','email', Rule::unique('users','email')],
            'password'=> ['required', 'confirmed', 'min:6'],

        ]);
        $formFields['password'] = bcrypt($formFields['password']);
    
        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);
        return redirect('/')->with('message', 'User created and logged in');
    }

    // Logout User
    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'You have been logged out');
    }

    // Show Login Form
    public function login() {
        return view('users.login');
    }

    // Login Users
    public function loginUsers(Request $request) {
        $formFields = $request->validate([
            'email'=> ['required','email'],
            'password'=> ['required'],
        ]);

        // $user = User::where('email', $formFields['email'])->first();
        // if(!$user) { 
        //     return back()->with('message', 'User does not exist');
        // }
        // if(Hash::check($formFields['password'],$user['password'])) {
        //     auth()->login($user);
        //     return redirect('/')->with('message', 'User logged in successfully');
        // } else {
        //     return back()->with('message', 'Password incorrect');
        // }
        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message','User logged in successfully');
        }
        return back()->withErrors(['email'=> 'Invalid Credentials'])->onlyInput('email');
    }
}