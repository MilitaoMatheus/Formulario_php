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
        $sql = "
            SELECT 
                r.id_receita,
                r.valor,
                r.data_recebimento,
                c.nome_receita AS categoria
            FROM tbl_receita r
            INNER JOIN tbl_tipo_receita c ON r.id_tipo_receita = c.id_tipo_receita
            WHERE r.id_usuario = :usuario
            ORDER BY r.data_recebimento DESC
        ";
        
        $stmt = $cn->prepare($sql);
        $stmt->bindParam(':usuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        
        $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($receitas ?: []);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao buscar receitas: ' . $e->getMessage()]);
    }
?>
