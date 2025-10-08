<?php
require_once __DIR__ . '/../config/Conexion.php';
iniciarSesion();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$exito = '';

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $rol = $_POST['rol'] ?? 'APRENDIZ';
    
    // Validaciones
    if (empty($nombre) || empty($email) || empty($password) || empty($password_confirm)) {
        $error = "Por favor completa todos los campos";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no es válido";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres";
    } elseif ($password !== $password_confirm) {
        $error = "Las contraseñas no coinciden";
    } elseif (!in_array($rol, ['ADMIN', 'LIDER', 'APRENDIZ'])) {
        $error = "Rol no válido";
    } else {
        $conn = conectarDB();
        
        // Verificar si el email ya existe
        $stmt = $conn->prepare("SELECT usuario_id FROM Usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Este correo electrónico ya está registrado";
        } else {
            // Encriptar contraseña
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Insertar nuevo usuario
            $stmt = $conn->prepare("INSERT INTO Usuarios (nombre, email, contraseña, rol, activo) VALUES (?, ?, ?, ?, 1)");
            $stmt->bind_param("ssss", $nombre, $email, $password_hash, $rol);
            
            if ($stmt->execute()) {
                header("Location: login.php?registro=exitoso");
                exit();
            } else {
                $error = "Error al registrar usuario. Intenta nuevamente.";
            }
        }
        
        $stmt->close(); 
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login PHP</title>
    <link rel="stylesheet" href="registroapre.css">
</head>
<body>
    <div class="registro-container">
        <div class="logo">
            <h1>🎓 Proyecto Semilleros</h1>
            <p>Sistema de Gestión</p>
        </div>
        
        <h2>Crear Cuenta</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="rol-info">
            <h4>ℹ️ Roles disponibles:</h4>
            <ul>
                <li><strong>ADMIN:</strong> Control total del sistema</li>
                <li><strong>LÍDER:</strong> Gestiona semilleros y proyectos</li>
                <li><strong>APRENDIZ:</strong> Participa en proyectos</li>
            </ul>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required 
                       value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="rol">Rol</label>
                <select id="rol" name="rol" required>
                    <option value="APRENDIZ" <?php echo (isset($_POST['rol']) && $_POST['rol'] === 'APRENDIZ') ? 'selected' : ''; ?>>APRENDIZ</option>
                    <option value="LIDER" <?php echo (isset($_POST['rol']) && $_POST['rol'] === 'LIDER') ? 'selected' : ''; ?>>LÍDER</option>
                    <option value="ADMIN" <?php echo (isset($_POST['rol']) && $_POST['rol'] === 'ADMIN') ? 'selected' : ''; ?>>ADMIN</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Mínimo 6 caracteres">
            </div>
            
            <div class="form-group">
                <label for="password_confirm">Confirmar Contraseña</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>
            
            <button type="submit" class="btn">Registrarse</button>
        </form>
        
        <div class="login-link">
            ¿Ya tienes cuenta? <a href="index.php">Inicia sesión aquí</a>
        </div>
    </div>
</body>
</html>