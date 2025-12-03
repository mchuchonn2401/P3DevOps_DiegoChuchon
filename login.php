<?php
/*
Pagina que autentifica al usuario del aplicativo antes de poder acceder a las funcionalidades del resto de páginas
*/

// ---- VARIABLES ----
// Manejo de errores
// Inicialmente iba a considerar un array de errores, pero si se trata de credenciales es mejor práctica no dar pistas al usuario
$mensajeError = '';


// ---- LOGICA PRINCIPAL ----
// Comprobamos que se ha enviado el formulario para luego validar las credenciales y redirigir al usuario a la página de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asignamos los valores recibidos del formulario
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Llamamos a la función de autenticación
    $autenticado = isAuthenticated($username, $password);
    
    // Si la autenticación es exitosa, iniciamos sesión y redirigimos
    if ($autenticado) {
        session_start();
        $_SESSION['username'] = $username;
        header('Location: productos.php');
        exit;
    } else {
        $mensajeError = 'Usuario o contraseña incorrectos.';
    }
}


// ---- FUNCIONES ----
// Funcion para comprobar la autenticación del usuario. Devuelve true si el usuario está autenticado, false en caso contrario
function isAuthenticated($username, $password) {
    // Incluimos el archivo de conexión a la base de datos
    require_once 'conexionBBDD.php';
    $conexion = getConexion();

    // Si la conexión es exitosa, comprobamos las credenciales
    if ($conexion) {
        try {
            // Convertimos la contraseña en md5 para comparar con la almacenada en la base de datos
            $passwordMD5 = md5($password);

            // Preparamos y ejecutamos la consulta para verificar las credenciales
            $stmt = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?');
            $stmt->execute([$username, $passwordMD5]);

            // Asignamos el resultado de la consulta
            $resultado = $stmt->fetch();

            // Si se encuentra al usuario con su contraseña en md5, la autenticación es exitosa y devolvemos true
            if ($resultado) {
                return true;
            } else {
                // Si no se encuentra, devolvemos false
                return false;
            }
        } catch (PDOException $e) {
            // Si no se puede ejecutar la consulta, devolvemos false
            return false;
        }
    } else {
        // En caso de no poder conectar a la base de datos, devolvemos false
        return false;
    }
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
        <h1>Login de usuario</h1>
        
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="post" class="form-login">
            <div class="campo-formulario">
                <label for="username">Usuario:</label>
                <div class="campo-icono">
                    <img src="Recursos/user.png" alt="Usuario" class="icono-input">
                    <input type="text" id="username" name="username" required>
                </div>
            </div>
            
            <div class="campo-formulario">
                <label for="password">Contraseña:</label>
                <div class="campo-icono">
                    <img src="Recursos/password.png" alt="Contraseña" class="icono-input">
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            
            <input type="submit" value="Iniciar sesión" class="boton">
        </form>

        <?php
        // Muestro el mensaje de error genérico si la autenticación ha fallado
        if ($mensajeError !== '') {
            echo "<div class=\"mensaje mensaje-error\">$mensajeError</div>";
        }
        ?>
    </div>
</body>
</html>