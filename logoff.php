<?php
// Desconecta al usuario de la aplicación y redirige a la página de login. No muestra información en pantalla

session_start();

// Destruimos la sesión para cerrar la sesión del usuario
session_destroy();

// Redirigimos a la página de login
header('Location: login.php');
exit;

?>