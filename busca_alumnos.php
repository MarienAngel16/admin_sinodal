<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edita Docentes</title>

    <?php 
   //------ESTILO GENERAL------
    //Redirige el diseño a todas las páginas y desabilita la necesaria
    $pagina_actual = "docentes";
    include_once "menu.html"; 
    ?>

</head>

<body>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    
  <div class="container mt-4">
    <form action="busca_alumnos.php" method="GET">
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
    
    <?php


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
        $sql = "SELECT * FROM alumnos WHERE nombre LIKE '%$busqueda%' OR num_cuenta LIKE '%$busqueda%'";

        // Ejecutar la consulta
        $resultado = $conexion->query($sql);

        // Mostrar los resultados en una tabla
        if ($resultado->num_rows > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Número de Cuenta</th>';
            echo '<th>Nombre</th>';
            echo '<th>Carrera</th>';
            echo '<th>Opción de Titulación</th>';
            echo '<th>Correo</th>';
            echo '<th>Celular</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($fila = $resultado->fetch_assoc()) {
                echo '<tr>';
                echo '<form action="busca_alumnos.php" method="POST">';
                echo '<td><input type="text" name="clave" value="' . $fila['num_cuenta'] . '" readonly></td>';
                echo '<td><input type="text" name="nombre" value="' . $fila['nombre'] . '"></td>';
                echo '<td><input type="text" name="opcion_titulacion" value="' . $fila['opcion_titulacion'] . '"></td>';
                echo '<td><input type="email" name="correo" value="' . $fila['correo'] . '"></td>';
                echo '<td><input type="tel" name="celular" value="' . $fila['celular'] . '"></td>';
                echo '<td><input type="text" name="carrera" value="' . $fila['carrera'] . '"></td>';               
                echo '<td>            
                    <button type="submit">Editar</button></td>
                </form>
              ';
        echo '<td>
                <form action="busca_alumnos.php" method="POST">
                    <input type="hidden" name="delete" value="' . $fila['num_cuenta'] . '">
                    <button type="submit">Borrar</button>
                </form>
              </td>';
           
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p>No se encontraron resultados.</p>';
        }

 
    }
    // Cerrar la conexión
    $conexion->close();  
    }

    // Procesamiento de editar
                if(isset($_POST["clave"])) {
                  $nombre = $_POST['nombre'];
                  $carrera = $_POST['carrera'];
                  $opcion_titulacion = $_POST['opcion_titulacion'];
                  $correo = $_POST['correo'];
                  $celular = $_POST['celular'];
      
                  // Obtener los datos del formulario             
                  $num_cuenta = $_POST['clave'];              
      
                  // Conexión a la base de datos
                  include_once "base.php";
      
                  // Verificar la conexión
                  if ($conexion->connect_error) {
                      die("Error en la conexión: " . $conexion->connect_error);
                  }
      
                  // Preparar la sentencia con consulta preparada
                  $stmt = $conexion->prepare("CALL editstudent(?, ?, ?, ?, ?, ?)");
                  $stmt->bind_param("ssssss", $num_cuenta, $nombre, $carrera, $opcion_titulacion, $correo, $celular);
      
                  // Ejecutar la sentencia
                         // Ejecutar la sentencia
                   if ($stmt->execute()) {
                   echo '<script>alert("Modificación de datos del alumno exitoso.");</script>';
                   } else {
                   echo '<script>alert("Error al modificar datos del alumno: ' . $conexion->error . '");</script>';
                          }
                  
                      // Cerrar la conexión
                      $conexion->close(); 
                 }

    
      //Procesamiento de Borrado 
      if (isset($_POST['delete'])){

                  // Obtener los datos del formulario             
                  $num_cuenta = $_POST['delete']; 

                  // Conexión a la base de datos
                  include_once "base.php";

                  // Verificar la conexión
                  if ($conexion->connect_error) {
                    die("Error en la conexión: " . $conexion->connect_error);
                }
    
                // Preparar la sentencia con consulta preparada
                $stmt = $conexion->prepare("CALL deletestudent(?)");
                $stmt->bind_param("s", $num_cuenta);
    
                // Ejecutar la sentencia
                       // Ejecutar la sentencia
                 if ($stmt->execute()) {
                 echo '<script>alert("Eliminación de registro del alumno exitoso.");</script>';
                 } else {
                 echo '<script>alert("Error al eliminar registro del alumno: ' . $conexion->error . '");</script>';
                        }
                
                    // Cerrar la conexión
                    $conexion->close(); 
      }
       
    
    
    ?>

   

    </div>

  <!-- Bootstrap Cerrado -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

