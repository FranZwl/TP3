<?php include_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Agregar Registro</h1>
    <form action="" method="POST" enctype="multipart/form-data" class="mb-3">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" name="descripcion" required></textarea>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Subir Imagen desde tu computadora:</label>
            <input type="file" class="form-control" name="imagen">
        </div>
        <div class="mb-3">
            <label for="imagen_url" class="form-label">O ingresa la URL de la imagen:</label>
            <input type="url" class="form-control" name="imagen_url" placeholder="Pega aquí el enlace directo de la imagen">
        </div>
        <button type="submit" class="btn btn-primary">Crear Registro</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $imagenRuta = '';


        if (!empty($_FILES["imagen"]["name"])) {
            $targetDir = "uploads/";
            $fileName = basename($_FILES["imagen"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

         
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array(strtolower($fileType), $allowedTypes)) {
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $targetFilePath)) {
                    $imagenRuta = $targetFilePath;
                } else {
                    echo '<div class="alert alert-danger">Error al subir la imagen.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Formato de imagen no permitido. Solo se permiten JPG, JPEG, PNG y GIF.</div>';
            }
        }
        
       
        if (empty($imagenRuta) && !empty($_POST["imagen_url"])) {
            $imagenRuta = $_POST["imagen_url"];
        }

        if (!empty($imagenRuta)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO registros (nombre, descripcion, imagen) VALUES (?, ?, ?)");
                $stmt->execute([$nombre, $descripcion, $imagenRuta]);
                echo '<div class="alert alert-success">Registro creado con éxito.</div>';
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger">Error al crear registro: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning">Por favor, sube una imagen o proporciona una URL.</div>';
        }
    }
    ?>
</body>
</html>
