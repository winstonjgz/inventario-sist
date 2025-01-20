<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg,rgb(243, 205, 193), #f4f4f4);
            color: #2c3e50;
        }
        .main-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: #fff;
            max-width: 600px;
            width: 100%;
        }
        .error-icon {
            font-size: 8rem;
            margin-bottom: 20px;
            color: #ff7675;
        }
        h1 {
            font-size: 4rem;
            margin: 0;
            color: #e74c3c;
        }
        p {
            font-size: 1.2rem;
            margin: 10px 0;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background: #3498db;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="error-icon">🚫</div>
        <h1>Error 404</h1>
        <p>¡Oops! La página que buscas no existe.</p>
        <a href="index.php?vista=home">Volver a la página principal</a>
    </div>
</body>
</html>
