<?php
$servidor = "localhost";
$baseDeDatos = "crudphp";
$usuario = "root";
$password = "1234";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos", $usuario, $password);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
