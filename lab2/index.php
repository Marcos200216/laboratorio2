<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y Búsqueda de Materias</title>
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            display: flex;
            width: 80%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .left, .right {
            padding: 20px;
            width: 50%;
        }
        .left {
            background-color: #f9f9f9;
            border-right: 1px solid #ccc;
        }
        .right {
            background-color: #fff;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-weight: bold;
        }
        form input[type="text"],
        form input[type="number"] {
            width: calc(100% - 22px); /* Ajuste para compensar el padding */
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        form input[type="submit"] {
            background-color: #ddd;
            color: #333;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: calc(100% - 22px); /* Ajuste para compensar el padding */
            transition: background-color 0.3s ease;
        }
        form input[type="submit"]:hover {
            background-color: #ccc;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        .search-form {
            text-align: center;
        }
        .search-form input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 70%;
            margin-bottom: 10px;
        }
        .search-form input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .search-form input[type="submit"]:hover {
            background-color: #0056b3;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .result-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <h2>Registro de Materias</h2>
            <form method="post">
                <label for="id">ID:</label>
                <input type="number" name="id" id="id" required><br>
                <label for="nombre">Nombre de la Materia:</label>
                <input type="text" name="nombre" id="nombre" required><br>
                <label for="profesor">Profesor:</label>
                <input type="text" name="profesor" id="profesor" required><br>
                <input type="submit" value="Registrar Materia">
            </form>
        </div>
        <div class="right">
            <h2>Buscar Materias</h2>
            <div class="search-form">
                <form method="get">
                    <input type="text" name="search" placeholder="Nombre de la Materia">
                    <input type="submit" value="Buscar">
                </form>
            </div>
            <?php
            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "utn";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Manejo del formulario de registro de materias
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $profesor = $_POST['profesor'];
                $sql = "INSERT INTO MATERIA (id, nombre, profesor) VALUES ('$id', '$nombre', '$profesor')";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Materia registrada correctamente.</p>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Búsqueda de materias por nombre
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql = "SELECT * FROM MATERIA WHERE nombre LIKE '%$search%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<div class='result-table'>";
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Nombre de la Materia</th><th>Profesor</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['nombre']}</td>";
                        echo "<td>{$row['profesor']}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>No se encontraron materias con ese nombre.</p>";
                }
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
