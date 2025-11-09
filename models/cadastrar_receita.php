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

    $idUsuario = $_SESSION['id_usuario'];
    $valor = floatval($data['valor'] ?? 0);
    $idTipoReceita = intval($data['categoria'] ?? 0);
    $dataRecebimento = trim($data['data'] ?? '');

    if ($valor <= 0 || $idTipoReceita  <= 0 || empty($dataRecebimento)) {
        http_response_code(400);
        echo json_encode(['erro' => 'Dados inválidos ou incompletos.']);
        exit;
    }

    try {
        $stmt = $cn->prepare("
            insert into tbl_receita (id_usuario, id_tipo_receita, valor, data_recebimento) 
            values (:usuario, :tipo, :valor, :data)
        ");

        $stmt->execute([
            ':usuario' => $idUsuario,
            ':tipo' => $idTipoReceita ,
            ':valor' => $valor,
            ':data' => $dataRecebimento
        ]);

        echo json_encode(['status' => 'ok', 'mensagem' => 'Despesa cadastrada com sucesso!']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro no servidor: ' . $e->getMessage()]);
    }
?>