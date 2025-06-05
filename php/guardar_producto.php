<?php
require '../conexion.php';

$fecha = $_POST['fecha'];
$nombres = $_POST['nombre'];
$cantidades = $_POST['cantidad'];
$categorias = $_POST['categoria'];
$precios = $_POST['precio'];

$stmt = $conn->prepare("INSERT INTO productos (fecha, nombre, cantidad, categoria, precio) VALUES (?, ?, ?, ?, ?)");

for ($i = 0; $i < count($nombres); $i++) {
    $nombre = trim($nombres[$i]);
    $cantidad = (int) $cantidades[$i];
    $categoria = trim($categorias[$i]);
    $precio = (float) $precios[$i];

    $stmt->bind_param("ssisd", $fecha, $nombre, $cantidad, $categoria, $precio);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo "<script>alert('Productos registrados correctamente'); window.location='../templates/admin.html';</script>";
