<?php
$host = "localhost";
$bd = "sitiowebphp";
$usuario = "root";
$contrasenioa = "";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasenioa);
    if ($conexion) {
        # code...
        //echo "conectado.. a sistema";
    }
} catch (Exception $ex) {
    //throw $th;
    echo $ex->getMessage();
}

?>