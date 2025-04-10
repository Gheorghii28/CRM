<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GuestLoginController extends Controller
{
    public function login()
    {
        $guest = User::where('email', 'guest@example.com')->first();

        if ($guest) {
            Auth::login($guest);
            return redirect()->route('dashboard.index')->with('status', 'You are now logged in as a guest.');
        }

        return redirect()->route('login')->withErrors(['guest' => 'Guest access is currently unavailable.']);
    }
}
