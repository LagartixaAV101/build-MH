<?php

session_start();

require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($email === "" || $senha === "") {
    die("Preencha o e-mail e a senha.");
}

$stmt = $conn->prepare(
    "SELECT id, user, email, hash_senha
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->bind_param("s", $email);
$stmt->execute();

$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario || !password_verify($senha, $usuario["hash_senha"])) {
    die("E-mail ou senha incorretos.");
}

session_regenerate_id(true);

$_SESSION["usuario_id"] = $usuario["id"];
$_SESSION["user"] = $usuario["user"];
$_SESSION["email"] = $usuario["email"];

header("Location: index.php");
exit;
?>
