<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::logout();  // Log the user out
        return redirect('/welcome');  // Redirect to the welcome page after logging out
    }
}
