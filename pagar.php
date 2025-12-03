<?php
// Una vez que se confirmó la compra, esta pagina simualará el proceso de pago mostrando un mensaje de confirmación al usuario y eliminando la variable de sesión de la cesta de compra
// Luego se mostrará un enlace para comenzar de nuevo el proceso de compra volviendo a la página del listado de productos

// Nos aseguramos de que el usuario tenga la sesión iniciada
session_start();
if (!isset($_SESSION['username'])) {
    // Si no tiene la sesión iniciada, redirigimos al login
    header('Location: login.php');
    exit;
}

// ---- LOGICA PRINCIPAL ----
// Vaciamos la cesta de compra al confirmar el pago
unset($_SESSION['cesta']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesta de compra - Por Diego Chuchon</title>
    <link rel="stylesheet" href="CSS/tienda.css">
</head>
<body>
    <div class="contenedor-principal">
        <div class="contenedor-confirmacion">
            <h1>Pago confirmado</h1>
            <div class="mensaje mensaje-exito">
                <p>Gracias por su compra. Su pago ha sido procesado correctamente.</p>
            </div>
            <a href="productos.php" class="enlace-volver">Volver al listado de productos</a>
        </div>
    </div>
</body>
</html>