<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombres = $_POST['nombre'];
    $cantidades = $_POST['cantidad'];
    $categorias = $_POST['categoria'];
    $estados = $_POST['estado'];
    $fecha_inventario = $_POST['fecha_inventario']; // General para todos

    $stmt = $conn->prepare("INSERT INTO alimentos (nombre, cantidad, categoria, estado, fecha_inventario) VALUES (?, ?, ?, ?, ?)");

    for ($i = 0; $i < count($nombres); $i++) {
        $stmt->bind_param("sisss", $nombres[$i], $cantidades[$i], $categorias[$i], $estados[$i], $fecha_inventario);
        $stmt->execute();
    }

    echo "Producto(s) registrado(s) correctamente.";
}
?>
