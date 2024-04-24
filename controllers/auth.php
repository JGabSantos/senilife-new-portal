<?php

$dadosJson = file_get_contents('php://input');
$dados = json_decode($dadosJson, true);

$type = $dados['type'];

require_once "mysqli_connect.php";

require "vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key_privada = file_get_contents("keys/chave_privada.pem");

function login($dados, $conn, $key_privada)
{
    $username = $dados['username'];
    $senha = $dados['senha'];

    // Consultar usuário no banco de dados
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $resultado = $stmt->fetch();

    if (!$resultado) {
        return "User não encontrado";
    }

    // Verificar senha
    if ($senha !== $resultado['senha']) {
        return "Senha incorreta";
    }

    // Login bem-sucedido!
    $payload = [
        'sub' => $resultado["id"],
        'emiss' => time()
    ];

    $token = JWT::encode($payload, $key_privada, 'HS256');
    setcookie("token", $token, time()+(3600*3));

    return true;
}

$result = $type($dados, $conn, $key_privada);

if ($result !== true) {
    echo json_encode(["s" => "erro", "m" => $result]);
    die();
} else {
    echo json_encode(["s" => "sucess"]);
}





