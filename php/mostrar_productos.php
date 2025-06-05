<?php
require '../conexion.php';

$result = $conn->query("SELECT id, fecha, nombre, cantidad, categoria, precio FROM productos ORDER BY fecha DESC");

if ($result->num_rows > 0) {
    echo "<table>
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Alimento</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        $json = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
        echo "<tr>
                <td>{$row['fecha']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['cantidad']}</td>
                <td>{$row['categoria']}</td>
                <td>$ " . number_format($row['precio'], 2, ',', '.') . "</td>
                <td>
                    <button onclick='abrirEditar(\"$json\")'>Editar</button>
                    <button onclick='abrirAumentar({$row['id']})'>Aumentar</button>
                    <button onclick='abrirEliminar({$row['id']})'>Eliminar</button>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p>No hay productos registrados.</p>";
}
$conn->close();
?>
