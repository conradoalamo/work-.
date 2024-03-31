<?php
include 'conexao.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sala_id = $_POST['sala'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $tempo_utilizacao = $_POST['tempo_utilizacao'];
    $organizador = $_POST['organizador'];
    $assunto = $_POST['assunto'];
    $num_participantes = $_POST['participantes'];
    $horario_final = date('H:i', strtotime($horario . ' + ' . $tempo_utilizacao . ' hours'));
    $sql_verificar_agendamento = "SELECT * FROM agendamentos WHERE sala_id = '$sala_id' AND data = '$data' AND ((horario BETWEEN '$horario' AND '$horario_final') OR (horario_final BETWEEN '$horario' AND '$horario_final'))";
    $result_verificar_agendamento = $conn->query($sql_verificar_agendamento);
    if ($result_verificar_agendamento->num_rows > 0) {
        echo "<script>alert('Sala já cadastrada para este dia e horário');</script>";
    } else {
        $sql_agendamento = "INSERT INTO agendamentos (sala_id, data, horario, horario_final, tempo_utilizacao, organizador, assunto, num_participantes) VALUES ('$sala_id', '$data', '$horario', '$horario_final', '$tempo_utilizacao', '$organizador', '$assunto', '$num_participantes')";
        if ($conn->query($sql_agendamento) === TRUE) {
            header("Location: agendamento.php");
            exit;
        } else {
            echo "Erro ao agendar reunião: " . $conn->error;
        }
    }
}
function formatarData($data)
{
    return date("d/m/y", strtotime($data));
}
$sql_salas = "SELECT * FROM salas_reunioes WHERE status = 'disponivel'";
$result_salas = $conn->query($sql_salas);
$sql_agendamentos = "SELECT agendamentos.*, salas_reunioes.nome AS nome_sala FROM agendamentos JOIN salas_reunioes ON agendamentos.sala_id = salas_reunioes.id";
$result_agendamentos = $conn->query($sql_agendamentos);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Agendamento</title>
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
        <h2>Agendar Sala</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="sala">Selecione a Sala:</label>
                <select name="sala" id="sala" required>
                    <option value="">Selecione a sala</option>
                    <?php
                    if ($result_salas->num_rows > 0) {
                        while ($row_sala = $result_salas->fetch_assoc()) {
                            echo "<option value='{$row_sala['id']}'>{$row_sala['nome']}</option>";
                        }
                    } else {
                        echo "<option value='' disabled>Nenhuma sala disponível</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="data">Data da Reunião:</label>
                <input type="date" id="data" name="data" required>
            </div>
            <div class="mb-3">
                <label for="horario">Horário da Reunião:</label>
                <input type="time" id="horario" name="horario" required>
            </div>
            <div class="mb-3">
                <label for="tempo_utilizacao">Tempo de Utilização (em horas):</label>
                <input type="number" id="tempo_utilizacao" name="tempo_utilizacao" min="1" required>
            </div>
            <div class="mb-3">
                <label for="organizador">Nome do Organizador:</label>
                <input type="text" id="organizador" name="organizador" required>
            </div>
            <div class="mb-3">
                <label for="assunto">Assunto da Reunião:</label>
                <input type="text" id="assunto" name="assunto" required>
            </div>
            <div class="mb-3">
                <label for="participantes">Número de Participantes:</label>
                <input type="number" id="participantes" name="participantes" required>
            </div>
            <button type="submit" class="btn btn-primary">Confirmar Agendamento</button>
        </form>
        <h2>Agendamentos Feitos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome do Organizador</th>
                    <th>Assunto</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Tempo de Utilização (horas)</th>
                    <th>Número de Participantes</th>
                    <th>Número da sala</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_agendamentos->num_rows > 0) {
                    while ($row = $result_agendamentos->fetch_assoc()) {
                        echo "<tr>
                    <td>{$row['organizador']}</td>
                    <td>{$row['assunto']}</td>
                    <td>" . formatarData($row['data']) . "</td>
                    <td>{$row['horario']}</td>
                    <td>{$row['tempo_utilizacao']}</td>
                    <td>{$row['num_participantes']}</td>
                    <td>{$row['nome_sala']}</td>
                    <td>
                        <a href='excluir_agendamento.php?id={$row['id']}' class='btn btn-danger'>Excluir</a>
                    </td>
                </tr>";
                    }
                } else {
                    echo "<tr>
                <td colspan='8'>Nenhum agendamento feito.</td>
            </tr>";
                }
                ?>
            </tbody>


        </table>
    </div>
</body>

</html>