<?php
include 'conexao.php';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_sala = $_GET['id'];

    $sql = "SELECT * FROM salas_reunioes WHERE id = $id_sala";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $capacidade = $row['capacidade'];
        $recursos = $row['recursos_disponiveis'];
    } else {
        header("Location: gestao.php");
        exit();
    }
} else {
    header("Location: gestao.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $capacidade = $_POST['capacidade'];
    $recursos = $_POST['recursos'];
    $sql = "UPDATE salas_reunioes SET nome = '$nome', capacidade = '$capacidade', recursos_disponiveis = '$recursos' WHERE id = $id_sala";

    if ($conn->query($sql) === TRUE) {
        header("Location: gestao.php");
        exit();
    } else {
        echo "Erro ao atualizar sala: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sala de Reuniões</title>
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
        <h1>Editar Sala de Reuniões</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_sala; ?>" method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Sala:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" required>
            </div>
            <div class="mb-3">
                <label for="capacidade" class="form-label">Capacidade:</label>
                <input type="number" class="form-control" id="capacidade" name="capacidade"
                    value="<?php echo $capacidade; ?>" required>
            </div>
            <div class="mb-3">
                <label for="recursos" class="form-label">Recursos Disponíveis:</label>
                <input type="text" class="form-control" id="recursos" name="recursos" value="<?php echo $recursos; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="gestao.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>