<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajos</title>

    <?php 
   //------ESTILO GENERAL------
    //Redirige el diseño a todas las páginas y desabilita la necesaria
    $pagina_actual = "trabajos";
    include_once "menu.html"; 
    ?>

</head>


<body>
    
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div style="margin:20px;" class="card bg-dark text-light">
                <div class="card-body">

<?php
// Conexión a la base de datos
include_once 'base.php';



if (isset($_GET["clave"])) {   
    $titulo = $_GET ["titulo"];
    $fecha_registro = $_GET ["fecha_registro"];
    $activo = $_GET ["activo"];
    $clave = $_GET['clave'];

    echo '
    <h1 class="card-title text-center mb-4">Trabajo ' . $clave . ' </h1>
    <h2 class="card-title text-center mb-4">' . $titulo . '</h2>

';


    // Consulta SQL para obtener los detalles de los docentes asignados a este trabajo
    $query = "SELECT d.num_trabajador, d.categoria, dt.nombre_doc FROM detalle d
              INNER JOIN docentes dt ON d.num_trabajador = dt.num_trabajador
              WHERE d.clave_trabajo = ?";

    // Preparar la consulta
    $statement = $conexion->prepare($query);
    $statement->bind_param("s", $clave);

    // Ejecutar la consulta
    $statement->execute();

    // Obtener los resultados
    $result = $statement->get_result();

    // Verificar si hay docentes asignados
    if ($result->num_rows > 0) {
        // Mostrar los detalles de los docentes asignados en una lista
        echo "<h3>Docentes Asignados:</h3>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Número de Trabajador: " . $row['num_trabajador'] . "</li>";
            echo "<li>Nombre del Docente: " . $row['nombre_doc'] . "</li>";
            echo "<li>Cargo: " . $row['categoria'] . "</li>";
            echo "<br>";
        }
        echo "</ul>";
    } else {
        // Si no hay docentes asignados, mostrar un mensaje
        echo "<p>No hay docentes asignados a este trabajo.</p>";
    }

    // Cerrar la consulta y la conexión a la base de datos
    $statement->close();
    $conexion->close();
}
?>

<!-- Formulario para asignar un nuevo docente y su respectivo cargo -->
<form action="asignar.php" method="POST">
    <h3>Asignar Nuevo Docente:</h3>

    <div class="form-group">
    <label for="num_trabajador">Número de Trabajador:</label>
    <input type="text" name="num_trabajador" required>
    </div>

    <div class="form-group">
    <label for="categoria">Cargo:</label>
    <input type="text" name="categoria" required><br>
    </div>

    <input type="hidden" name="clave" value="<?php echo $clave; ?>">
    <input type="submit" class="btn btn-primary" value="Asignar Docente">
</form>



         </div> <!-- Cierre de div class="card-body" -->
        </div> <!-- Cierre de div class="card" -->
    </div> <!-- Cierre de div class="col-md-6" -->
</div> <!-- Cierre de div class="row justify-content-center" -->
</div> <!-- Cierre de div class="container" -->


<?php // Procesamiento del formulario
if(isset($_POST["num_trabajador"])) {
    // Obtener los datos del formulario
    // Aquí deberías hacer la validación y limpieza de los datos
    $clave = $_POST['clave'];
    $num_trabajador = $_POST['num_trabajador'];
    $categoria = $_POST['categoria'];


    // Conexión a la base de datos
    include_once "base.php";

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Preparar la sentencia con consulta preparada
    $stmt = $conexion->prepare("CALL asigdoc(?, ?, ?)");
    $stmt->bind_param("sss", $num_trabajador, $clave, $categoria);

                // Ejecutar la sentencia
try {
    $stmt->execute();
    echo '<script>alert("Asignación de Docente Exitosa.");</script>';
    

} catch (Exception $e) {
    // Verificar si la excepción es por violación de clave primaria
    if ($conexion->errno == 1062) { // Código de error 1062 es para violación de clave primaria
        echo '<script>alert("Error al registrar trabajo: Ese docente ya fue asignado.");</script>';
    } else {
        echo '<script>alert("Error asignar un docente al trabajo: Ha ocurrido un error.");</script>';
    }
}

                // Cerrar la conexión            
                $conexion->close(); 

} 
?>



<!-- Bootstrap Cerrado -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>