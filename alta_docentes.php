
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Docentes</title>

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
    

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div style="margin:20px;" class="card bg-dark text-light">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Registro de Docentes</h2>
                    <form action="alta_docentes.php" method="POST">

                        <div class="form-group">
                            <label for="num_trabajador" class="form-label">Número de Trabajador:</label>
                            <input type="number" id="num_trabajador" name="num_trabajador" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="nombre_doc" class="form-label">Nombre del Docente:</label>
                            <input type="text" id="nombre_doc" name="nombre_doc" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
                            <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" required>
                        </div>                      

                        <div class="form-group">
                            <label for="rfc" class="form-label">RFC:</label>
                            <input type="text" id="rfc" name="rfc" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="titulo" class="form-label">Título:</label>
                            <input type="text" id="titulo" name="titulo" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="especialidad" class="form-label">Especialidad:</label>
                            <input type="text" id="especialidad" name="especialidad" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="celular_doc" class="form-label">Número de Celular:</label>
                            <input type="text" id="celular_doc" name="celular_doc" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="mail_doc" class="form-label">Correo Electrónico:</label>
                            <input type="text" id="mail_doc" name="mail_doc" class="mail_doc" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="Docente_Especialidad" class="form-label">Sección:</label>
                            <input type="text" id="seccion" name="seccion" class="seccion" required>
                        </div>                        

                        
                        <input type="submit" value="Registrar Docente" class="btn btn-primary btn-block">
                    </form>
                </div> <!-- Cierre de div class="card-body" -->
            </div> <!-- Cierre de div class="card" -->
        </div> <!-- Cierre de div class="col-md-6" -->
    </div> <!-- Cierre de div class="row justify-content-center" -->
</div> <!-- Cierre de div class="container" -->


    
<?php

        // Procesamiento del formulario
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
    
                       
            // Conexión a la base de datos
            include_once "base.php";

            // Verificar la conexión
            if ($conexion->connect_error) {
                die("Error en la conexión: " . $conexion->connect_error);
            }

            // Preparar la sentencia con consulta preparada
             $stmt = $conexion->prepare("CALL uploadteacher(?, ?, ?, ?, ?, ?, ?, ?,?)");
             $stmt->bind_param("sssssssss", $num_trabajador, $nombre_doc, $fecha_ingreso, $rfc, $titulo, $especialidad, $celular_doc, $mail_doc, $seccion);

                         // Ejecutar la sentencia
try {
    $stmt->execute();
    echo '<script>alert("Registro de docente exitoso.");</script>';
} catch (Exception $e) {
    // Verificar si la excepción es por violación de clave primaria
    if ($conexion->errno == 1062) { // Código de error 1062 es para violación de clave primaria
        echo '<script>alert("Error al registrar docente: La clave primaria ya existe.");</script>';
    } else {
        echo '<script>alert("Error al registrar docente: Ha ocurrido un error.");</script>';
    }
}
    



            // Cerrar la conexión            
            $conexion->close();  }
    ?>

<!-- Bootstrap Cerrado -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>