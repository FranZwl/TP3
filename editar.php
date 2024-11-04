<?php 
include_once 'conexion.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM registros WHERE id = ?");
$stmt->execute([$id]);
$registro = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $imagen_url = $_POST['imagen_url'] ?: $registro['imagen'];

    try {
        $stmt = $pdo->prepare("UPDATE registros SET nombre = ?, descripcion = ?, imagen = ? WHERE id = ?");
        $stmt->execute([$nombre, $descripcion, $imagen_url, $id]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al actualizar registro: ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Editar Registro</h1>
    <form action="" method="POST" class="mb-3">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($registro['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" name="descripcion" required><?php echo htmlspecialchars($registro['descripcion']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="imagen_url" class="form-label">URL de la imagen:</label>
            <input type="url" class="form-control" name="imagen_url" value="<?php echo htmlspecialchars($registro['imagen']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>
