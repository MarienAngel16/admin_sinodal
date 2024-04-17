<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca Docentes</title>

    <?php 
   //------ESTILO GENERAL------
    //Redirige el diseño a todas las páginas y desabilita la necesaria
    $pagina_actual = "docentes";
    include_once "menu.html"; 
    ?>

    <!-- Archivo JavaScript para las funciones -->
    <script src="assets/main.js"></script>

</head>

<body>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    
  <div class="container mt-4">
    <form action="busca_docentes.php" method="GET">
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="busqueda" placeholder="Buscar docente">
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
        $sql = "SELECT * FROM docentes WHERE nombre_doc LIKE '%$busqueda%' OR num_trabajador LIKE '%$busqueda%'";

        // Ejecutar la consulta
        $resultado = $conexion->query($sql);

        // Mostrar los resultados en una tabla
        if ($resultado->num_rows > 0) {

             
        echo '</script>';

            echo '<div class="table-responsive">';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Número de Trabajador</th>';
            echo '<th>Nombre</th>';
            echo '<th>Cargos</th>';
            echo '<th>Fecha de Ingreso</th>';
            /* echo '<th>Antiguedad</th>'; */
            echo '<th>RFC</th>';
            echo '<th>Título</th>';
            echo '<th>Especialidad</th>';
            echo '<th>Teléfono</th>';
            echo '<th>Correo</th>';
            echo '<th>Sección</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($fila = $resultado->fetch_assoc()) {
              // Obtención de antigüedad en PHP
/*                  $fecha_ingreso = $fila['fecha_ingreso'];
                 $antiguedad = antiguedad($fecha_ingreso); */

                echo '<tr>';
                echo '<form action="busca_docentes.php" method="POST">';
                echo '<td><input type="int" name="num_trabajador" value="' . $fila['num_trabajador'] . '" readonly></td>';
                echo '<td><input type="text" name="nombre_doc" value="' . $fila['nombre_doc'] . '"></td>';
                echo '<td><input type="text" name="total_cargos" value="' . $fila['total_cargos'] . '" readonly></td>';
                echo '<td><input type="date" name="fecha_ingreso" value="' . $fila['fecha_ingreso'] . '"></td>';
                /* echo '<td><input type="date" name="antiguedad" value="' . $antiguedad . '" readonly></td>';            */   
                echo '<td><input type="text" name="rfc" value="' . $fila['rfc'] . '"></td>';
                echo '<td><input type="text" name="titulo" value="' . $fila['titulo'] . '"></td>';
                echo '<td><input type="text" name="especialidad" value="' . $fila['especialidad'] . '"></td>';
                echo '<td><input type="tel" name="celular_doc" value="' . $fila['celular_doc'] . '"></td>';             
                echo '<td><input type="email" name="mail_doc" value="' . $fila['mail_doc'] . '"></td>';
                echo '<td><input type="text" name="seccion" value="' . $fila['seccion'] . '"></td>';
                echo '<td>            
                    <button type="submit">Editar</button></td>
                </form>
              ';
        echo '<td>
                <form action="busca_docentes.php" method="POST">
                    <input type="hidden" name="delete" value="' . $fila['num_trabajador'] . '">
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
                if(isset($_POST["num_trabajador"])) {
                    // Obtener los valores de los campos
                    $nombre_doc = $_POST["nombre_doc"];
                    $fecha_ingreso = $_POST["fecha_ingreso"];
                    $rfc = $_POST["rfc"];
                    $titulo = $_POST["titulo"];
                    $especialidad = $_POST["especialidad"];
                    $celular_doc = $_POST["celular_doc"];
                    $mail_doc = $_POST["mail_doc"];
                    $seccion = $_POST["seccion"];
                    $num_trabajador = $_POST["num_trabajador"];     
                    $total_cargos = $_POST["total_cargos"];
                    $fecha_ingreso = $_POST ["fecha_ingreso"];
             
                    // Inicializar en 0 el total de cargos si es nullo 

                  if (is_null($total_cargos)) {
                  $total_cargos = 0;
                                              }


      
                  // Conexión a la base de datos
                  include_once "base.php";
      
                  // Verificar la conexión
                  if ($conexion->connect_error) {
                      die("Error en la conexión: " . $conexion->connect_error);
                  }
      
                  // Preparar la sentencia con consulta preparada
                  $stmt = $conexion->prepare("CALL editeacher(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                  $stmt->bind_param("sssssssss", $num_trabajador, $nombre_doc, $fecha_ingreso, $rfc, $titulo, $especialidad, $celular_doc, $mail_doc, $seccion);
   
                  // Ejecutar la sentencia
                         // Ejecutar la sentencia
                   if ($stmt->execute()) {
                   echo '<script>alert("Modificación de datos del docente exitoso.");</script>';
                   } else {
                   echo '<script>alert("Error al modificar datos del docente: ' . $conexion->error . '");</script>';
                          }
                  
                      // Cerrar la conexión
                      $conexion->close(); 
                 }

    
      //Procesamiento de Borrado 
      if (isset($_POST['delete'])){

                  // Obtener los datos del formulario             
                  $num_trabajador= $_POST['delete']; 

                  // Conexión a la base de datos
                  include_once "base.php";

                  // Verificar la conexión
                  if ($conexion->connect_error) {
                    die("Error en la conexión: " . $conexion->connect_error);
                }
    
                // Preparar la sentencia con consulta preparada
                $stmt = $conexion->prepare("CALL deleteacher(?)");
                $stmt->bind_param("s", $num_trabajador);
    
                // Ejecutar la sentencia
                       // Ejecutar la sentencia
                 if ($stmt->execute()) {
                 echo '<script>alert("Eliminación de registro del docente exitoso.");</script>';
                 } else {
                 echo '<script>alert("Error al eliminar registro del docente: ' . $conexion->error . '");</script>';
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

