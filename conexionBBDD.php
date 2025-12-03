<?php 

// Definimos los parámetros de conexión
define('DB_HOST', 'localhost');
define('DB_NAME', 'dwes');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Usuario@1');

function getConexion() {
    // TRY-CATCH para manejar errores de conexión
    try {
        // Cargamos la conexion a la BD con PDO
        return new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        return null;
    }
}

function closeConexion(&$conexion) {
    unset($conexion);
}
?>