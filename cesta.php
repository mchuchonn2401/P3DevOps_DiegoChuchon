<?php
// Muestra un resumen de los productos escogidos en el listado de productos escogidos por el usuario y permite finalizar la compra
// Se muestra tras la selección de productos en la página de listado de productos


// Nos aseguramos de que el usuario tenga la sesión iniciada
session_start();
if (!isset($_SESSION['username'])) {
    // Si no tiene la sesión iniciada, redirigimos al login
    header('Location: login.php');
    exit;
}

// ---- VARIABLES ----
$cesta = $_SESSION['cesta'];

// ---- FUNCIONES ----
function mostrarResumenCesta($cesta) {
    // Variable con el total de la cesta
    $total = 0;

    // Verificamos si la cesta está vacía
    if (empty($cesta)) {
        echo '<div class="mensaje mensaje-error">La cesta de compra está vacía.</div>';
        return;
    }

    // Mostramos la tabla con los productos en la cesta
    echo '<table>';
    echo '<tr><th>Código</th><th>Nombre</th><th>Precio</th></tr>';

    foreach ($cesta as $producto) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($producto['cod']) . '</td>';
        echo '<td>' . htmlspecialchars($producto['nombre']) . '</td>';
        echo '<td>' . number_format($producto['precio'], 2) . ' €</td>';
        echo '</tr>';
    }

    // Calculamos el total de la cesta
    foreach ($cesta as $producto) {
        $total += $producto['precio'];
    }

    // Mostramos el total en la tabla seguido del boton de pagar
    // Estilos embebidos por generarlos dinámicamente. No es la mejor práctica...
    echo '<tr style="background-color: var(--color-fondo);"><td colspan="2" style="text-align: right; padding: 12px;"><strong>Total</strong></td><td><strong>' . number_format($total, 2) . ' €</strong></td></tr>';
    echo '<tr><td colspan="3" style="text-align: center; padding: 20px;">';
    echo '<form action="pagar.php" method="post">';
    echo '<div style="display: flex; justify-content: center;">';
    echo '<button type="submit" class="boton boton-pago">';
    echo '<img src="Recursos/pago.png" alt="Pagar" class="icono-boton">';
    echo 'Confirmar pago';
    echo '</button>';
    echo '</div>';
    echo '</form>';
    echo '</td></tr>';

    echo '</table>';
}


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
        <h1>Resumen de la cesta de compra</h1>

        <div class="seccion-tarjeta" style="max-width: 800px; margin: 0 auto;">
            <?php
            // Mostramos el resumen de la cesta de compra
            mostrarResumenCesta($cesta);
            ?>
        </div>

        <div class="pie-pagina">
            <form action="logoff.php" method="post">
                <button type="submit" class="boton-logoff">
                    <img src="Recursos/logoff.png" alt="Cerrar sesión" class="icono-logoff">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</body>
</html>