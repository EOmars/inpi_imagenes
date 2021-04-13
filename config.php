<?php

session_start();

$host = "localhost"; /* Host name */
$user = "inpi"; /* User */
$password = "secret"; /* Password */
$dbname = "inpi"; /* Database name */

$con = mysqli_connect($host, $user, $password, $dbname);
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

/* cambiar el conjunto de caracteres a utf8 */
if (!$con->set_charset("utf8")) {
    exit();
} else {
}
