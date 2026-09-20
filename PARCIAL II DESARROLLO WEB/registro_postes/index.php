<?php

include("conexion.php");

//guardar el poste
if (isset($_POST["guardar"])) {

    $no_poste = $_POST["no_poste"];
    $fecha_registro = $_POST["fecha_registro"];
    $direccion = $_POST["direccion"];
    $departamento = $_POST["departamento"];
    $municipio = $_POST["municipio"];
    $referencia = $_POST["referencia"];
    $latitud = $_POST["latitud"];
    $longitud = $_POST["longitud"];

    $sql = "INSERT INTO postes
            (no_poste, fecha_registro, direccion, departamento, municipio, referencia, latitud, longitud)
            VALUES
            ('$no_poste', '$fecha_registro', '$direccion', '$departamento', '$municipio', '$referencia', '$latitud', '$longitud')";

    if ($conexion->query($sql)) {
        $mensaje = "Poste registrado correctamente";
    } else {
        $mensaje = "Error al registrar el poste";
    }
}


//eliminar el poste
if (isset($_GET["eliminar"])) {

    $id = $_GET["eliminar"];

    $sql = "DELETE FROM postes WHERE id = $id";

    $conexion->query($sql);
}


//consultar postes
$sql = "SELECT * FROM postes ORDER BY id DESC";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro de Postes</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="contenedor">

        <h1>REGISTRO DE POSTES DE ALUMBRADO</h1>

        <h2>Zacapa</h2>


        <?php

        if (isset($mensaje)) {

            echo "<p class='mensaje'>$mensaje</p>";

        }

        ?>


        <h2>Registrar poste</h2>

        <form method="POST">

            <label>No. de poste:</label>

            <input
                type="text"
                name="no_poste"
                required
            >


            <label>Fecha de registro:</label>

            <input
                type="date"
                name="fecha_registro"
                required
            >


            <label>Dirección:</label>

            <input
                type="text"
                name="direccion"
               
                required
            >


            <label>Departamento:</label>

            <input
                type="text"
                name="departamento"
                value="Zacapa"
                required
            >


            <label>Municipio:</label>

            <select name="municipio" required>

                <option value="">Seleccione</option>

                <option value="Zacapa">Zacapa</option>

                <option value="Estanzuela">Estanzuela</option>

                <option value="Río Hondo">Río Hondo</option>

                <option value="Gualán">Gualán</option>

                <option value="Teculután">Teculután</option>

                <option value="Usumatlán">Usumatlán</option>

                <option value="Cabañas">Cabañas</option>

                <option value="San Diego">San Diego</option>

                <option value="La Unión">La Unión</option>

                <option value="Huité">Huité</option>

            </select>


            <label>Referencia:</label>

            <input
                type="text"
                name="referencia"
                
                required
            >


            <label>Latitud:</label>

            <input
                type="number"
                name="latitud"
                step="0.0000001"
                
                required
            >


            <label>Longitud:</label>

            <input
                type="number"
                name="longitud"
                step="0.0000001"
               
                required
            >


            <button type="submit" name="guardar">
                Registrar poste
            </button>

        </form>


        <h2>Postes registrados</h2>


        <table>

            <tr>

                <th>No. Poste</th>

                <th>Fecha</th>

                <th>Dirección</th>

                <th>Departamento</th>

                <th>Municipio</th>

                <th>Referencia</th>

                <th>Latitud</th>

                <th>Longitud</th>

                <th>Acción</th>

            </tr>


            <?php

            if ($resultado->num_rows > 0) {

                while ($poste = $resultado->fetch_assoc()) {

            ?>

                    <tr>

                        <td>
                            <?php echo $poste["no_poste"]; ?>
                        </td>

                        <td>
                            <?php echo $poste["fecha_registro"]; ?>
                        </td>

                        <td>
                            <?php echo $poste["direccion"]; ?>
                        </td>

                        <td>
                            <?php echo $poste["departamento"]; ?>
                        </td>

                        <td>
                            <?php echo $poste["municipio"]; ?>
                        </td>

                        <td>
                            <?php echo $poste["referencia"]; ?>
                        </td>

                        <td>
                            <?php echo $poste["latitud"]; ?>
                        </td>

                        <td>
                            <?php echo $poste["longitud"]; ?>
                        </td>

                        <td>

                            <a
                                href="index.php?eliminar=<?php echo $poste["id"]; ?>"
                                onclick="return confirm('¿Desea eliminar este poste?');"
                            >
                                Eliminar
                            </a>

                        </td>

                    </tr>

            <?php

                }

            } else {

                echo "<tr>";
                echo "<td colspan='9'>No hay postes registrados</td>";
                echo "</tr>";

            }

            ?>

        </table>

    </div>

</body>

</html>