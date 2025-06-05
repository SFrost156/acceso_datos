<?php
require '../conexion.php';

if (isset($_POST['id'], $_POST['cantidad'], $_POST['accion'])) {
    $id = intval($_POST['id']);
    $cantidad = intval($_POST['cantidad']);
    $accion = $_POST['accion'];

    if ($cantidad > 0 && in_array($accion, ['aumentar', 'disminuir'])) {
        $signo = $accion === 'disminuir' ? '-' : '+';
        $stmt = $conn->prepare("UPDATE productos SET cantidad = cantidad $signo ? WHERE id = ?");
        $stmt->bind_param("ii", $cantidad, $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
header('Location: ../templates/mostrar_productos.html');
exit;
?>
