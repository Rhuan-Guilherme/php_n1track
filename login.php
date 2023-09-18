<?php
header("Access-Control-Allow-Origin: *"); // Permitir que qualquer origem acesse o servidor (para desenvolvimento)
header("Access-Control-Allow-Methods: POST"); // Permitir apenas métodos POST
header("Access-Control-Allow-Headers: Content-Type"); // Permitir apenas o cabeçalho Content-Type

require 'ConectBanco/bancoUsuarios.php';

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $conexao->real_escape_string($data->email);
    $senha = $data->senha;

    // Consulta SQL para verificar as credenciais do usuário
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $senhaHash = $row["senha"];

       
        if (password_verify($senha, $senhaHash)) {

            $response = [
                "id" => $row["id"],
                "nome" => $row["nome"],
                "email" => $row["email"],
            ];
            echo json_encode($response);
        } else {
            echo "Credenciais inválidas";
        }
    } else {
        echo "Usuário não encontrado";
    }
}

?>