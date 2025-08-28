<?php
$host = "sql312.infinityfree.com";  // GEEN https:// gebruiken
$user = "if0_39807618";
$password = "JOUW_WACHTWOORD";
$database = "if0_39807618_ydf";

$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    die("Database verbinding mislukt: " . mysqli_connect_error());
}
?>