
<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'proyecto_semi');

// Crear conexión
function conectarDB() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Verificar conexión
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }
        
        // Establecer charset UTF-8
        $conn->set_charset("utf8mb4");
        
        return $conn;
    } catch (Exception $e) {
        die("Error al conectar con la base de datos: " . $e->getMessage());
    }
}

// Iniciar sesión de forma segura
function iniciarSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Verificar si el usuario está logueado
function verificarLogin() {
    iniciarSesion();
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Verificar rol del usuario
function verificarRol($roles_permitidos = []) {
    iniciarSesion();
    if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
        header("Location: dashboard.php");
        exit();
    }
}
?>