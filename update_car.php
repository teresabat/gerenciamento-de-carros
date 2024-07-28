<?php
session_start();
include 'db.php';

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

// Obtenha o papel do usuário
$user_id = $_SESSION['user_id'];
$query = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$role = $user['role'];

// Verifique se o usuário é administrador
if ($role !== 'admin') {
    echo "Acesso negado.";
    exit();
}

// Verifique se a solicitação é POST para atualização
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];

    $query = "UPDATE cars SET marca = ?, modelo = ?, ano = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssii', $marca, $modelo, $ano, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    // Verifique se o ID do carro está definido para carregar os dados
    if (!isset($_GET['id'])) {
        echo "ID do carro não fornecido.";
        exit();
    }

    $id = $_GET['id'];
    $query = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();

    // Verifique se o carro existe
    if (!$car) {
        echo "Carro não encontrado.";
        exit();
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Carro</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="assets/style-update.css">
</head>
<body>
<div class="container">
    <div class="content">
        <h2>Editar Carro</h2>
        <form action="update_car.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($car['id']); ?>"><br>
            <div class="form-group">
                <label for="marca">Marca:</label><br>
                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo htmlspecialchars($car['marca']); ?>" required>
            </div>
            <br>
            <div class="form-group">
                <label for="modelo">Modelo:</label><br>
                <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo htmlspecialchars($car['modelo']); ?>" required>
            </div>
            <br>
            <div class="form-group">
                <label for="ano">Ano:</label><br>
                <input type="number" class="form-control" id="ano" name="ano" value="<?php echo htmlspecialchars($car['ano']); ?>" required>
            </div>
            <button id="btnEditar" type="submit" class="btn btn-primary">Editar</button>
            <br>
            <a id="btnVoltar" href="dashboard.php" class="btn btn-dark">Voltar</a>
        </form>
    </div>
</div>
</body>
</html>
