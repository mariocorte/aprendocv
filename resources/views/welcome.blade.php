<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
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
            display: grid;
            place-items: center;
            padding: 1.5rem;
        }

        @media (max-width: 768px) {
            body {
                background-image:
                    linear-gradient(var(--sombra), var(--sombra)),
                    url('{{ asset('images/backgrounds/bienvenidasm.png') }}');
            }
        }

        .container {
            width: min(92vw, 680px);
            text-align: center;
            padding: 2rem;
            border-radius: 1rem;
            background-color: rgba(0, 0, 0, 0.42);
            backdrop-filter: blur(1px);
        }

        h1 {
            margin: 0 0 1rem;
            color: #ff4d4d;
            font-size: clamp(1.9rem, 3vw, 2.5rem);
        }

        p {
            margin: 0;
            color: var(--texto-secundario);
            font-size: clamp(1rem, 1.5vw, 1.2rem);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido Mario</h1>
        <p>Base de datos conectada: {{ \Illuminate\Support\Facades\DB::connection()->getDatabaseName() ?? 'No disponible' }}</p>
    </div>
</body>
</html>
