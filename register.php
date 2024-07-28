<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'visitor'; // Todos os novos usuários são visitantes

    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $username, $password, $role);

    if ($stmt->execute()) {
        header("Location: index.html"); // Redireciona para index.html
        exit(); // Garante que o script pare de executar
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
