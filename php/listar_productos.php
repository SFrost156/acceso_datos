<?php
require '../conexion.php';

$sql = "SELECT id, nombre, cantidad FROM productos WHERE cantidad > 0 ORDER BY nombre ASC";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $id = htmlspecialchars($row['id']);
        $nombre = htmlspecialchars($row['nombre']);
        $cantidad = htmlspecialchars($row['cantidad']);
        echo "<option value='$id'>$nombre (Stock: $cantidad)</option>";
    }
} else {
    echo "<option disabled>No hay productos disponibles</option>";
}

$conn->close();
?>
