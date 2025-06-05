<?php
require '../conexion.php';

if (!isset($_POST['mesa'])) {
    die("Error: No se recibió el número de mesa.");
}

$mesa = intval($_POST['mesa']);

// Obtener los pedidos activos de la mesa
$consulta = $conn->prepare("SELECT * FROM pedidos WHERE mesa = ? AND estado = 'activo'");
$consulta->bind_param("i", $mesa);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado->num_rows === 0) {
    die("No hay pedidos activos para esta mesa.");
}

// Insertar en tabla pagado
while ($pedido = $resultado->fetch_assoc()) {
    $insert = $conn->prepare("INSERT INTO pagado (mesa, usuario_mesero, fecha, producto_id, cantidad)
                              VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param(
        "issii",
        $pedido['mesa'],
        $pedido['usuario_mesero'],
        $pedido['fecha'],
        $pedido['producto_id'],
        $pedido['cantidad']
    );
    $insert->execute();
}

// Actualizar estado en pedidos
$update = $conn->prepare("UPDATE pedidos SET estado = 'pagado' WHERE mesa = ?");
$update->bind_param("i", $mesa);
$update->execute();

$conn->close();
echo "OK";
?>
