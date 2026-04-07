<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', function (Request $request) {
    $credenciales = $request->validate([
        'usuario' => ['required', 'string'],
        'password' => ['required', 'string'],
    ], [
        'usuario.required' => 'El usuario es obligatorio.',
        'password.required' => 'La contraseña es obligatoria.',
    ]);

    $usuario = User::query()
        ->where('email', $credenciales['usuario'])
        ->orWhere('name', $credenciales['usuario'])
        ->first();

    if (! $usuario || ! Hash::check($credenciales['password'], $usuario->password)) {
        return back()
            ->withErrors(['usuario' => 'Usuario o contraseña incorrectos.'])
            ->withInput($request->only('usuario'));
    }

    return view('welcome', ['nombreCompleto' => $usuario->name]);
});
