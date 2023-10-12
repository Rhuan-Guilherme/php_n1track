<?php
header("Access-Control-Allow-Origin: *"); // Permitir que qualquer origem acesse o servidor (para desenvolvimento)
header("Access-Control-Allow-Methods: POST"); // Permitir apenas métodos POST
header("Access-Control-Allow-Headers: Content-Type"); // Permitir apenas o cabeçalho Content-Type

require 'ConectBanco/bancoUsuarios.php';

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
} else {
    echo "Conexão bem sucedida!";
}

$data = json_decode(file_get_contents("php://input"));
$chamado_id = $data->id;

// Execute uma consulta SQL para atualizar o status do chamado
$sql = "UPDATE tickets SET status = 'Fechado' WHERE id = $chamado_id";

// Verifique se a consulta foi bem-sucedida
if ($conexao->query($sql) === TRUE) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'message' => $conexao->error));
}

$conexao->close();
?>
