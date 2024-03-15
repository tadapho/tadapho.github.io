<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function check(Request $request)
    {
        // Retrieve name and password from the request
        $name = $request->input('username');
        $password = $request->input('password');

        // Query the database to check if the name and password
        $user = User::where('name', $name)->where('password', $password)->first();

        if ($user) {
            // Return 1 if username and password are correct
            Auth::login($user);
            return response()->json(1);
        } else {
            // Return 3 if username or password is incorrect
            return response()->json(3);
        }
    }
}
