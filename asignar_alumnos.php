<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <?php
// Verificamos si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperamos los datos del formulario
    $num_cuenta = $_POST["num_cuenta"];
    $clave = $_POST["clave"];

    // Mostramos los datos almacenados en las variables
    echo "Clave del alumno: " . $num_cuenta . "<br>";
    echo "Folio de trabajo: " . $clave;
</head>
<body>
    <h2>Formulario</h2>
    <form action="procesar_formulario.php" method="POST">
        <label for="num_cuenta">Clave del alumno:</label><br>
        <input type="text" id="num_cuenta" name="num_cuenta"><br>
        <label for="clave">Folio de trabajo:</label><br>
        <input type="text" id="clave" name="clave"><br><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>