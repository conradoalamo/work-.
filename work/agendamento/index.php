<?php
include 'conexao.php';
$sql_salas = "SELECT * FROM salas_reunioes";
$result_salas = $conn->query($sql_salas);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
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
        <h2>Visão Geral das Salas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Sala</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_salas->num_rows > 0) {
                    while ($row_sala = $result_salas->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row_sala['nome']}</td>
                                <td>{$row_sala['status']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Nenhuma sala disponível.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="agendamento.php" class="btn btn-primary">Agendar Sala</a>
        <a href="gestao.php" class="btn btn-primary">Gestão de Salas</a>
    </div>
</body>

</html>