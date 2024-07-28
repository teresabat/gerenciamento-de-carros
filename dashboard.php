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

// Verificar se há uma pesquisa
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Execute a consulta para obter os carros
if ($search) {
    $query = "SELECT * FROM cars WHERE modelo LIKE ?";
    $stmt = $conn->prepare($query);
    $search_param = '%' . $search . '%';
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM cars";
    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="assets/style-dashboard.css">
</head>
<body>
<div class="container">
    <div class="logout">
        <a id="btnHeader" href="logout.php" class="btn btn-danger">Sair</a>
    </div>
    <?php if ($role === 'admin'): ?>
        <div class="btn-create">
            <a href="create_car.php" class="btn btn-success">Criar Novo Carro</a>
        </div>
    <?php endif; ?>
    <div class="content">
        <h1>Car List</h1>
        <div class="search-bar">
        <form action="dashboard.php" method="get">
            <input type="text" name="search" placeholder="Pesquisar por modelo" value="<?php echo htmlspecialchars($search); ?>" class="form-control" style="width: 300px; display: inline;">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>
        </div>
        <table>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ano</th>
                <?php if ($role === 'admin'): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['marca']); ?></td>
                    <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                    <td><?php echo htmlspecialchars($row['ano']); ?></td>
                    <?php if ($role === 'admin'): ?>
                        <td class="actions">
                            <a id="btnActions" href="update_car.php?id=<?php echo $row['id']; ?>" class="btn btn-dark">Update</a>
                            <a id="btnActions" href="delete_car.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this car?');" class="btn btn-danger">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>
