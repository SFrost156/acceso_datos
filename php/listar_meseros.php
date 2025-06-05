<?php
require '../conexion.php';

$sql = "SELECT username, nombre_completo FROM mesero ORDER BY nombre_completo ASC";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    echo "<option value='' disabled selected>Seleccione mesero</option>";
    while ($row = $resultado->fetch_assoc()) {
        $username = htmlspecialchars($row['username']);
        $nombre = htmlspecialchars($row['nombre_completo']);
        echo "<option value='$username'>$nombre</option>";
    }
} else {
    echo "<option disabled>No hay meseros registrados</option>";
}

$conn->close();
?>
