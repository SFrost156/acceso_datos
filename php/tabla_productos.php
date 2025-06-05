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
        $id = $row['id'];
        $nombre = htmlspecialchars($row['nombre'], ENT_QUOTES);
        $categoria = htmlspecialchars($row['categoria'], ENT_QUOTES);
        $precio = $row['precio'];
        echo "<tr>
                <td>{$row['fecha']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['cantidad']}</td>
                <td>{$row['categoria']}</td>
                <td>$ " . number_format($precio, 2, ',', '.') . "</td>
                <td>
                    <button onclick='abrirEditar($id, \"$nombre\", \"$categoria\", $precio)'>Editar</button>
                    <button onclick='abrirAumentar($id)'>Aumentar</button>
                    <button onclick='abrirEliminar($id)'>Eliminar</button>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p>No hay productos registrados.</p>";
}

$conn->close();
?>
