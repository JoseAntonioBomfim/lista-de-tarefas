<?php
include 'db.php';

$id = $_GET['id'];
$direction = $_GET['direction'];

// Obtém a tarefa atual e sua ordem
$stmt = $pdo->prepare("SELECT id, ordem FROM tarefas WHERE id = :id");
$stmt->execute(['id' => $id]);
$tarefa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tarefa) {
    echo json_encode(['success' => false, 'message' => 'Tarefa não encontrada']);
    exit;
}

$ordemAtual = $tarefa['ordem'];

// Define a nova ordem
if ($direction === 'up') {
    $novaOrdem = $ordemAtual - 1;
} else if ($direction === 'down') {
    $novaOrdem = $ordemAtual + 1;
}

// Atualiza a posição da tarefa que está na nova posição temporariamente
$stmt = $pdo->prepare("UPDATE tarefas SET ordem = -1 WHERE ordem = :novaOrdem");
$stmt->execute(['novaOrdem' => $novaOrdem]);

// Atualiza a ordem da tarefa desejada
$stmt = $pdo->prepare("UPDATE tarefas SET ordem = :novaOrdem WHERE id = :id");
$success = $stmt->execute(['novaOrdem' => $novaOrdem, 'id' => $id]);

// Restaura a ordem da tarefa temporária para o valor anterior da tarefa movida
$stmt = $pdo->prepare("UPDATE tarefas SET ordem = :ordemAtual WHERE ordem = -1");
$stmt->execute(['ordemAtual' => $ordemAtual]);

echo json_encode(['success' => $success]);

