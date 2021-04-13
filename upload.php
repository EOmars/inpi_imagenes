<?php
include "config.php";

// Check user login or not
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Subir imagen</title>
    <!-- BootStrap CSS CDN-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- JavaScript CDN For BootStrap  -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <div class="form-group">
                <select onchange="changeLengua(this.value)" id="select-lengua" class="custom-select">
                    <option>Seleccionar Lengua</option>
                </select>
            </div>
            <div class="form-group">
                <select onchange="changeNombre(this.value)" id="select-nombre" class="custom-select">
                    <option>Seleccionar Nombre</option>
                </select>
            </div>
            <div class="form-group">
                <select onchange="changeEstado(this.value)" id="select-estado" class="custom-select">
                    <option>Seleccionar Estado</option>
                </select>
            </div>
            <div class="form-group">
                <select id="select-municipio" class="custom-select">
                    <option>Seleccionar Municipio</option>
                </select>
            </div>

        </div>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function() {

        let option = "lengua";
        let select_menu = $('#select-lengua')[0]; // this expression is same as document.getElementById('dynamic_menu')
        $.ajax({
            url: "api.php",
            dataType: "json",
            method: "post",
            data: {
                option
            },
            success: function(response) {
                //alert(response.length);
                console.log($.isArray(response)); // if response is an array, this function will return true

                response.forEach((item, index) => {

                    var option = document.createElement("option");
                    option.value = item;
                    option.text = item;
                    select_menu.appendChild(option);
                })
            },
            error: error => {
                console.error(error)
            }
        })
    });


    function changeLengua(lengua) {
        let option = "nombre_lengua";
        let nombreLengua = $('#select-nombre')[0];

        //Removing all the old options from item list and model list and adding only one option in one go
        $('#select-nombre').empty().append('<option>Seleccionar Nombre</option>');
        $('#select-estado').empty().append('<option>Seleccionar Estado</option>');
        $('#select-municipio').empty().append('<option>Seleccionar Municipio</option>');

        $.ajax({
            url: "api.php",
            dataType: "json",
            method: "post",
            data: {
                option,
                lengua
            },
            success: function(response) {
                response.forEach(item => {
                    // console.log(index, item);
                    var option = document.createElement("option");
                    option.value = item
                    option.text = item
                    nombreLengua.appendChild(option)
                })
            },
            error: err => console.error(err)
        })
    }

    //Getting model list on the basis of item id
    function changeNombre(nombre) {
        let option = "estado";
        let selectEstado = $('#select-estado')[0];

        //Removing all the select options and adding only one option in one go
        $('#select-estado').empty().append('<option>Seleccionar Estado</option>');
        $('#select-municipio').empty().append('<option>Seleccionar Municipio</option>');

        $.ajax({
            url: "api.php",
            dataType: "json",
            method: "post",
            data: {
                option,
                nombre
            },
            success: function(response) {
                response.forEach(estado => {
                    //console.log(index,item);
                    var option = document.createElement("option");
                    option.value = estado
                    option.text = estado
                    selectEstado.appendChild(option);
                })
            }
        })
    }

    //Getting model list on the basis of item id
    function changeEstado(estado) {
        let option = "municipio";
        let selectMunicipio = $('#select-municipio')[0];

        //Removing all the select options and adding only one option in one go
        $('#select-municipio').empty().append('<option>Seleccionar Municipio</option>');

        $.ajax({
            url: "api.php",
            dataType: "json",
            method: "post",
            data: {
                option,
                estado
            },
            success: function(response) {
                response.forEach(municipio => {
                    //console.log(index,item);
                    var option = document.createElement("option");
                    option.value = municipio
                    option.text = municipio
                    selectMunicipio.appendChild(option);
                })
            },
            error: err => console.error(err)
        })
    }
</script>

</html>