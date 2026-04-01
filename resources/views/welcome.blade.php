<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background-color: #ffffff;
            font-family: Arial, sans-serif;
        }

        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 2rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
        }

        h1 {
            margin: 0 0 1rem;
            color: #ff0000;
            font-size: 2rem;
        }

        p {
            margin: 0;
            color: #111827;
            font-size: 1.1rem;
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
