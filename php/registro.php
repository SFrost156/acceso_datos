<?php
require '../conexion.php';

$username = $_POST['username'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$es_admin = $_POST['es_admin'];
$clave_admin = $_POST['clave_admin'] ?? '';

if ($es_admin === 'si') {
    if ($clave_admin !== 'admin123') {
        echo "<script>alert('Clave de administrador incorrecta'); window.location='../templates/registro.html';</script>";
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO administrador (username, nombre_completo, telefono, password) VALUES (?, ?, ?, ?)");
} else {
    $stmt = $conn->prepare("INSERT INTO mesero (username, nombre_completo, telefono, password) VALUES (?, ?, ?, ?)");
}

$stmt->bind_param("ssss", $username, $nombre, $telefono, $password);

if ($stmt->execute()) {
    echo "<script>alert('Registro exitoso. Inicia sesión.'); window.location='../index.html';</script>";
} else {
    echo "<script>alert('Error: usuario ya existe o error en BD'); window.location='../templates/registro.html';</script>";
}

$stmt->close();
$conn->close();
?>
