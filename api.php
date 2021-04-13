<?php
include_once 'config.php';

// obtiene la lista de lengas
if ($_POST['option'] == "lengua") {

    $query = "select distinct(lengua) as lengua from lenguas;";

    $result = $con->query($query) or die(mysqli_error($con));;
    $arr = [];

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row['lengua'];
        }
    }

    echo json_encode($arr);
    return;
}

// obtiene la lista de los nombres de una lengua, una vez seleccionada la lengua
if ($_POST['option'] == 'nombre_lengua') {
    $lengua = $_POST['lengua'];

    $query = "select distinct(nombre) as nombre from lenguas where lengua ='" . $lengua . "'";

    $result = mysqli_query($con, $query);

    $arr = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row['nombre'];
        }
    }

    echo json_encode($arr);
    return;
}

// Obtiene la lista de estados dado la lengua y el nombre
if ($_POST['option'] == 'estado') {
    $nombre = $_POST['nombre'];
    $lengua = $_POST['lengua'];

    $query = "select distinct(estado) as estado from lenguas where nombre ='" . $nombre . "' and lengua = '" . $lengua . "'";

    $result = mysqli_query($con, $query);

    $arr = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row['estado'];
        }
    }

    echo json_encode($arr);
    return;
}


// Obtiene la lista de municipios, dada la lengua, el nombre y el estado
if ($_POST['option'] == 'municipio') {
    $estado = $_POST['estado'];
    $lengua = $_POST['lengua'];
    $nombre = $_POST['nombre'];

    $query = "select distinct(municipio) municipio from lenguas where estado ='" . $estado . "' 
    and lengua = '" . $lengua . "' and nombre = '" . $nombre . "' order by municipio";

    $result = mysqli_query($con, $query);

    $arr = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row['municipio'];
        }
    }

    echo json_encode($arr);
    return;
}
