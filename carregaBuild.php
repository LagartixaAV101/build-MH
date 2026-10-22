
<?php
session_start();

header("Content-Type: application/json; charset=utf-8");

if (!isset($_SESSION["usuario_id"])) {
    http_response_code(401);
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Você precisa estar logado."
    ]);
    exit;
}

$idBuild = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$idBuild || $idBuild < 1) {
    http_response_code(400);
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID da build inválido."
    ]);
    exit;
}

require_once "conexao.php";

$usuarioId = (int) $_SESSION["usuario_id"];

try {
    // Verifica se a build pertence ao usuário.
    $sql = "SELECT id FROM builds WHERE id = ? AND user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idBuild, $usuarioId);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if (!$resultado->fetch_assoc()) {
        http_response_code(404);
        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Build não encontrada."
        ]);
        exit;
    }

    $stmt->close();

    // Inicializa todos os espaços da build.
    $equipamentos = [
        "weapon" => null,
        "head" => null,
        "chest" => null,
        "arms" => null,
        "waist" => null,
        "legs" => null
    ];

    // Recupera os equipamentos salvos.
    $sql = "SELECT equipment_slot, equipment_id FROM equip_build WHERE build_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idBuild);
    $stmt->execute();

    $resultado = $stmt->get_result();

    while ($linha = $resultado->fetch_assoc()) {
        $tipo = $linha["equipment_slot"];

        if (array_key_exists($tipo, $equipamentos)) {
            $equipamentos[$tipo] = (int) $linha["equipment_id"];
        }
    }

    $stmt->close();

    echo json_encode([
        "sucesso" => true,
        "equipamentos" => $equipamentos
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    error_log("Erro ao carregar build: " . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao carregar a build."
    ]);
}
?>
