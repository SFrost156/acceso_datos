<?php
require '../conexion.php';

if (!isset($_GET['mesa'])) {
    die("<p>Error: No se especificó la mesa.</p>");
}

$mesa = intval($_GET['mesa']);

// Obtener pedidos activos
$sql = "SELECT p.*, pr.nombre AS producto_nombre, pr.precio, m.nombre_completo AS mesero_nombre
        FROM pedidos p
        JOIN productos pr ON p.producto_id = pr.id
        JOIN mesero m ON p.usuario_mesero = m.username
        WHERE p.mesa = ? AND p.estado = 'activo'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mesa);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<p>No hay pedido activo para la mesa $mesa.</p>";
    exit;
}

$total = 0;
$rowEjemplo = $res->fetch_assoc();
$mesero = $rowEjemplo['mesero_nombre'];
$fecha = $rowEjemplo['fecha'];
echo "<h3>Recibo - Mesa $mesa</h3>";
echo "<p><strong>Mesero:</strong> $mesero</p>";
echo "<p><strong>Fecha:</strong> $fecha</p>";
echo "<table style='width:100%; color:white; border-collapse:collapse; margin-top:10px'>
        <tr style='background:#0d6efd; color:white;'>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>";

do {
    $producto = $rowEjemplo['producto_nombre'];
    $cantidad = $rowEjemplo['cantidad'];
    $precio = $rowEjemplo['precio'];
    $subtotal = $cantidad * $precio;
    $total += $subtotal;

    echo "<tr>
            <td>$producto</td>
            <td>$cantidad</td>
            <td>$" . number_format($precio, 2, ',', '.') . "</td>
            <td>$" . number_format($subtotal, 2, ',', '.') . "</td>
          </tr>";
} while ($rowEjemplo = $res->fetch_assoc());

echo "<tr style='font-weight:bold'>
        <td colspan='3'>Total</td>
        <td>$" . number_format($total, 2, ',', '.') . "</td>
      </tr>";
echo "</table>";

$conn->close();
?>
