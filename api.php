<?php
header("Access-Control-Allow-Origin: *"); // Permitir que qualquer origem acesse o servidor (para desenvolvimento)
header("Access-Control-Allow-Methods: POST"); // Permitir apenas métodos POST
header("Access-Control-Allow-Headers: Content-Type"); // Permitir apenas o cabeçalho Content-Type

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "login";

$conexao = new mysqli($servername, $username, $password, $dbName);

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
} else {
    echo "Conexão bem sucedida!";
}

// Receber dados do corpo da solicitação como JSON
$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $conexao->real_escape_string($data->nome);
    $email = $conexao->real_escape_string($data->email);
    $senha = $data->senha;

    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome','$email', '$senhaCriptografada')";

    if ($conexao->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
        echo $nome;
        echo $email;
        echo $senha;
    } else {
        echo "Erro ao cadastrar: " . $conexao->error;
    }
}

$conexao->close();
?>