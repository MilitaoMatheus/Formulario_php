<?php

    require __DIR__ . '/conexao.php';
    header('Content-Type: application/json; charset=utf-8');

    $data = json_decode(file_get_contents('php://input'), true);

    if(
        !$data ||
        empty($data['cpf']) ||
        empty($data['nome']) ||
        empty($data['email']) ||
        empty($data['senha']) ||
        empty($data['confirmarSenha']) ||
        empty($data['telefone']) ||
        empty($data['data'])
    ){
        http_response_code(400);
        echo json_encode(['erro' => 'Preencha todos os campos corretamente']);
        exit;
    }

    $cpf = trim($data['cpf']); 
    $nome = trim($data['nome']); 
    $email = trim($data['email']);
    $senha = trim($data['senha']);
    $confSenha = trim($data['confirmarSenha']);
    $telefone = trim($data['telefone']);
    $dataNasc = trim($data['data']);
    $msgErros = [];
    
    //If em uma única linha. Utilizei para não ocupar tantas linhas de código
    if(!filter_var($email, FILTER_VALIDATE_EMAIL,)) $msgErros[] = "Insira seu email corretamente";
    if($senha !== $confSenha) $msgErros[] = "As senhas não coincidem";
    //Adicionando uma validaão de REGEX ao telefone
    if(!preg_match("/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/", $telefone)) {
        $msgErros[] = "Insira seu telefone corretamente (ex: (11) 99999-9999)";
    }
    //Validação da data de nascimento (um pouco mais extensa)
    if(empty($dataNasc)){
        $msgErros[] = "A data de nascimento é obrigatória";
    } elseif(!strtotime($dataNasc)){
        $msgErros[] = "Data de nascimento inválida";
    }

    if (!empty($msgErros)) {
        http_response_code(400);
        echo json_encode(['erros' => $msgErros]);
        exit;
    }
    
    try{
        $verificar = $cn->prepare("select CPF, email_usuario from tbl_usuario where CPF = :cpf OR email_usuario = :email");
        $verificar->execute([':cpf' => $cpf, ':email' => $email]);
        $existe = $verificar->fetch(PDO::FETCH_ASSOC);

        if($existe){
            if($existe['CPF'] === $cpf) $msgErros[] = "CPF já cadastrado";
            if($existe['email_usuario'] === $email) $msgErros[] = "Email já cadastrado";
        }

        if(!empty($msgErros)){
            http_response_code(400);
            echo json_encode(['erros' => $msgErros]);
            exit;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $incluir = $cn->prepare("insert into tbl_usuario(CPF, nome_usuario, email_usuario, data_nasc, senha)
            values(:cpf, :nome, :email, :dataNasc, :senha)
        ");
        $incluir->execute([
            ':cpf' => $cpf,
            ':nome' => $nome,
            ':email' => $email,
            ':dataNasc' => $dataNasc,
            ':senha' => $senhaHash
        ]);
        echo json_encode(['status' => 'ok', 'mensagem' => 'Cliente cadastrado com sucesso!']);
    } catch(PDOException $e){
        http_response_code(500);
        echo json_encode(['erro' => 'Erro no servidor: ' . $e->getMessage()]);
    }
?>