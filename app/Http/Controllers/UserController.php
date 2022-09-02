<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Settings', [
            'prefix' => Auth::user()->prefix
        ]);
    }

    public function update(SettingsRequest $request) {

        $validated = $request->validated();

        ray($validated);

        $user = $request->user();

        $user->prefix = strtoupper($validated['prefix']);
        $user->save();

        return Redirect::route('settings');
    }


}
