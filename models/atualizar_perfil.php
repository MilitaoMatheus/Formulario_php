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

    $dados = json_decode(file_get_contents("php://input"), true);

    if (!$dados || empty($dados['nome_usuario']) || empty($dados['email_usuario'])) {
        echo json_encode(['erro' => 'Dados incompletos.']);
        exit;
    }

    $nome = trim($dados['nome_usuario']);
    $email = trim($dados['email_usuario']);
    $dataNasc = trim($dados['data_nasc']);

    try {
        $sql = "
            update tbl_usuario
            set nome_usuario = :nome, email_usuario = :email, data_nasc = :data_nasc
            where id_usuario = :id
        ";

        $stmt = $cn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nasc', $dataNasc);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['sucesso' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao atualizar o perfil: ' . $e->getMessage()]);
    }
?>
