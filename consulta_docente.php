<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Docentes</title>

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
            <input type="text" class="form-control" name="busqueda" placeholder="Consulta docente por sección">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </div>
        </div>
    </form>
</div>

<div class="container mt-4">
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
            // Consulta SQL para buscar al docente por sección
            $sql = "SELECT * FROM docentes WHERE seccion LIKE '%$busqueda%'";

            // Ejecutar la consulta
            $resultado = $conexion->query($sql);

            // Mostrar los resultados en cuadros azules
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<div class="alert alert-primary" role="alert">';
                    echo $fila['nombre_doc'];
                    echo '</div>';
                }
            } else {
                echo '<p>No se encontraron resultados.</p>';
            }
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
