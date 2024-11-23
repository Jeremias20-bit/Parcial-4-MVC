<?php
// Incluir el archivo de la clase Author y Genre
require_once 'models/Author.php';
require_once 'models/Genre.php';
require_once 'models/Book.php';
require_once 'models/Stock.php';

// Instanciar las clases
$author = new Author();
$genre = new Genre();
$book = new Book();
$stock = new Stock();

// Manejar autores
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['author_action'])) {
    if ($_POST['author_action'] == 'create') {
        $data = [
            'full_name' => $_POST['full_name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'date_of_death' => $_POST['date_of_death']
        ];
        $author->create($data);
    } elseif ($_POST['author_action'] == 'update') {
        $data = [
            'id_author' => $_POST['id_author'],
            'full_name' => $_POST['full_name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'date_of_death' => $_POST['date_of_death']
        ];
        $author->update($data);
    } elseif ($_POST['author_action'] == 'delete') {
        $id_author = $_POST['id_author'];
        $author->delete($id_author);
    }
}
$authors = $author->getAll(); // Obtener todos los autores

// Manejar géneros
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['genre_action'])) {
    if ($_POST['genre_action'] == 'create') {
        $data = ['name' => $_POST['name']];
        $genre->create($data);
    } elseif ($_POST['genre_action'] == 'update') {
        $data = [
            'id_genre' => $_POST['id_genre'],
            'name' => $_POST['name']
        ];
        $genre->update($data);
    } elseif ($_POST['genre_action'] == 'delete') {
        $id_genre = $_POST['id_genre'];
        $genre->delete($id_genre);
    }
}
$genres = $genre->getAll(); // Obtener todos los géneros

// Manejar libros
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_action'])) {
    if ($_POST['book_action'] == 'create') {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'year_publication' => $_POST['year_publication'],
            'id_author' => $_POST['id_author'],
            'id_genre' => $_POST['id_genre']
        ];
        $book->create($data);
    } elseif ($_POST['book_action'] == 'update') {
        $data = [
            'id_book' => $_POST['id_book'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'year_publication' => $_POST['year_publication'],
            'id_author' => $_POST['id_author'],
            'id_genre' => $_POST['id_genre']
        ];
        $book->update($data);
    } elseif ($_POST['book_action'] == 'delete') {
        $id_book = $_POST['id_book'];
        $book->delete($id_book);
    }
}
$books = $book->getAll(); // Obtener todos los libros

// Manejar STOCK
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stock_action'])) {
    if ($_POST['stock_action'] == 'create') {
        $data = [
            'id_book' => $_POST['id_book'],
            'total_stock' => $_POST['total_stock'],
            'notes' => $_POST['notes'],
            'last_inventory' => $_POST['last_inventory'],
        ];
        $stock->create($data);
    } elseif ($_POST['stock_action'] == 'update') {
        $data = [
            'id_stock' => $_POST['id_stock'],
            'id_book' => $_POST['id_book'],
            'total_stock' => $_POST['total_stock'],
            'notes' => $_POST['notes'],
            'last_inventory' => $_POST['last_inventory'],
        ];
        $stock->update($data);
    } elseif ($_POST['stock_action'] == 'delete') {
        $id_stock = $_POST['id_stock'];
        $stock->delete($id_stock);  
    }
}
$stocks = $stock->getAll(); 

