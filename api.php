<?php
include_once 'config.php';


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

// Getting item list on the basis of company_id
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

// Getting model list on the basis of item_id
if ($_POST['option'] == 'estado') {
    $nombre = $_POST['nombre'];

    $query = "select distinct(estado) as estado from lenguas where nombre ='" . $nombre . "'";

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

if ($_POST['option'] == 'municipio') {
    $estado = $_POST['estado'];

    $query = "select distinct(municipio) municipio from lenguas where estado ='" . $estado . "' order by municipio";

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
