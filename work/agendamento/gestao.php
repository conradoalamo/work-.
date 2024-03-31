<?php
include 'conexao.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $capacidade = $_POST['capacidade'];
    $recursos = $_POST['recursos'];
    $sql = "INSERT INTO salas_reunioes (nome, capacidade, recursos_disponiveis) VALUES ('$nome', '$capacidade', '$recursos')";
    if ($conn->query($sql) === TRUE) {
        header("Location: gestao.php");
        exit();
    } else {
        echo "Erro ao cadastrar sala: " . $conn->error;
    }
}
if (isset($_GET['excluir']) && $_GET['excluir'] == true && isset($_GET['id'])) {
    $id_sala = $_GET['id'];
    $sql = "DELETE FROM salas_reunioes WHERE id = $id_sala";
    if ($conn->query($sql) === TRUE) {
        header("Location: gestao.php");
        exit();
    } else {
        echo "Erro ao excluir sala: " . $conn->error;
    }
}

$sql = "SELECT * FROM salas_reunioes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Salas de Reuniões</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Página Inicial</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="agendamento.php">Agendamento</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestao.php">Gestão</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Gestão de Salas de Reuniões</h1>
        <h2>Cadastrar Nova Sala</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Sala:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="capacidade" class="form-label">Capacidade:</label>
                <input type="number" class="form-control" id="capacidade" name="capacidade" required>
            </div>
            <div class="mb-3">
                <label for="recursos" class="form-label">Recursos Disponíveis:</label>
                <input type="text" class="form-control" id="recursos" name="recursos">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
        <h2>Salas Cadastradas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Capacidade</th>
                    <th>Recursos</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nome']}</td>
                                <td>{$row['capacidade']}</td>
                                <td>{$row['recursos_disponiveis']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <a href='gestaoeditar.php?id={$row['id']}' class='btn btn-sm btn-warning'>Editar</a>
                                    <a href='gestao.php?excluir=true&id={$row['id']}' class='btn btn-sm btn-danger'>Excluir</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma sala cadastrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>