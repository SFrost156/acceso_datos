<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM alimentos WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Producto eliminado correctamente.";
        } else {
            echo "Error al eliminar el producto.";
        }
    } else {
        echo "ID inválido.";
    }
}
?>

