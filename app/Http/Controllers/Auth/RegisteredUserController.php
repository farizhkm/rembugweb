<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'address' => ['nullable', 'string'],
        'phone_number' => ['nullable', 'string'],
        'bio' => ['nullable', 'string'],
        'birthdate' => ['nullable', 'date'],
        'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
    ]);

    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $validated['profile_picture'] = $path;
    }

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'address' => $validated['address'] ?? null,
        'phone_number' => $validated['phone_number'] ?? null,
        'bio' => $validated['bio'] ?? null,
        'birthdate' => $validated['birthdate'] ?? null,
        'profile_picture' => $validated['profile_picture'] ?? null,
    ]);

    event(new Registered($user));
    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
    }
}
