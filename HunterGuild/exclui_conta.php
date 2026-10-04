<?php
	session_start();

	require_once "conexao.php";

	$user_id = $_SESSION["usuario_id"];
	if (!isset($_SESSION["usuario_id"])) {
	    die("Você precisa estar logado para excluir sua conta.");
	}
	

	if ($_SERVER["REQUEST_METHOD"] === "POST") {

    	$sql = "DELETE FROM users WHERE id = ?";
    	$stmt = $conn->prepare($sql);
    	$stmt->bind_param("i", $user_id);

	    if ($stmt->execute()) {
        	$_SESSION = [];
        	session_destroy();

        	header("Location: index.php");
        	exit;
    	} else {
        	echo "Erro ao excluir a conta.";
    	}
    	$stmt->close();
	}
	$conn->close();
?>
