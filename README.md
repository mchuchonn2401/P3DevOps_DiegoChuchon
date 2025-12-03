# Cesta de Compra

Aplicación web de práctica desarrollada en PHP con MySQL para la gestión de productos y carrito de compras para DevOps.

## Autor

Diego Chuchon

## Descripción

Sistema de tienda online que permite a los usuarios autenticarse, navegar por un catálogo de productos, añadir artículos a su cesta de compra y realizar el proceso de pago simulado.

## Funcionalidades

### Autenticación
- Sistema de login con usuario y contraseña
- Validación de credenciales contra base de datos
- Gestión de sesiones PHP
- Cierre de sesión (logout)

### Gestión de Productos
- Listado completo de productos disponibles
- Visualización de código, nombre y precio de cada producto
- Función para añadir productos a la cesta de compra

### Cesta de Compra
- Visualización en tiempo real de productos añadidos
- Cálculo automático del total a pagar
- Opción para vaciar la cesta completa
- Resumen detallado antes del pago
- Proceso de finalización de compra

### Interfaz
- Diseño con CSS
- Iconos visuales (Google Fonts )para mejorar la experiencia de usuario
- Elementos centrados con botones y tablas redondeadas
- Efectos hover en elementos interactivos
- Paleta de colores definida mediante variables CSS

## Tecnologías Utilizadas

- **Backend**: PHP
- **Base de datos**: MySQL
- **Frontend**: HTML5, CSS3
- **Servidor**: Laragon (Apache + MySQL)

## Requisitos para despliegue en pruebas

- Laragon (Con PHP y algún SGBD con MySQL)
- Navegador web (Chrome o Firefox)

## Instalación y Despliegue

### 1. Configurar Laragon

1. Descargar e instalar [Laragon](https://laragon.org/download/)
2. Iniciar Laragon y asegurarse de que Apache y MySQL están activos

### 2. Clonar o copiar el proyecto

Copiar el repositorio en el directorio de Laragon:
```
C:\laragon\www\P3DevOps_DiegoChuchon
```

### 3. Configurar la Base de Datos

1. Descargar el archivo `BDdwes.sql`.
2. Ejecutar el script desde un SGBD.

### 4. Configurar las credenciales de conexión

Editar el archivo `conexionBBDD.php` y modificar las siguientes constantes según tu configuración:

```php
define('DB_USER', 'root');        // Cambiar por tu usuario de MySQL
define('DB_PASSWORD', 'Usuario@1'); // Cambiar por tu contraseña de MySQL
```

### 5. Acceder a la aplicación

Abrir el navegador y acceder con el usuario `cesta` y contraseña `compra`.
```
http://localhost/P3DevOps_DiegoChuchon
```

## Estructura del Proyecto

```
cesta-de-compra/
├── CSS/
│   └── tienda.css          # Estilos de la aplicación
├── Recursos/
│   ├── cesta.png           # Icono de cesta
│   ├── listado.png         # Icono de listado
│   ├── logoff.png          # Icono de cerrar sesión
│   ├── pago.png            # Icono de pago
│   ├── password.png        # Icono de contraseña
│   └── user.png            # Icono de usuario
├── index.php               # Página inicio que redirige a login
├── login.php               # Página de autenticación
├── productos.php           # Listado de productos y cesta
├── cesta.php               # Resumen de la cesta
├── pagar.php               # Confirmación de pago
├── logoff.php              # Cierre de sesión
├── conexionBBDD.php        # Configuración de base de datos
└── README.md               # Documentación
```

## Uso de la Aplicación

0. **Index**: Redirecciona a Login. Unicamente por conveniencia al desplegar
1. **Login**: Ingresar con las credenciales de un usuario registrado en la base de datos
2. **Navegar productos**: Revisar el catálogo de productos disponibles
3. **Añadir a la cesta**: Hacer clic en "Añadir" para incluir productos en la cesta
4. **Ver cesta**: La cesta se actualiza automáticamente mostrando el total
5. **Finalizar compra**: Hacer clic en "Finalizar compra" para ver el resumen
6. **Confirmar pago**: Revisar el resumen y confirmar el pago
7. **Cerrar sesión**: Usar el botón "Cerrar sesión" para salir

## Consideraciones y Limitaciones

- No se desarrolla página real de procesamiento de pago (solo simulación)
- No se permite comprar múltiples unidades del mismo producto de acuerdo con el enunciado del ejercicio
- Los productos añadidos no pueden retirarse individualmente, solo se puede vaciar toda la cesta
- El total de la compra se muestra en tiempo real durante la selección
- Todos los productos se muestran en una única página sin paginación ni filtros por categoría
- Las contraseñas se almacenan con hash MD5 (considerar usar algoritmos más seguros como bcrypt en producción)
- No se almacena en la BD la compra del usuario, solo en una variable de sesión
