<?php

session_start();


$regular = 32.82;
$diesel = 31.57;
$super = 29.75;


$apoyoRegular = 5;
$apoyoDiesel = 5;
$apoyoSuper = 7;

//crear registro de ventas
if (!isset($_SESSION["ventas"])) {
    $_SESSION["ventas"] = array();
}

//guardar kla vrnta
if (isset($_POST["guardar"])) {

    $combustible = $_POST["combustible"];
    $galones = $_POST["galones"];

    //si los galones son mayores a 0
    if ($galones > 0) {

        //determinar el precio
        if ($combustible == "Regular") {

            if ($galones <= 100) {
                $precio = $regular + $apoyoRegular;
                $subsidio = $galones;
            } else {
                $precio = $regular;
                $subsidio = 0;
            }

        } elseif ($combustible == "Diesel") {

            if ($galones <= 100) {
                $precio = $diesel + $apoyoDiesel;
                $subsidio = $galones;
            } else {
                $precio = $diesel;
                $subsidio = 0;
            }

        } else {

            if ($galones <= 100) {
                $precio = $super + $apoyoSuper;
                $subsidio = $galones;
            } else {
                $precio = $super;
                $subsidio = 0;
            }
        }

        //calculo total de la venta
        $total = $galones * $precio;

      
        $_SESSION["ventas"][] = array(
            "combustible" => $combustible,
            "galones" => $galones,
            "precio" => $precio,
            "subsidio" => $subsidio,
            "total" => $total
        );
    }
}


if (isset($_POST["borrar"])) {
    $_SESSION["ventas"] = array();
}



$totalRegular = 0;
$totalDiesel = 0;
$totalSuper = 0;

$galonesRegular = 0;
$galonesDiesel = 0;
$galonesSuper = 0;

$totalSubsidio = 0;
$totalDia = 0;
$totalGalones = 0;



foreach ($_SESSION["ventas"] as $venta) {

    if ($venta["combustible"] == "Regular") {
        $totalRegular += $venta["total"];
        $galonesRegular += $venta["galones"];
    }

    if ($venta["combustible"] == "Diesel") {
        $totalDiesel += $venta["total"];
        $galonesDiesel += $venta["galones"];
    }

    if ($venta["combustible"] == "Super") {
        $totalSuper += $venta["total"];
        $galonesSuper += $venta["galones"];
    }

    $totalSubsidio += $venta["subsidio"];
    $totalDia += $venta["total"];
    $totalGalones += $venta["galones"];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Control de Gasolinera</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="contenedor">

        <h1>CONTROL DE GASOLINERA</h1>

        <h2>Registrar venta</h2>

        <form method="POST">

            <label>Tipo de combustible:</label>

            <select name="combustible" required>

                <option value="">Seleccione</option>
                <option value="Regular">Regular</option>
                <option value="Diesel">Diesel</option>
                <option value="Super">Super</option>

            </select>


            <label>Cantidad de galones:</label>

            <input
                type="number"
                name="galones"
                min="1"
                step="0.01"
                required
            >


            <button type="submit" name="guardar">
                Registrar venta
            </button>

        </form>


        <h2>Precios</h2>

        <table>

            <tr>
                <th>Combustible</th>
                <th>Precio referencia</th>
                <th>Apoyo social</th>
                <th>Precio con apoyo</th>
            </tr>

            <tr>
                <td>Regular</td>
                <td>Q32.82</td>
                <td>Q5.00</td>
                <td>Q37.82</td>
            </tr>

            <tr>
                <td>Diesel</td>
                <td>Q31.57</td>
                <td>Q5.00</td>
                <td>Q36.57</td>
            </tr>

            <tr>
                <td>Super</td>
                <td>Q29.75</td>
                <td>Q7.00</td>
                <td>Q36.75</td>
            </tr>

        </table>


        <h2>Resumen del día</h2>

        <table>

            <tr>
                <th>Combustible</th>
                <th>Galones vendidos</th>
                <th>Total vendido</th>
            </tr>

            <tr>
                <td>Regular</td>
                <td><?php echo $galonesRegular; ?></td>
                <td>Q<?php echo number_format($totalRegular, 2); ?></td>
            </tr>

            <tr>
                <td>Diesel</td>
                <td><?php echo $galonesDiesel; ?></td>
                <td>Q<?php echo number_format($totalDiesel, 2); ?></td>
            </tr>

            <tr>
                <td>Super</td>
                <td><?php echo $galonesSuper; ?></td>
                <td>Q<?php echo number_format($totalSuper, 2); ?></td>
            </tr>

        </table>


        <div class="resumen">

            <p>
                <strong>Total de galones vendidos:</strong>
                <?php echo $totalGalones; ?>
            </p>

            <p>
                <strong>Galones con apoyo social:</strong>
                <?php echo $totalSubsidio; ?>
            </p>

            <p>
                <strong>Total vendido durante el día:</strong>
                Q<?php echo number_format($totalDia, 2); ?>
            </p>

        </div>

        <form method="POST">

            <button
                type="submit"
                name="borrar"
                class="borrar"
            >
                Borrar
            </button>

        </form>

    </div>

</body>

</html>