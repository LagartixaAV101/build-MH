<?php
	require_once "conexao.php";

	header("Content-Type: application/json; charset=utf-8");

	try{
		$sql = "
	    	SELECT
	        	e.id,
	        	e.nome,
	        	a.armor_type,
	        	a.defesa,
	        	a.fogo,	
	        	a.agua,
	        	a.trovao,
	        	a.gelo,
	        	a.dragao
    		FROM equipamentos e	INNER JOIN armadura a ON a.equip_id = e.id 
    		ORDER BY a.armor_type, e.nome";
			
		$resultado = $conn->query($sql);
	
	$armaduras = [];	
	
	while ($linha = $resultado->fetch_assoc()) {
	    $armaduras[] = $linha;
	}

	echo json_encode($armaduras);
	
	}catch (mysqli_sql_exception $e) {
	    http_response_code(500);
	
	    echo json_encode(["erro" => "Erro ao buscar as armaduras."]);
	}
?>
