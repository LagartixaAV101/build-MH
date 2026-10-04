<?php
	require_once "conexao.php";

	header("Content-Type: application/json; charset=utf-8");

	try{
		$sql = "
	    	SELECT
	        	e.id,
	        	e.nome,
	        	e.raridade,
	        	a.armor_type,
	        	a.defesa,
	        	a.fogo,	
	        	a.agua,
	        	a.trovao,
	        	a.gelo,
	        	a.dragao
    		FROM equipamentos e	
    		INNER JOIN armadura a 
    			ON a.equip_id = e.id 
    		ORDER BY a.armor_type, e.nome";

		$resultado = $conn->query($sql);
	
	$armaduras = [];
	
	while ($linha = $resultado->fetch_assoc()) {
	    $armaduras[] = $linha;
	}
	
	header("Content-Type: application/json; charset=UTF-8");
	
	echo json_encode($armaduras);
?>
