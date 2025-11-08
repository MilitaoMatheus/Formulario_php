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
    $idDespesa = intval($data['id'] ?? $data['id_despesa'] ?? 0);
    $valor = floatval($data['valor'] ?? 0);
    $idTipoDespesa = intval($data['categoria'] ?? $data['id_tipo_despesa'] ?? 0);
    $dataPagamento = trim($data['data'] ?? $data['data_pagamento'] ?? '');
    $idTipoPagamento = intval($data['pagamento'] ?? $data['id_tipo_pagamento'] ?? 0);

    if ($idDespesa <= 0 || 
        $valor <= 0 || 
        empty($dataPagamento) ||
        $idTipoDespesa <= 0) 
    {
        http_response_code(400);
        echo json_encode(['erro' => 'Dados inválidos ou incompletos.']);
        exit;
    }

    try {
        $stmt = $cn->prepare("
            update tbl_despesa 
            set id_tipo_despesa = :tipo, valor = :valor, data_pagamento = :data
            where id_despesa = :id and id_usuario = :usuario
        ");

        $stmt->execute([
            ':tipo' => $idTipoDespesa,
            ':valor' => $valor,
            ':data' => $dataPagamento,
            ':id'   => $idDespesa,
            ':usuario' => $idUsuario
        ]);

        if ($idTipoPagamento > 0) {
            $check = $cn->prepare("select id_pagamento from tbl_pagamento where id_despesa = :id");
            $check->execute([':id' => $idDespesa]);

            if ($check->rowCount() > 0) {
                $stmtPag = $cn->prepare("
                update tbl_pagamento 
                SET id_tipo_pagamento = :tipo_pag, valor = :valor, data_pagamento = :data
                where id_despesa = :id");
            } else {
                $stmtPag = $cn->prepare("
                insert into tbl_pagamento (id_despesa, id_tipo_pagamento, valor, data_pagamento)
                values (:id, :tipo_pag, :valor, :data)");
            }

            $stmtPag->execute([
                ':id' => $idDespesa,
                ':tipo_pag' => $idTipoPagamento,
                ':valor' => $valor,
                ':data' => $dataPagamento
            ]);
        }

        echo json_encode(['status' => 'ok', 'mensagem' => 'Despesa alterada com sucesso!']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro no servidor: ' . $e->getMessage()]);
    }

?>