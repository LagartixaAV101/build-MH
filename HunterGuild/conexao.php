<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$servidor = "localhost";
	$usuario = "root";
	$senha = "";
	$banco = "mhWilds";

	$conn = new mysqli(
	    $servidor,
	    $usuario,
	    $senha,
	    $banco
	);

	if ($conn->connect_error) {
	    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
	}

	$conn->set_charset("utf8mb4");
?>
