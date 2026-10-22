<?php
	require_once "conexao.php";

	header("Content-Type: application/json; charset=utf-8");

	try{
		$sql = "
	    	SELECT
	        	e.id,
	        	e.nome,
	        	a.tipo_arma,
	        	a.ataque,
	        	a.afinidade,
	        	a.bonus_defesa,
	        	a.elderseal
    		FROM equipamentos e	INNER JOIN armas a ON a.equip_id = e.id 
    		ORDER BY a.tipo_arma, e.nome";
			
		$resultado = $conn->query($sql);
	
	$armas = [];	
	
	while ($linha = $resultado->fetch_assoc()) {
	    $armas[] = $linha;
	}

	echo json_encode($armas);
	
	}catch (mysqli_sql_exception $e) {
	    http_response_code(500);
	
	    echo json_encode(["erro" => "Erro ao buscar as armas."]);
	}
?>
