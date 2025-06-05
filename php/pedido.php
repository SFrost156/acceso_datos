<?php
require '../conexion.php';

// Validar campos obligatorios
if (!isset($_POST['mesero'], $_POST['fecha'], $_POST['mesa'], $_POST['producto'], $_POST['cantidad'])) {
    die("Error: Datos incompletos.");
}

$mesero = $_POST['mesero']; // este es el username del mesero
$fecha = $_POST['fecha'];
$mesa = intval($_POST['mesa']);
$productos = $_POST['producto'];
$cantidades = $_POST['cantidad'];

// Verificar si la mesa ya tiene un pedido activo
$check = $conn->prepare("SELECT * FROM pedidos WHERE mesa = ? AND estado = 'activo'");
$check->bind_param("i", $mesa);
$check->execute();
$result = $check->get_result();
if ($result->num_rows > 0) {
    die("Esta mesa ya tiene un pedido activo. Por favor genere el recibo primero.");
}

// Insertar los productos del pedido
for ($i = 0; $i < count($productos); $i++) {
    $producto_id = intval($productos[$i]);
    $cantidad = intval($cantidades[$i]);

    // Validar stock
    $stock = $conn->prepare("SELECT cantidad FROM productos WHERE id = ?");
    $stock->bind_param("i", $producto_id);
    $stock->execute();
    $stock_result = $stock->get_result()->fetch_assoc();

    if (!$stock_result || $stock_result['cantidad'] < $cantidad) {
        die("No hay suficiente stock para el producto con ID $producto_id.");
    }

    // Insertar pedido
    $insert = $conn->prepare("INSERT INTO pedidos (mesa, usuario_mesero, fecha, producto_id, cantidad, estado)
                              VALUES (?, ?, ?, ?, ?, 'activo')");
    $insert->bind_param("isssi", $mesa, $mesero, $fecha, $producto_id, $cantidad);
    $insert->execute();

    // Descontar stock
    $update = $conn->prepare("UPDATE productos SET cantidad = cantidad - ? WHERE id = ?");
    $update->bind_param("ii", $cantidad, $producto_id);
    $update->execute();
}

$conn->close();
echo "Pedido registrado exitosamente.";
?>
