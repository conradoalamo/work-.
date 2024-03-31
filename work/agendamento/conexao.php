<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "agendamento";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    // echo "Conexão bem-sucedida!";
}