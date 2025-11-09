<?php
    session_start();
    require __DIR__ . '/conexao.php';
    header('Content-Type: application/json; charset=utf-8');

    if (!isset($_SESSION['id_usuario'])) {
        http_response_code(401);
        echo json_encode(['erro' => 'Sessão expirada.']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    $idUsuario = $_SESSION['id_usuario']; //v
    $idReceita = intval($data['id'] ?? $data['id_receita'] ?? 0);
    $valor = floatval($data['valor'] ?? 0); //v
    $idTipoReceita = intval($data['categoria'] ?? $data['id_tipo_receita'] ?? 0);
    $dataRecebimento = trim($data['data'] ?? $data['data_recebimento'] ?? '');

    if ($idReceita <= 0 || 
        $valor <= 0 || 
        empty($dataRecebimento) ||
        $idTipoReceita <= 0) 
    {
        http_response_code(400);
        echo json_encode(['erro' => 'Dados inválidos ou incompletos.']);
        exit;
    }

    try {
        $stmt = $cn->prepare("
            update tbl_receita
            set id_tipo_receita = :tipo, valor = :valor, data_recebimento = :data
            where id_receita = :id and id_usuario = :usuario
        ");

        $stmt->execute([
            ':tipo' => $idTipoReceita,
            ':valor' => $valor,
            ':data' => $dataRecebimento,
            ':id'   => $idReceita,
            ':usuario' => $idUsuario
        ]);

        echo json_encode(['status' => 'ok', 'mensagem' => 'Despesa alterada com sucesso!']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro no servidor: ' . $e->getMessage()]);
    }

?>