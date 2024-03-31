<?php
include 'conexao.php';
if (isset($_GET['id'])) {
    $id_agendamento = $_GET['id'];
    $sql_excluir = "DELETE FROM agendamentos WHERE id = $id_agendamento";
    if ($conn->query($sql_excluir) === TRUE) {
        header("Location: agendamento.php");
        exit;
    } else {
        echo "Erro ao excluir agendamento: " . $conn->error;
    }
} else {
    echo "ID de agendamento não fornecido.";
}