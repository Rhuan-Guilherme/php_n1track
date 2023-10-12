<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json");

require 'ConectBanco/bancoUsuarios.php';

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $ticket_id = isset($_GET['id']) ? $_GET['id'] : '';

    if (!empty($ticket_id)) {
        // Consulta SQL para excluir um ticket com base no ID
        $sql = "DELETE FROM tickets WHERE id = $ticket_id";

        if ($conexao->query($sql) === TRUE) {
            echo json_encode(array('message' => 'Ticket excluído com sucesso'));
        } else {
            echo json_encode(array('message' => 'Erro ao excluir o ticket: ' . $conexao->error));
        }
    } else {
        echo json_encode(array('message' => 'Parâmetro ticket_id não fornecido'));
    }
} else {
    echo json_encode(array('message' => 'Método de solicitação inválido. Use o método DELETE.'));
}

$conexao->close();
?>
