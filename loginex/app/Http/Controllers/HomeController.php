<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming you have a User model
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Fetch data for the logged-in user
            $user = Auth::user();

            // Pass the user's data to the view
            return view('home', ['user' => $user]);
        } else {
            // Redirect the user to the login page if they are not authenticated
            return redirect()->route('login');
        }
    }
}
