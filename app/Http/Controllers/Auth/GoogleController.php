<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user's email domain is allowed
            $domain = explode('@', $googleUser->email)[1];
            $allowedDomains = explode(',', config('auth.allowed_domains'));
            
            if (!in_array($domain, $allowedDomains)) {
                return redirect()->route('login')
                    ->with('error', 'Your email domain is not authorized.');
            }

            $user = User::updateOrCreate([
                'email' => $googleUser->email
            ], [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'role_id' => UserRole::STUDENT // Default role
            ]);

            Auth::login($user);
            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            Log::error('Google authentication error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Authentication failed. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
} 