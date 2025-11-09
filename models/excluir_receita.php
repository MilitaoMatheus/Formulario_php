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
    $idReceita = intval($data['id'] ?? 0);
    $idUsuario = $_SESSION['id_usuario'];

    if ($idReceita <= 0) {
        http_response_code(400);
        echo json_encode(['erro' => 'ID inválido.']);
        exit;
    }

    try {
        $stmt = $cn->prepare("delete from tbl_receita where id_receita = :id and id_usuario = :usuario");
        $stmt->execute([
            ':id' => $idReceita,
            ':usuario' => $idUsuario
        ]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'ok', 'mensagem' => 'Despesa excluída com sucesso!']);
        } else {
            echo json_encode(['erro' => 'Despesa não encontrada.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro no servidor: ' . $e->getMessage()]);
    }
?>
