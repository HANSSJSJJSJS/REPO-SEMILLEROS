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
    <link rel="stylesheet" href="/Login.css">
</head>
<body>

    <form method="POST">
        <h2>Iniciar sesión</h2>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
        <div class="mensaje"><?= $mensaje ?></div>
        <div class="registro-link">
            ¿No tienes cuenta? <a href="registroapre.php">Regístrate aquí</a>
        </div>
    </form>

</body>
</html>
