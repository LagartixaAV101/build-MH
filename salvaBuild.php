<?php

session_start();

header("Content-Type: application/json; charset=utf-8");

function responder($sucesso, $mensagem, $dados = []){
	echo json_encode(array_merge(["sucesso" => $sucesso, "mensagem" => $mensagem], $dados), JSON_UNESCAPED_UNICODE);
	exit;
}

if (!isset($_SESSION["usuario_id"])) {
    responder(false, "você precisa estar logado.");
}

$dados = json_decode(file_get_contents("php://input"), true);

if (!is_array($dados) || !isset($dados["nome"]) || !isset($dados["equipamentos"]) || !is_array($dados["equipamentos"])) {
    responder(false, "Dados inválidos");
}

$nome = trim($dados["nome"]);
$equipamentos = $dados["equipamentos"];
$usuario_id = (int) $_SESSION["usuario_id"];

$idBuild = null;
if (isset($dados["id"]) && $dados["id"] !== null && $dados["id"] !== "") {
    $idBuild = filter_var(
        $dados["id"],
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    if ($idBuild === false) {
        responder(false, "ID da build inválido.");
    }
}

if ($nome === "") {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "O nome da build não pode estar vazio."
    ]);
    exit;
}

$tiposPermitidos = [
    "weapon",
    "head",
    "chest",
    "arms",
    "waist",
    "legs"
];
foreach ($equipamentos as $tipo => $equipment_id) {
    if (!in_array($tipo, $tiposPermitidos, true)) {
        responder(false, "Tipo de equipamento inválido.");
    }

    if ($equipment_id === null || $equipment_id === "") {
        continue;
    }

    $idValidado = filter_var(
        $equipment_id,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    if ($idValidado === false) {
        responder(false, "ID de equipamento inválido.");
    }

    $equipamentos[$tipo] = $idValidado;
}

require_once "conexao.php";

try{
	$conn->begin_transaction();

	if($idBuild === null){
    /*Cria a build*/
    	$sql = "INSERT INTO builds (user_id, nome) VALUES (?, ?)";

   		$stmt = $conn->prepare($sql);
    	$stmt->bind_param("is", $usuario_id, $nome);
    	$stmt->execute();

    	$build_id = $conn->insert_id;

		$stmt->close();
	}else{
		$sql = "SELECT id FROM builds WHERE id = ? AND usuario_id = ? FOR UPDATE";
		
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ii", $idBuild, $usuario_id);
		$stmt->execute();
		
		$resultado = $stmt->get_result();
		$buildEncontrada = $resultado->fetch_assoc();
		$stmt->close();
		if (!$buildEncontrada) {
			$conn->rollback();
		    responder(false, "Build não encontrada ou você não tem permissão para editá-la.");
		}
	
		$build_id = $idBuild;
    // Atualizar o nome da build existente.
    	$sql = "UPDATE builds SET nome = ? WHERE id = ? AND usuario_id = ?";

    	$stmt = $conn->prepare($sql);
    	$stmt->bind_param("sii", $nome, $build_id, $usuario_id);
    	$stmt->execute();
    	$stmt->close();
 // Remover os equipamentos anteriores.
    	$sql = "DELETE FROM build_equipment WHERE build_id = ?";

    	$stmt = $conn->prepare($sql);
    	$stmt->bind_param("i", $build_id);
    	$stmt->execute();
    	$stmt->close();
	}

    // Inserir os equipamentos atuais.
    $sql = "INSERT INTO equip_build (build_id, equipment_id, equipment_slot) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    foreach ($equipamentos as $tipo => $equipment_id) {
        if ($equipment_id === null || $equipment_id === "") {
            continue;
        }

        $stmt->bind_param(
            "iis",
            $build_id,
            $equipment_id,
            $tipo
        );

        $stmt->execute();
    }

    $stmt->close();

    $conn->commit();

    responder(true, $idBuild === null ? "Build salva com sucesso." : "Build atualizada com sucesso.", ["build_id" => $build_id]);

} catch (Throwable $e) {
    $conn->rollback();

    // Detalhes ficam no log do servidor, não na resposta ao usuário.
    error_log("Erro ao salvar build: " . $e->getMessage());

    responder(false, "Erro ao salvar a build.");
}
?>
