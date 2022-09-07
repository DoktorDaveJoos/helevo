<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Settings', [
            'name' => $user->name,
            'prefix' => $user->prefix,
            'logo' => $user->logo_path,
            'text' => $user->welcome_text
        ]);
    }

    public function update(SettingsRequest $request): \Illuminate\Http\RedirectResponse
    {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos');
            $user->logo_path = $path;
        }

        if (array_key_exists('prefix', $validated)) {
            $user->prefix = strtoupper($validated['prefix']);
        }

        if (array_key_exists('name', $validated)) {
            $user->name = $validated['name'];
        }

        if(array_key_exists('text', $validated)) {
            $user->welcome_text = $validated['text'];
        }

        $user->save();

        return Redirect::route('settings');
    }

    public function displayLogo($filename): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return Storage::download('logos/' . $filename);
    }


}
