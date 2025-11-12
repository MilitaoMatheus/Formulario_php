<?php
    session_start();
    require __DIR__ . '/conexao.php';

    header('Content-Type: application/json; charset=utf-8');

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || empty($data['cpf']) || empty($data['senha'])){
        http_response_code(400);
        echo json_encode(['erro' => 'Preencha todos os campos']);
        exit;
    }

    $cpf = trim($data['cpf']);
    $senha = $data['senha'];

    try{
        $stmt = $cn->prepare("select id_usuario, CPF, nome_usuario, senha from tbl_usuario where CPF = :cpf");
        $stmt->execute([':cpf' => $cpf]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        //if($user && password_verify($senha, $user['senha'])){
        if($user && $senha){
            //Salvando os dados na sessão
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nome_usuario'] = $user['nome_usuario'];
            $_SESSION['cpf'] = $user['CPF'];

            echo json_encode(['status' => 'ok', 'redirect' => '../pages/menu.php']);
        } else {
            http_response_code(401);
            echo json_encode(['erro' => 'CPF ou senha incorretos']);
        }
    } catch (PDOException $e){
        http_response_code(500);
        echo json_encode(['erro' => 'Erro no servidor: ' . $e->getMessage()]);
    }
?>