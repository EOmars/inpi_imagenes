<?php
include_once 'config.php';


$query = "select l.lengua, l.nombre , l.municipio , l.estado , f.ubicacion_foto, f.subido_por, f.created_at from pueblo_foto as f
	inner join lenguas l on f.id_pueblo = l.id;";

$result = $con->query($query) or die(mysqli_error($con));;
$arr = [];

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $arr['data'][] = $row;
    }
}

echo json_encode($arr);
return;
