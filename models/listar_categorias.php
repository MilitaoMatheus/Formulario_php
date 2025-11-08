<?php
    require __DIR__ . '/conexao.php';
    header('Content-Type: application/json; charset=utf-8');

    try {
        $stmt = $cn->query("
            select id_tipo_despesa, nome_despesa 
            from tbl_tipo_despesa 
            order by nome_despesa ASC
        ");
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($categorias);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao buscar categorias: ' . $e->getMessage()]);
    }
?>