// Determinar qué sección mostrar
$section = isset($_GET['section']) ? $_GET['section'] : 'authors';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Biblioteca</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1, h2, h3 {
            color: #333;
        }

        nav {
            background-color: #2c3e50;
            padding: 10px 0;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline-block;
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            font-size: 18px;
        }

        nav ul li a:hover {
            color: #0000FF;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #34495e;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form {
            margin: 0;
            display: inline;
        }

        form input[type="text"],
        form input[type="date"],
        form input[type="number"],
        form select,
        form button {
            display: inline-block;
            width: auto;
            margin-right: 5px;
        }

        .section-header {
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
            color: #34495e;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }

    </style>
</head>
<body>
    <h1 style="text-align:center;">Gestión de Biblioteca</h1>
    <nav>
        <ul>
            <li><a href="?section=authors">Gestión de Autores</a></li>
            <li><a href="?section=book">Insertar Libro</a></li>
            <li><a href="?section=genre">Gestión de Géneros</a></li>
            <li><a href="?section=stock">Insertar Stock</a></li>
        </ul>
    </nav>

    <div class="container">
        <!-- Contenido dinámico según la sección -->
        <?php if ($section == 'authors'): ?>
            <h2 class="section-header">Gestión de Autores</h2>
            <div class="form-container">
                <form method="POST">
                    <input type="hidden" name="author_action" value="create">
                    <div class="form-group">
                        <input type="text" name="full_name" placeholder="Nombre Completo" required>
                    </div>
                    <div class="form-group">
                        <input type="date" name="date_of_birth" required>
                    </div>
                    <div class="form-group">
                        <input type="date" name="date_of_death">
                    </div>
                    <button type="submit">Crear Autor</button>
                </form>
            </div>
            <h3>Lista de Autores</h3>
            <ul>
                <?php foreach ($authors as $author): ?>
                    <li>
                        <?php echo $author['FULL_NAME']; ?> (Nacido: <?php echo $author['DATE_OF_BIRTH']; ?>)
                        <div class="actions">
                            <form method="POST">
                                <input type="hidden" name="author_action" value="update">
                                <input type="hidden" name="id_author" value="<?php echo $author['ID_AUTHOR']; ?>">
                                <input type="text" name="full_name" value="<?php echo $author['FULL_NAME']; ?>" required>
                                <input type="date" name="date_of_birth" value="<?php echo $author['DATE_OF_BIRTH']; ?>" required>
                                <input type="date" name="date_of_death" value="<?php echo $author['DATE_OF_DEATH']; ?>">
                                <button type="submit">Actualizar</button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="author_action" value="delete">
                                <input type="hidden" name="id_author" value="<?php echo $author['ID_AUTHOR']; ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        <?php elseif ($section == 'genre'): ?>
            <h2 class="section-header">Gestión de Géneros</h2>
            <div class="form-container">
                <form method="POST">
                    <input type="hidden" name="genre_action" value="create">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nombre del Género" required>
                    </div>
                    <button type="submit">Crear Género</button>
                </form>
            </div>
            <h3>Lista de Géneros</h3>
            <ul>
                <?php foreach ($genres as $genre): ?>
                    <li>
                        <?php echo $genre['NAME']; ?>
                        <div class="actions">
                            <form method="POST">
                                <input type="hidden" name="genre_action" value="update">
                                <input type="hidden" name="id_genre" value="<?php echo $genre['ID_GENRE']; ?>">
                                <input type="text" name="name" value="<?php echo $genre['NAME']; ?>" required>
                                <button type="submit">Actualizar</button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="genre_action" value="delete">
                                <input type="hidden" name="id_genre" value="<?php echo $genre['ID_GENRE']; ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        <!-- Book -->
        <?php elseif ($section == 'book'): ?>
            <h2 class="section-header">Gestión de Libros</h2>
            <div class="form-container">
                <form method="POST">
                    <input type="hidden" name="book_action" value="create">
                    <div class="form-group">
                        <input type="text" name="title" placeholder="Título" required>
                    </div>
                    <div class="form-group">
                        <textarea name="description" placeholder="Descripción" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="number" name="year_publication" placeholder="Año de publicación" required>
                    </div>
                    <div class="form-group">
                        <select name="id_author" required>
                            <option value="">Selecciona un autor</option>
                            <?php foreach ($authors as $author): ?>
                                <option value="<?php echo $author['ID_AUTHOR']; ?>"><?php echo $author['FULL_NAME']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="id_genre" required>
                            <option value="">Selecciona un género</option>
                            <?php foreach ($genres as $genre): ?>
                                <option value="<?php echo $genre['ID_GENRE']; ?>"><?php echo $genre['NAME']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit">Crear Libro</button>
                </form>
            </div>
            <h3>Lista de Libros</h3>
            <ul>
                <?php foreach ($books as $book): ?>
                    <li>
                        <strong><?php echo $book['TITLE']; ?></strong> (Publicado en: <?php echo $book['YEAR_PUBLICATION']; ?>)
                        <div class="actions">
                            <form method="POST">
                                <input type="hidden" name="book_action" value="update">
                                <input type="hidden" name="id_book" value="<?php echo $book['ID_BOOK']; ?>">
                                <input type="text" name="title" value="<?php echo $book['TITLE']; ?>" required>
                                <textarea name="description" required><?php echo $book['DESCRIPTION']; ?></textarea>
                                <input type="number" name="year_publication" value="<?php echo $book['YEAR_PUBLICATION']; ?>" required>
                                <select name="id_author" required>
                                    <?php foreach ($authors as $author): ?>
                                        <option value="<?php echo $author['ID_AUTHOR']; ?>" <?php echo ($book['ID_AUTHOR'] == $author['ID_AUTHOR']) ? 'selected' : ''; ?>>
                                            <?php echo $author['FULL_NAME']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="id_genre" required>
                                    <?php foreach ($genres as $genre): ?>
                                        <option value="<?php echo $genre['ID_GENRE']; ?>" <?php echo ($book['ID_GENRE'] == $genre['ID_GENRE']) ? 'selected' : ''; ?>>
                                            <?php echo $genre['NAME']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit">Actualizar</button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="book_action" value="delete">
                                <input type="hidden" name="id_book" value="<?php echo $book['ID_BOOK']; ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        <!-- Stock -->
        <?php elseif ($section == 'stock'): ?>
            <h2 class="section-header">Gestión de Stock</h2>
            <div class="form-container">
                <form method="POST">
                    <input type="hidden" name="stock_action" value="create">
                    <div class="form-group">
                        <select name="id_book" required>
                            <option value="">Selecciona un libro</option>
                            <?php foreach ($books as $book): ?>
                                <option value="<?php echo $book['ID_BOOK']; ?>"><?php echo $book['TITLE']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="total_stock" placeholder="Cantidad en stock" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="notes" placeholder="Notas" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="last_inventory" placeholder="Último inventario" required>
                    </div>
                    <button type="submit">Crear Stock</button>
                </form>
            </div>
            <h3>Lista de Stocks</h3>
            <ul>
                <?php foreach ($stocks as $stock): ?>
                    <li>
                        <?php echo "Libro: " . $stock['ID_BOOK'] . " - Stock: " . $stock['TOTAL_STOCK']; ?>
                        <div class="actions">
                            <form method="POST">
                                <input type="hidden" name="stock_action" value="update">
                                <input type="hidden" name="id_stock" value="<?php echo $stock['ID_STOCK']; ?>">
                                <button type="submit">Actualizar</button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="stock_action" value="delete">
                                <input type="hidden" name="id_stock" value="<?php echo $stock['ID_STOCK']; ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
