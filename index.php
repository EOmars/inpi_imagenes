<?php
include "config.php";


if (isset($_POST['but_submit'])) {

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);


    if ($uname != "" && $password != "") {

        $sql_query = "select count(*) as cntUser from usuarios where username='" . $uname . "' and password='" . $password . "'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if ($count > 0) {
            $_SESSION['uname'] = $uname;
            header('Location: home.php');
        } else {
            echo "Contraseña o usuario incorrecto";
        }
    }
}
?>
<html>

<head>
    <title>Iniciar sesion</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container">
        <form method="post" action="index.php">
            <div id="div_login">
                <h1>Iniciar sesion</h1>
                <div>
                    Nombre de usuario:
                    <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Nombre" />
                </div>
                <div>
                    Contraseña
                    <input type="password" class="textbox" id="txt_uname" name="txt_pwd" placeholder="Contraseña" />
                </div>
                <div>
                    <input type="submit" value="Entrar" name="but_submit" id="but_submit" />
                </div>
            </div>
        </form>
    </div>
</body>

</html>