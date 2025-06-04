<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "sistema_alimentos";

$conn = new mysqli($host, $usuario, $clave, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>