<?php
    session_start();
    require __DIR__ . '/conexao.php';
    header('Content-Type: application/json; charset=utf-8');

    if (!isset($_SESSION['id_usuario'])) {
        http_response_code(401);
        echo json_encode(['erro' => 'Sessão expirada']);
        exit;
    }

    $idUsuario = $_SESSION['id_usuario'];

    try {
        $sql = "
            select 
                nome_usuario,
                email_usuario,
                data_nasc
            from tbl_usuario
            where id_usuario = :id
            limit 1;
        ";

        $stmt = $cn->prepare($sql);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            echo json_encode($usuario);
        } else {
            echo json_encode(['erro' => 'Usuário não encontrado']);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao buscar perfil: ' . $e->getMessage()]);
    }
?>
