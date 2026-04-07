<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso</title>
    <style>
        :root {
            --fondo-base: #0f0f10;
            --texto-principal: #ffffff;
            --texto-secundario: #f3f4f6;
            --sombra: rgba(0, 0, 0, 0.45);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            color: var(--texto-principal);
            background-color: var(--fondo-base);
            background-image:
                linear-gradient(var(--sombra), var(--sombra)),
                url('{{ asset('images/backgrounds/bienvenida.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        @media (max-width: 768px) {
            body {
                background-image:
                    linear-gradient(var(--sombra), var(--sombra)),
                    url('{{ asset('images/backgrounds/bienvenidasm.png') }}');
            }
        }

        .card {
            width: min(430px, 100%);
            background-color: rgba(0, 0, 0, 0.58);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.95rem;
        }

        input {
            width: 100%;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 0.7rem;
            background: rgba(255, 255, 255, 0.92);
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        button {
            width: 100%;
            border: 0;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: bold;
            font-size: 1rem;
            background: #22c55e;
            color: #052e16;
            cursor: pointer;
        }

        .error {
            display: block;
            margin-top: -0.7rem;
            margin-bottom: 0.9rem;
            color: #fecaca;
            font-size: 0.85rem;
        }

        .bienvenida {
            font-size: 1.2rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <section class="card">
        @isset($nombreCompleto)
            <h1>¡Bienvenido!</h1>
            <p class="bienvenida">Hola, {{ $nombreCompleto }}. Ingresaste correctamente.</p>
        @else
            <h1>Iniciar sesión</h1>

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <label for="usuario">Usuario</label>
                <input id="usuario" name="usuario" type="text" value="{{ old('usuario') }}" required autofocus>
                @error('usuario')
                    <span class="error">{{ $message }}</span>
                @enderror

                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror

                <button type="submit">Ingresar</button>
            </form>
        @endisset
    </section>
</body>
</html>
