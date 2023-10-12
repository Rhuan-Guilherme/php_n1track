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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $data->nome;
    $login = $data->login;
    $ramal = $data->ramal;
    $patrimonio = $data->patrimonio;
    $informacao = $data->informacao;
    $local = $data->local;
    $userId = $data->userId;
    $tipo = $data->tipo;
    $chamado = $data->chamado;
    $destinatario = $data->destinatario;


    $sql = "INSERT INTO tickets (user_id, nome, login, ramal, patrimonio, informacao, local, chamado, destinatario, status, tipo) VALUES ('$userId', '$nome','$login', '$ramal', '$patrimonio', '$informacao', '$local', '$chamado', '$destinatario', 'Aberto', '$tipo')";
    
    $resultado = $conexao->query($sql);
    if ($resultado === FALSE) {
        echo "Erro na consulta: " . $conexao->error;
    } else {
        echo "Dados adicionados no banco";
    }

}

$conexao->close();

?>