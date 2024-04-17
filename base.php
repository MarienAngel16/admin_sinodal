<?php
// Datos de conexión a la base de datos
$servername = "bbvot6alytrdguwuimiy-mysql.services.clever-cloud.com"; // Nombre del servidor
$username = "ulkezsqz8wffl1nx"; // Nombre de usuario de la base de datos
$password = "Q1JQvw5DT0C5P69D3VJI"; // Contraseña de la base de datos
$dbname = "bbvot6alytrdguwuimiy"; // Nombre de la base de datos

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
  }  


// Cerrar conexión
/* $conn->close();
?>
 */