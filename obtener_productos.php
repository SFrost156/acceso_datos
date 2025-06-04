<?php
require 'conexion.php';

$sql = "SELECT id, nombre, cantidad, categoria, estado, fecha_inventario FROM alimentos ORDER BY id DESC";
$result = $conn->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($productos);
?>