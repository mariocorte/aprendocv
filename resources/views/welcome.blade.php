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
        }

        @media (max-width: 768px) {
            body {
                background-image:
                    linear-gradient(var(--sombra), var(--sombra)),
                    url('{{ asset('images/backgrounds/bienvenidasm.png') }}');
            }
        }

        .pie-pagina {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 1rem;
            text-align: center;
            color: var(--texto-secundario);
            background-color: rgba(0, 0, 0, 0.55);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.95rem;
            letter-spacing: 0.015em;
        }

        .estado-ok {
            color: #86efac;
        }

        .estado-error {
            color: #fca5a5;
        }

        .detalle-error {
            margin-top: 0.35rem;
            display: block;
            font-size: 0.85rem;
            color: #fecaca;
        }
    </style>
</head>
<body>
    @php
        $conexionExitosa = true;
        $errorConexion = null;

        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
        } catch (\Throwable $e) {
            $conexionExitosa = false;
            $errorConexion = $e->getMessage();
        }
    @endphp

    <footer class="pie-pagina">
        @if ($conexionExitosa)
            <span class="estado-ok">Conexión a la base exitosa.</span>
        @else
            <span class="estado-error">Error de conexión a la base de datos.</span>
            <span class="detalle-error">{{ $errorConexion }}</span>
        @endif
    </footer>
</body>
</html>
