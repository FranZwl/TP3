<?php include_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Registros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Registros</h1>
    <a href="crear.php" class="btn btn-primary mb-3">Agregar Nuevo Registro</a>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM registros ORDER BY id DESC");
                while ($row = $stmt->fetch()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . htmlspecialchars($row['nombre']) . "</td>
                        <td>" . htmlspecialchars($row['descripcion']) . "</td>
                        <td><img src='" . htmlspecialchars($row['imagen']) . "' class='img-thumbnail' width='100'></td>
                        <td>
                            <a href='editar.php?id={$row['id']}' class='btn btn-sm btn-warning'>Editar</a>
                            <a href='eliminar.php?id={$row['id']}' class='btn btn-sm btn-danger'>Eliminar</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
