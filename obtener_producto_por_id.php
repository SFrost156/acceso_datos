<?php
require 'conexion.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("SELECT id, nombre, cantidad, categoria, estado, fecha_inventario FROM alimentos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($producto);
} else {
    echo json_encode(null);
}
?>