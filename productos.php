<?php
/*
Presenta un listado de los productos de la tienda disponibles y permite al usuario seleccionar aquellos que se va a comprar
El listado debe presentar el nombre del producto y luego el boton añadir a la cesta
El listado con el boton se muestra en una lista. A la derecha de este div se muestra otro div que es la cesta de la compra
Es la pagina siguiente en el flujo tras la autenticacion del usuario
*/

// Nos aseguramos de que el usuario venga de login.php y tenga la sesión iniciada
session_start();
if (!isset($_SESSION['username'])) {
    // Si no tiene la sesión iniciada, redirigimos al login
    header('Location: login.php');
    exit;
}

// ---- VARIABLES ----
// Cesta en sesión. Procuramos usar isset para inicializarla solo una vez y no sobreescribirla en cada carga de la página
if (!isset($_SESSION['cesta'])) {
    $_SESSION['cesta'] = [];
}


// ---- LOGICA PRINCIPAL ----
// Comprobamos si se ha enviado un producto para añadir a la cesta cada vez que se recarga la página
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Comprobamos si se ha enviado el formulario para vaciar la cesta
    if (isset($_POST['vaciar_cesta'])) {
        vaciarCesta();
    } 
    // Comprobamos si se ha enviado un producto para añadir a la cesta
    elseif (isset($_POST['cod_producto'], $_POST['nombre_producto'], $_POST['precio_producto'])) {
        $codProducto = $_POST['cod_producto'];
        $nombreProducto = $_POST['nombre_producto'];
        $precioProducto = $_POST['precio_producto'];

        añadirProductoACesta($codProducto, $nombreProducto, $precioProducto);
    }
}


// ---- FUNCIONES ----
// funcion para generar la tabla con el listado de productos desde la base de datos y el boton de añadir a la cesta
function mostrarListadoProductos() {
    // Incluimos el archivo de conexión a la base de datos
    require_once 'conexionBBDD.php';
    $conexion = getConexion();

    // Si la conexión es exitosa, obtenemos los productos
    if ($conexion) {
        try {
            // Preparamos y ejecutamos la consulta para obtener los codigos, nombre y precio de los productos
            $stmt = $conexion->prepare('SELECT cod, nombre_corto, PVP FROM producto');
            $stmt->execute();

            // Obtenemos todos los productos con fetchAll
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Iniciamos la lista HTML
            echo '<table>';
            echo '<tr><th>Codigo</th><th>Producto</th><th>Precio</th><th>Acción</th></tr>';

            // Mostramos los productos en una tabla. Y cada producto es un formulario con boton para añadir a la cesta
            foreach ($productos as $producto) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($producto['cod']) . '</td>';
                echo '<td>' . htmlspecialchars($producto['nombre_corto']) . '</td>';
                echo '<td>' . number_format($producto['PVP'], 2) . ' €</td>';
                echo '<td>';
                // Formulario para añadir el producto a la cesta y recargar la página
                echo '<form method="post" action="productos.php">';
                echo '<input type="hidden" name="cod_producto" value="' . htmlspecialchars($producto['cod']) . '">';
                echo '<input type="hidden" name="nombre_producto" value="' . htmlspecialchars($producto['nombre_corto']) . '">';
                echo '<input type="hidden" name="precio_producto" value="' . htmlspecialchars($producto['PVP']) . '">';
                echo '<input type="submit" value="Añadir" class="boton boton-pequeno">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } catch (PDOException $e) {
            echo '<p style="color:red;">Error al obtener los productos.</p>';
        } finally {
            // Cerramos la conexión
            closeConexion($conexion);
        }
    } else {
        echo '<p style="color:red;">No se pudo conectar a la base de datos.</p>';
    }
}

function mostrarCestaCompra() {
    // Declaramos el total a pagar
    $total = 0;

    echo '<div class="resumen-cesta">';
    
    // Si la cesta está vacía, mostramos el mensaje de que está vacía
    if (empty($_SESSION['cesta'])) {
        echo '<p>La cesta está vacía.</p>';
    } else {
        echo '<ul>';
        foreach ($_SESSION['cesta'] as $producto) {
            echo '<li>' . htmlspecialchars($producto['cod']) . ' - ' . htmlspecialchars($producto['nombre']) . '</li>';
            // Calculamos el total a pagar
            $total += $producto['precio'];
        }
        echo '</ul>';
        
        echo '<p class="total-cesta"><strong>Total: ' . number_format($total, 2) . ' €</strong></p>';

        echo '<div class="acciones-cesta">';
        // Mostramos formulario para finalizar la compra si hay productos en la cesta
        echo '<form method="post" action="cesta.php">';
        echo '<button type="submit" class="boton boton-pago">';
        echo '<img src="Recursos/pago.png" alt="Pagar" class="icono-boton">';
        echo 'Finalizar compra';
        echo '</button>';
        echo '</form>';
        
        // Mostramos formulario para vaciar la cesta si hay productos en la cesta
        echo '<form method="post" action="productos.php">';
        echo '<input type="hidden" name="vaciar_cesta" value="1">';
        echo '<input type="submit" value="Vaciar cesta" class="boton boton-secundario">';
        echo '</form>';
        echo '</div>';
    }
    
    echo '</div>';
}


function añadirProductoACesta($codProducto, $nombreProducto, $precioProducto) {
    // Añadimos el codigo, nombre y precio del producto a la cesta en sesión
    $codProducto = $_POST['cod_producto'];
    $nombreProducto = $_POST['nombre_producto'];
    $precioProducto = $_POST['precio_producto'];

    // Añadimos el producto a la cesta. El producto es un array asociativo con cod, nombre y precio
    $_SESSION['cesta'][] = [
        'cod' => $codProducto,
        'nombre' => $nombreProducto,
        'precio' => $precioProducto
    ];
}

function vaciarCesta() {
    // Vaciamos la cesta en sesión
    $_SESSION['cesta'] = [];
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
        <h1>Listado de productos</h1>
        
        <div class="contenedor-productos">
            <div class="seccion-tarjeta">
                <div class="encabezado-seccion">
                    <img src="Recursos/listado.png" alt="Listado" class="icono-seccion">
                    <h2>Productos disponibles</h2>
                </div>
                <?php
                // Mostramos el listado de productos
                mostrarListadoProductos();
                ?>
            </div>

            <div class="seccion-tarjeta">
                <div class="encabezado-seccion">
                    <img src="Recursos/cesta.png" alt="Cesta" class="icono-seccion">
                    <h2>Mi cesta</h2>
                </div>
                <?php
                // Mostramos la cesta de la compra
                mostrarCestaCompra();
                ?>
            </div>
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