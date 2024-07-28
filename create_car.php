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

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];

    // Inserir o novo carro no banco de dados
    $query = "INSERT INTO cars (marca, modelo, ano) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $marca, $modelo, $ano);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Criar Novo Carro</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="assets/style-create.css">
</head>
<body>
<div class="container">
    <div class="content">
        <h2>Criar Novo Carro</h2>
        <form action="create_car.php" method="post">
            <div class="form-group">
                <label for="marca">Marca:</label><br>
                <input type="text" class="form-control" id="marca" name="marca" required>
            </div>
            <br>
            <div class="form-group">
                <label for="modelo">Modelo:</label><br>
                <input type="text" class="form-control" id="modelo" name="modelo" required>
            </div>
            <br>
            <div class="form-group">
                <label for="ano">Ano:</label><br>
                <input type="number" class="form-control" id="ano" name="ano" required>
            </div>
            <button id="btnCriar" type="submit" class="btn btn-primary">Criar</button>
            <br>
            <a id="btnVoltar" href="dashboard.php" class="btn btn-dark">Voltar</a>
        </form>
    </div>
</div>
</body>
</html>
