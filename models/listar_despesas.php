<?php
    session_start();
    require __DIR__ . '/conexao.php';
    header('Content-Type: application/json; charset=utf-8');

    if (!isset($_SESSION['id_usuario'])) {
        http_response_code(401);
        echo json_encode(['erro' => 'Sessão expirada.']);
        exit;
    }

    $idUsuario = $_SESSION['id_usuario'];

    try {
        $sql = "select 
                    d.id_despesa,
                    d.valor,
                    d.data_pagamento,
                    td.nome_despesa as categoria,
                    td.id_tipo_despesa,
                    tp.id_tipo_pagamento,
                    tp.metodo_pagamento
                from tbl_despesa d
                inner join tbl_tipo_despesa td on d.id_tipo_despesa = td.id_tipo_despesa
                left join tbl_pagamento p on d.id_despesa = p.id_despesa
                left join tbl_tipo_pagamento tp on p.id_tipo_pagamento = tp.id_tipo_pagamento
                where d.id_usuario = :usuario
                order by d.data_pagamento desc";

        $stmt = $cn->prepare($sql);
        $stmt->bindParam(':usuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        $despesas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($despesas ?: []);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao buscar despesas: ' . $e->getMessage()]);
    }
?>
