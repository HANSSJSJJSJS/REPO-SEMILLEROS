<?php
// --- login sencillo sin base de datos ---
$usuario_valido = "admin";
$contrasena_valida = "12345";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    if ($usuario === $usuario_valido && $contrasena === $contrasena_valida) {
        $mensaje = "✅ Bienvenido, $usuario!";
    } else {
        $mensaje = "❌ Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .mensaje {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <form method="POST">
        <h2>Iniciar sesión</h2>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
        <div class="mensaje"><?= $mensaje ?></div>
    </form>

</body>
</html>
