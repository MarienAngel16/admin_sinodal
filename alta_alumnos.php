
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
    

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div style="margin:20px;" class="card bg-dark text-light">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Registro de Alumnos</h2>
                    <form action="alta_alumnos.php" method="POST">

                        <div class="form-group">
                            <label for="num_cuenta" class="form-label">Número de Cuenta:</label>
                            <input type="number" id="num_cuenta" name="num_cuenta" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="carrera" class="form-label">Carrera:</label>
                            <input type="text" id="carrera" name="carrera" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="opcion_titulacion" class="form-label">Opción de Titulación:</label>
                            <input type="text" id="opcion_titulacion" name="opcion_titulacion" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="correo" class="form-label">Correo Electrónico:</label>
                            <input type="email" id="correo" name="correo" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="celular" class="form-label">Número de Celular:</label>
                            <input type="tel" id="celular" name="celular" class="form-control" required>
                        </div>
                        
                        <input type="submit" value="Registrar Alumno" class="btn btn-primary btn-block">
                    </form>
                </div> <!-- Cierre de div class="card-body" -->
            </div> <!-- Cierre de div class="card" -->
        </div> <!-- Cierre de div class="col-md-6" -->
    </div> <!-- Cierre de div class="row justify-content-center" -->
</div> <!-- Cierre de div class="container" -->


    
<?php

        // Procesamiento del formulario
        if(isset($_POST["num_cuenta"])) {
            $nombre = $_POST['nombre'];
            $carrera = $_POST['carrera'];
            $opcion_titulacion = $_POST['opcion_titulacion'];
            $correo = $_POST['correo'];
            $celular = $_POST['celular'];

            // Obtener los datos del formulario
            // Aquí deberías hacer la validación y limpieza de los datos
            $num_cuenta = $_POST['num_cuenta'];
            // Otros campos

            // Conexión a la base de datos
            include_once "base.php";

            // Verificar la conexión
            if ($conexion->connect_error) {
                die("Error en la conexión: " . $conexion->connect_error);
            }

            // Preparar la sentencia con consulta preparada
            $stmt = $conexion->prepare("CALL uploadstudent(?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $num_cuenta, $nombre, $carrera, $opcion_titulacion, $correo, $celular);

           
            // Ejecutar la sentencia
try {
    $stmt->execute();
    echo '<script>alert("Registro de alumno exitoso.");</script>';
} catch (Exception $e) {
    // Verificar si la excepción es por violación de clave primaria
    if ($conexion->errno == 1062) { // Código de error 1062 es para violación de clave primaria
        echo '<script>alert("Error al registrar alumno: La clave primaria ya existe.");</script>';
    } else {
        echo '<script>alert("Error al registrar alumno: Ha ocurrido un error.");</script>';
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