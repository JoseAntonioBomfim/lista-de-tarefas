<?php
$host = "34.172.223.184";
$dbname = "sistema_tarefas";
$username = "jabs0151";
$password = ""; // deixe em branco se você não configurou uma senha no XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>