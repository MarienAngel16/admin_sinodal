
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
    
<?php 
  if (isset($_GET["numero"]) && $_GET["numero"] == 1) { 
    
    echo' 
    
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div style="margin:20px;" class="card bg-dark text-light">
                <div class="card-body">


        <h2>Formulario de Trabajos</h2>
        <form action="crud_trabajos.php" method="POST">
            <div class="form-group">
                <label for="clave">Clave:</label>
                <input type="text" class="form-control" id="clave" name="clave" required>
            </div>
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="fecha_registro">Fecha de Registro:</label>
                <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" required>
            </div>
            <div class="form-group">
                <label for="encargado">Encargado:</label>
                <input type="text" class="form-control" id="encargado" name="encargado" required>
            </div>
            <div class="form-group">
                <label for="activo">Activo:</label>
                <select class="form-control" id="activo" name="activo" required>
                    <option value="S">Sí</option>
                    <option value="N">No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>


        </div> <!-- Cierre de div class="card-body" -->
        </div> <!-- Cierre de div class="card" -->
    </div> <!-- Cierre de div class="col-md-6" -->
</div> <!-- Cierre de div class="row justify-content-center" -->
</div> <!-- Cierre de div class="container" -->

      
    ';

} /* FIN DE FORMULARIO */

if (isset($_GET["numero"]) && $_GET["numero"] == 0) {

    echo '

    <div class="container mt-4">
    <form action="crud_trabajos.php" method="GET">
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="busqueda" placeholder="Buscar alumno">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
      </div>
    </form>
  </div>

  <div class="container">        
  <h2>Resultados de la Búsqueda</h2>
    
      
    ';
}

/* ----------------------PROCEDIMIENTOS---------------------- */

if(isset($_GET['busqueda'])) {
        
    // Obtener el término de búsqueda
    $busqueda = $_GET['busqueda'];

    // Conexión a la base de datos
    include_once "base.php";

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

if ($busqueda){
    // Consulta SQL para buscar al alumno por nombre o número de cuenta
    $sql = "SELECT * FROM trabajos WHERE titulo LIKE '%$busqueda%' OR clave LIKE '%$busqueda%'";

    // Ejecutar la consulta
    $resultado = $conexion->query($sql);

    // Mostrar los resultados en una tabla
    if ($resultado->num_rows > 0) {
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Folio</th>';
        echo '<th>Título</th>';
        echo '<th>Fecha del Registro</th>';
        echo '<th>Encargado</th>';
        echo '<th>Estado</th>';        
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ($fila = $resultado->fetch_assoc()) {
            echo '<tr>';
            echo '<form action="crud_trabajos.php" method="POST">';
            echo '<td><input type="text" name="folio" value="' . $fila['clave'] . '" readonly></td>';
            echo '<td><input type="text" name="titulo" value="' . $fila['titulo'] . '"></td>';
            echo '<td><input type="text" name="fecha_registro" value="' . $fila['fecha_registro'] . '"></td>';
            echo '<td><input type="text" name="encargado" value="' . $fila['encargado'] . '"></td>';
            echo '<td><input type="text" name="activo" value="' . $fila['activo'] . '">
            </td>';                       
            echo '<td>            
                <button type="submit">Editar</button></td>
            </form>
          ';
    echo '<td>
            <form action="crud_trabajos.php" method="POST">
                <input type="hidden" name="delete" value="' . $fila['clave'] . '">
                <button type="submit">Borrar</button>
            </form>
          </td>';
       
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<script>alert("No se encontraron resultados.");</script>';
    }


}
// Cerrar la conexión
$conexion->close();  
}

// Procesamiento del formulario
if(isset($_POST["clave"])) {
    // Obtener los datos del formulario
    // Aquí deberías hacer la validación y limpieza de los datos
    $clave = $_POST['clave'];
    $titulo = $_POST['titulo'];
    $fecha_registro = $_POST['fecha_registro'];
    $encargado = $_POST['encargado'];
    $activo = $_POST['activo'];

    // Conexión a la base de datos
    include_once "base.php";

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Preparar la sentencia con consulta preparada
    $stmt = $conexion->prepare("CALL uploadwork(?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $clave, $titulo, $fecha_registro, $encargado, $activo);

                // Ejecutar la sentencia
try {
    $stmt->execute();
    echo '<script>alert("Registro del trabajo exitoso.");</script>';
} catch (Exception $e) {
    // Verificar si la excepción es por violación de clave primaria
    if ($conexion->errno == 1062) { // Código de error 1062 es para violación de clave primaria
        echo '<script>alert("Error al registrar trabajo: El folio ya existe.");</script>';
    } else {
        echo '<script>alert("Error al registrar alumno: Ha ocurrido un error.");</script>';
    }
}

                // Cerrar la conexión            
                $conexion->close(); 

}
/* FIN DE GUARDADO */

// Procesamiento de editar
if(isset($_POST["folio"])) {
    $titulo = $_POST['titulo'];
    $fecha_registro = $_POST['fecha_registro'];    
    $encargado = $_POST['encargado'];
    $activo = $_POST['activo'];

    // Obtener los datos del formulario             
    $folio = $_POST['folio'];              

    // Conexión a la base de datos
    include_once "base.php";

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

        // Preparar la sentencia con consulta preparada
        $stmt = $conexion->prepare("CALL editworks(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $folio, $titulo, $fecha_registro, $encargado, $activo);

    // Ejecutar la sentencia
try {
    $stmt->execute();
    echo '<script>alert("Edición del trabajo exitoso.");</script>';
} catch (Exception $e) {
    // Verificar si la excepción es por violación de clave primaria
    if ($conexion->errno == 1062) { // Código de error 1062 es para violación de clave primaria
        echo '<script>alert("Error al editar trabajo: El folio ya existe.");</script>';
    } else {
        echo '<script>alert("Error al editar trabajo: Ha ocurrido un error.");</script>';
    }
}
}

// Procesamiento de borrar
if(isset($_POST["delete"])) {    

    // Obtener los datos del formulario             
    $clave = $_POST['delete'];              

    // Conexión a la base de datos
    include_once "base.php";

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

        // Preparar la sentencia con consulta preparada
        $stmt = $conexion->prepare("CALL deletework(?)");
        $stmt->bind_param("s", $clave);

    // Ejecutar la sentencia
try {
    $stmt->execute();
    echo '<script>alert("Borrado del trabajo exitoso.");</script>';
} catch (Exception $e) {
    // Verificar si la excepción es por violación de clave primaria
    if ($conexion->errno == 1062) { // Código de error 1062 es para violación de clave primaria
        echo '<script>alert("Error al borrar trabajo: El folio ya existe.");</script>';
    } else {
        echo '<script>alert("Error al borrar trabajo: Ha ocurrido un error.");</script>';
    }
}
}

?>




    


<!-- Bootstrap Cerrado -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>