<?php
	require_once "conexao.php";

	if ($_SERVER["REQUEST_METHOD"] === "POST") {

    	$user = trim($_POST["user"] ?? "");
    	$email = trim($_POST["email"] ?? "");
    	$senha = $_POST["senha"] ?? "";

    	if ($user === "" || $email === "" || $senha === "") {
        	die("Preencha todos os campos.");
    	}

    //verifica se usuário ou e-mail já existem
    	$sql = "SELECT id FROM users WHERE user = ? OR email = ?";
    	$stmt = $conn->prepare($sql);
    	$stmt->bind_param("ss", $user, $email);
    	$stmt->execute();

	    $resultado = $stmt->get_result();

    	if ($resultado->num_rows > 0) {
        	die("Usuário ou e-mail já cadastrado.");
    	}

    //cria o hash da senha
    	$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    //cadastra o usuário
    	$sql = "INSERT INTO users (user, email, hash_senha)
            VALUES (?, ?, ?)";

    	$stmt = $conn->prepare($sql);
    	$stmt->bind_param("sss", $user, $email, $senhaHash);
    	$stmt->close();
	}
	$conn->close();
?>
