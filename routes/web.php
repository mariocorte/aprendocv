<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', function (Request $request) {
    $credenciales = $request->validate(
        [
            'usuario' => ['required', 'string'],
            'password' => ['required', 'string'],
        ],
        [
            'usuario.required' => 'El usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]
    );

    $usuario = DB::table('usuarios')
        ->where(function ($query) use ($credenciales) {
            $query->where('correo_electronico', $credenciales['usuario'])
                ->orWhere('numero_documento', $credenciales['usuario']);
        })
        ->first();

    if (! $usuario || ! Hash::check($credenciales['password'], $usuario->hash_contrasena)) {
        return back()
            ->withErrors(['usuario' => 'Usuario o contraseña incorrectos.'])
            ->withInput($request->only('usuario'));
    }

    $nombreCompleto = trim(sprintf('%s %s', $usuario->nombres, $usuario->apellidos));

    return view('welcome', ['nombreCompleto' => $nombreCompleto]);
});