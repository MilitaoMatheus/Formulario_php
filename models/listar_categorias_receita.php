<?php
    require __DIR__ . '/conexao.php';
    header('Content-Type: application/json; charset=utf-8');

    try {
        $stmt = $cn->query("
            select id_tipo_receita, nome_receita as nome_tipo_receita
            from tbl_tipo_receita 
            order by nome_receita
        ");
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($categorias);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao buscar categorias: ' . $e->getMessage()]);
    }
?>
