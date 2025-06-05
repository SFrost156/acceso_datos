<?php
require '../conexion.php';

if (isset($_POST['id'], $_POST['nombre'], $_POST['categoria'], $_POST['precio'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = floatval($_POST['precio']);

    $stmt = $conn->prepare("UPDATE productos SET nombre=?, categoria=?, precio=? WHERE id=?");
    $stmt->bind_param("ssdi", $nombre, $categoria, $precio, $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header('Location: ../templates/mostrar_productos.html');
exit;
?>
