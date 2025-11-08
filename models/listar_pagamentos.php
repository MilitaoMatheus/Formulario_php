<?php
    require __DIR__ . '/conexao.php';
    header('Content-Type: application/json; charset=utf-8');

    try {
        $stmt = $cn->query("select id_tipo_pagamento, metodo_pagamento from tbl_tipo_pagamento order by metodo_pagamento asc");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao listar métodos de pagamento: ' . $e->getMessage()]);
    }

?>