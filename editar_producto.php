<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;
    $categoria = $_POST['categoria'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $fecha_inventario = $_POST['fecha_inventario'] ?? null;

    if ($id && $nombre && $cantidad !== null && $categoria && $estado && $fecha_inventario) {
        $stmt = $conn->prepare("UPDATE alimentos SET nombre = ?, cantidad = ?, categoria = ?, estado = ?, fecha_inventario = ? WHERE id = ?");
        $stmt->bind_param("sisssi", $nombre, $cantidad, $categoria, $estado, $fecha_inventario, $id);

        if ($stmt->execute()) {
            echo "Producto actualizado correctamente.";
        } else {
            echo "Error al actualizar el producto.";
        }
    } else {
        echo "Datos incompletos.";
    }
}
?>
