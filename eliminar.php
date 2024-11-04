<?php 
include_once 'conexion.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM registros WHERE id = ?");
$stmt->execute([$id]);
$registro = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("DELETE FROM registros WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al eliminar registro: ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Eliminar Registro</h1>
    <p>¿Estás seguro de que quieres eliminar el registro "<strong><?php echo htmlspecialchars($registro['nombre']); ?></strong>"?</p>
    <form action="" method="POST">
        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
