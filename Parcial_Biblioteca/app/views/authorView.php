
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autores</title>
</head>
<body>
    <h2>Gestión de Autores</h2>

    <!-- Formulario para crear un nuevo autor -->
    <form method="POST">
        <input type="text" name="full_name" placeholder="Nombre Completo" required>
        <input type="date" name="date_of_birth" placeholder="Fecha de Nacimiento" required>
        <input type="date" name="date_of_death" placeholder="Fecha de Muerte">
        <button type="submit" name="create">Crear Autor</button>
    </form>

    <h3>Lista de Autores</h3>
    <ul>
        <?php foreach ($authors as $author): ?>
        <li>
            <?php echo $author['FULL_NAME']; ?> (Fecha de Nacimiento:
            <?php echo $author['DATE_OF_BIRTH']; ?>)

            <!-- Formulario para actualizar un autor -->
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id_author" value="<?php echo $author['ID_AUTHOR']; ?>">
                <input type="text" name="full_name" value="<?php echo $author['FULL_NAME']; ?>" required>
                <input type="date" name="date_of_birth" value="<?php echo $author['DATE_OF_BIRTH']; ?>" required>
                <input type="date" name="date_of_death" value="<?php echo $author['DATE_OF_DEATH']; ?>">
                <button type="submit" name="update">Actualizar</button>
            </form>

            <!-- Formulario para eliminar un autor -->
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id_author" value="<?php echo $author['ID_AUTHOR']; ?>">
                <button type="submit" name="delete"
                    onclick="return confirm('¿Seguro que deseas eliminar este autor?')">Eliminar</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
