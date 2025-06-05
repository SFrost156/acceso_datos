<?php
require '../conexion.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Verificar si es admin
$stmt = $conn->prepare("SELECT password FROM administrador WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($hash);
    $stmt->fetch();
    if (password_verify($password, $hash)) {
        header("Location: ../templates/admin.html");
        exit;
    }
}
$stmt->close();

// Verificar si es mesero
$stmt = $conn->prepare("SELECT password FROM mesero WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($hash);
    $stmt->fetch();
    if (password_verify($password, $hash)) {
        header("Location: ../templates/mesero.html");
        exit;
    }
}
$stmt->close();

echo "<script>alert('Usuario o contraseña incorrectos'); window.location='../index.html';</script>";
$conn->close();
?>
