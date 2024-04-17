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
    include_once "../estilos.php"; 
    ?>

</head>
<body>
    
<!--   CONEXIÓN CON LA BASE DE DATOS -->
<?php
$conexion = mysqli_connect("bnezzz1j7fm1kcnkzkpf-mysql.services.clever-cloud.com", "u0k9oqrrgijpodzx", "LbrhZXSBSGg0uG6e6Tf7", "bnezzz1j7fm1kcnkzkpf", 3306) or die("Error al conectar a la base de datos: " . mysqli_connect_error());
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
} 
?>
<?php

if (isset($_GET['Docente_id'])) {
    $docenteID = mysqli_real_escape_string($conexion, $_GET['Docente_id']);

    $busca = mysqli_query($conexion, "SELECT * FROM DOCENTES WHERE Docente_id='$docenteID'");

    $fila = mysqli_fetch_assoc($busca); // Obtener una fila de resultados como un arreglo asociativo

    // Asignar los valores a las variables
    $b1 = $fila['Docente_APaterno'];
    $b2 = $fila['Docente_AMaterno'];
    $b3 = $fila['Docente_nombres'];
    $b4 = $fila['Docente_Fingreso'];
    $b5 = $fila['Docente_RFC'];
    $b6 = $fila['Docente_Titulo'];
    $b7 = $fila['Docente_Especialidad'];
    $b8 = $fila['Docente_seccion'];
    $b9 = $fila['Docente_correo'];
    $b10 = $fila['Docente_tel'];
    $b11= $fila['Docente_total'];


    echo '
    <!-- TARJETA PARA CONSULTAR DOCENTES -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div style="margin:20px;" class="card">
                    <div class="card-body">
                        <form  action="editar_docentes.php" method="GET">
                            <h5 class="card-title text-center">Edición de Docentes "' . $docenteID . '"</h5>

                            <label for="nom" class="form-label">Nombre del docente:</label>
                            <input type="text" name="nombre" id="nom" class="form-control" required="required" value="' . $b3 . '"/>

                            <label for="ap" class="form-label">Apellido Paterno:</label>
                            <input type="text" name="paterno" id="ap" class="form-control" required="required" value="' . $b1 . '"/>

                            <label for="am" class="form-label">Apellido Materno:</label>
                            <input type="text" name="materno" id="am" class="form-control" required="required" value="' . $b2 . '"/>
                            
                            <label for="Fingreso" class="form-label">Fecha de ingreso: </label>
                            <input type="text" name="Fingreso" id="Fingreso" class="form-control" required="required" value="' . $b4 . '"/>

                            <label for="RFC" class="form-label">RFC: </label>
                            <input type="text" name="RFC" id="RFC" class="form-control" required="required" value="' . $b5 . '"/>

                            <label for="tit" class="form-label">Titulo: </label>
                            <input type="text" name="titulo" id="tit" class="form-control" required="required" value="' . $b6 . '"/>

                            <label for="esp" class="form-label">Especialidad: </label>
                            <input type="text" name="Especialidad" id="esp" class="form-control" required="required" value="' . $b7 . '"/>

                            <label for="email" class="form-label">Correo del docente</label>
                            <input type="text" name="correo" id="email" class="form-control" required="required" value="' . $b9 . '"/><br>

                            <label for="tel" class="form-label">Teléfono: </label>
                            <input type="text" name="tel" id="tel" class="form-control" required="required" value="' . $b10 . '"/>

                            <label for="secc" class="form-label">seccion: </label>
                            <input type="text" name="seccion" id="secc" class="form-control" required="required" value="' . $b8 . '"/>

                            <label for="tot" class="form-label">Años de servicio: </label>
                            <input type="text" name="total" id="tot" class="form-control" required="required" value="' . $b11 . '"/>

                            <div class="text-center">
                                <!-- BOTÓN DE GUARDADO -->
                                <input class="btn btn-primary" type="submit" value="Guardar">

                                <!-- Envía el valor de ID DOCENTES de forma oculta para su posterior guardado -->
                                <input type="hidden" name="clave_docente_id" value="' . $docenteID . '">   

                                <!-- BOTÓN DE Consulta docentes -->
                                <a class="btn btn-primary" href="consulta_docentes.php">Consulta docentes</a>                         

                                <!-- BOTÓN DE ELIMINAR -->                      
                                <a class="btn btn-primary" href="editar_docentes.php?elimina_docente_id=' . $docenteID . '" class="btn btn-primary">Eliminar docente</a></br> 
                            </div>
                        </form>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
}

/* -----------------------USA EL PROCEDIMIENTO UPLOADTEACHER------------------------- */

/* GUARDA DOCENTE Y MANDA MENSAJE */
if (isset($_GET['clave_docente_id'])) {
    $ID_DOCENTE = mysqli_real_escape_string($conexion, $_GET['clave_docente_id']);
    $DOCENTE_NOM = mysqli_real_escape_string($conexion, $_GET['nombre']);
    $DOCENTE_EMAIL = mysqli_real_escape_string($conexion, $_GET['correo']);

        // Modificación de valores en el registro SQL específico
        $consulta = mysqli_query($conexion, "UPDATE DOCENTES SET Docente_nombres = '$DOCENTE_NOM', Docente_correo = '$DOCENTE_EMAIL' WHERE Docente_id = '$ID_DOCENTE'");

        // Bandera para actualización completada
        if ($consulta) {
            echo '
            <div class="row" style="display: block;">
                <h3 style="margin:5% auto; color: #003D79; font-size: 300%; text-align: center;">Actualizado Correctamente</h3>
            </div>
            
            <!-- BOTÓN DE Consulta DOCENTE-->
            <div class="text-center">
                <a class="btn btn-primary" href="consulta_docentes.php">Consulta Docentes</a>
            </div>';
        } else {
            echo '
            <div class="row" style="display: block;">
                <h3 style="margin:5% auto; color: #003D79; font-size: 300%; text-align: center;">No se pudo guardar</h3>
            </div>';
        }
    }

/* BORRADO DE DOCENTES */
if (isset($_GET['elimina_docente_id'])) {
    $ID_DOCENTE_BORRAR = mysqli_real_escape_string($conexion, $_GET['elimina_docente_id']);

    // Verifica si existe un registro con el ID_DOCENTE_BORRAR
    $busca = mysqli_query($conexion, "SELECT * FROM DOCENTES WHERE Docente_id='$ID_DOCENTE_BORRAR'");
    $resultado = mysqli_num_rows($busca);

    if ($resultado == 1) {
        // Eliminación de valores en el registro SQL específico
        $consulta = mysqli_query($conexion, "DELETE * FROM DOCENTES WHERE Docente_id = '$ID_DOCENTE_BORRAR'");

        // Bandera de la eliminación de valores
        if ($consulta) {
            echo '
            <div class="row" style="display: block;">
                <h3 style="margin:5% auto; color: #003D79; font-size: 300%; text-align: center;">Eliminada Correctamente</h3>
            </div>
            
            <!-- BOTÓN DE Consulta -->
            <div class="text-center">
                <a class="btn btn-primary" href="consulta_docentes.php">Consulta Docentes</a>
            </div>';
        } else {
            echo '
            <div class="row" style="display: block;">
                <h3 style="margin:5% auto; color: #003D79; font-size: 300%; text-align: center;">No se pudo eliminar</h3>
            </div>';
        }
    }
}

mysqli_close($conexion);
?>   

</body>
</html>