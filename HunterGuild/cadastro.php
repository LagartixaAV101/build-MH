<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = trim($_POST["user"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if ($user === "" || $email === "" || $senha === "") {
        die("Preencha todos os campos.");
    }

    // Verifica se usuário ou e-mail já existem
    $sql = "SELECT id FROM users WHERE user = ? OR email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("ss", $user, $email);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $stmt->close();
        $conn->close();
        die("Usuário ou e-mail já cadastrado.");
    }

    $stmt->close();

    // Cria o hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Cadastra o usuário
    $sql = "INSERT INTO users (user, email, hash_senha)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("sss", $user, $email, $senhaHash);

    if ($stmt->execute()) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "ERRO: " . $stmt->error;
    } 
}

$conn->close();
?>
