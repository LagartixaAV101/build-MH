<?php

session_start();

header("Content-Type: application/json");

if (!isset($_SESSION["usuario_id"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Você precisa estar logado."
    ]);
    exit;
}

$dados = json_decode(file_get_contents("php://input"), true);

if (!$dados || !isset($dados["nome"]) || !isset($dados["equipamentos"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados inválidos."
    ]);
    exit;
}

$nome = trim($dados["nome"]);
$equipamentos = $dados["equipamentos"];

if ($nome === "") {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "O nome da build não pode estar vazio."
    ]);
    exit;
}

require_once "conexao.php";

$usuario_id = $_SESSION["usuario_id"];

$conn->begin_transaction();

try {

    /*
     * Cria a build
     */
    $sql = "INSERT INTO builds (usuario_id, nome)
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $usuario_id, $nome);
    $stmt->execute();

    $build_id = $conn->insert_id;

    /*
     * Insere os equipamentos
     */
    $sql = "INSERT INTO build_equipment
            (build_id, equipment_id, tipo)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    foreach ($equipamentos as $tipo => $equipment_id) {

        if ($equipment_id === null) {
            continue;
        }

        $equipment_id = intval($equipment_id);

        $stmt->bind_param(
            "iis",
            $build_id,
            $equipment_id,
            $tipo
        );

        $stmt->execute();
    }

    $conn->commit();

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Build salva com sucesso.",
        "build_id" => $build_id
    ]);

} catch (Exception $e) {

    $conn->rollback();

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao salvar a build."
    ]);
}
?>
