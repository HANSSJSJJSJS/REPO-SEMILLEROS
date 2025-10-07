<?php
// Configuración del servidor de desarrollo
$host = 'localhost';
$port = 8000;
$root = __DIR__ . '/Front-end';

// Mensaje informativo
echo "Servidor de desarrollo iniciado en http://{$host}:{$port}" . PHP_EOL;
echo "Presiona Ctrl+C para detener el servidor" . PHP_EOL;

// Comando para iniciar el servidor
$command = sprintf(
    'php -S %s:%d -t %s',
    $host,
    $port,
    escapeshellarg($root)
);

// Ejecutar el servidor
system($command);