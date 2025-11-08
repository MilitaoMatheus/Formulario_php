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
    $idTipoDespesa = intval($data['categoria'] ?? 0);
    $dataPagamento = trim($data['data'] ?? '');
    $idTipoPagamento = intval($data['pagamento'] ?? 0);

    if ($valor <= 0 || $idTipoDespesa <= 0 || empty($dataPagamento)) {
        http_response_code(400);
        echo json_encode(['erro' => 'Dados inválidos ou incompletos.']);
        exit;
    }

    try {
        $stmt = $cn->prepare("
            insert into tbl_despesa (id_usuario, id_tipo_despesa, valor, data_pagamento) 
            values (:usuario, :tipo, :valor, :data)
        ");

        $stmt->execute([
            ':usuario' => $idUsuario,
            ':tipo' => $idTipoDespesa,
            ':valor' => $valor,
            ':data' => $dataPagamento
        ]);

        $idDespesa = $cn->lastInsertId();

        if ($idTipoPagamento > 0) {
            $stmtPag = $cn->prepare("
                insert into tbl_pagamento (id_despesa, id_tipo_pagamento, valor, data_pagamento)
                values (:idDespesa, :tipoPag, :valor, :data)
            ");
            
            $stmtPag->execute([
                ':idDespesa' => $idDespesa,
                ':tipoPag' => $idTipoPagamento,
                ':valor' => $valor,
                ':data' => $dataPagamento
            ]);
        }

        echo json_encode(['status' => 'ok', 'mensagem' => 'Despesa cadastrada com sucesso!']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro no servidor: ' . $e->getMessage()]);
    }
?>
