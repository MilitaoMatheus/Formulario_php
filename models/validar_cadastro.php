<?php
    include 'conexao.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = htmlspecialchars(trim($_POST["nome"]));
        $cpf = htmlspecialchars(trim($_POST["cpf"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $senha = htmlspecialchars(trim($_POST["senha"]));
        $confSenha = htmlspecialchars(trim($_POST["confirmarSenha"]));
        $telefone = htmlspecialchars(trim($_POST["telefone"]));
        $dataNasc = htmlspecialchars(trim($_POST["data"]));
        $msgErros = [];

        //Verificando se o CPF cadastrado já está presente no banco de dados
        $consultaCpf = $cn->query("select CPF from tbl_usuario where CPF = '$cpf'");
        $exibeCpf = $consultaCpf->fetch(PDO::FETCH_ASSOC); 

        //Verificando se o email cadastrado já está presente no banco de dados
        $consultaEmail = $cn->query("select email_usuario from tbl_usuario where email_usuario = '$email'");
        $exibeEmail = $consultaEmail->fetch(PDO::FETCH_ASSOC);

        //Verificando se o telefone já cadastrado já está presente no banco de dados
        // $consultaTel = $cn->query("select telefone from tbl_usuario where telefone = '$telefone'");
        // $exibeTel = $consultaTel->fetch(PDO::FETCH_ASSOC);

        //If em uma única linha. Utilizei para não ocupar tantas linhas de código
        if(empty($nome))$msgErros[] = "Insira seu nome corretamente";
        if(!filter_var($email, FILTER_VALIDATE_EMAIL,)) $msgErros[] = "Insira seu email corretamente";
        if($senha !== $confSenha) $msgErros[] = "As senhas não coincidem";
        //Adicionando uma validaão de REGEX ao telefone
        if(!preg_match("/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/", $telefone)) {
            $msgErros[] = "Insira seu telefone corretamente (ex: (11) 99999-9999)";
        }
        
        if($exibeCpf){
            $msgErros[] = "CPF já cadastrado";
        }

        if($exibeEmail){
            $msgErros[] = "Email já cadastrado";
        }

        // if($exibeTel){
        //     $msgErros[] = "Telefone já cadastrado";
        // }

        //Validação da data de nascimento (um pouco mais extensa)
        if(empty($dataNasc)){
            $msgErros[] = "A data de nascimento é obrigatória";
        } elseif(!strtotime($dataNasc)){
            $msgErros[] = "Data de nascimento inválida";
        }

        if(empty($msgErros)){
            $incluir = $cn->query("insert into tbl_usuario(CPF, nome_usuario, email_usuario, data_nasc, senha)
            values('$cpf', '$nome', '$email', '$dataNasc', '$senha')");
            header("Location: sucesso.php");
        } else {
            echo "<div class='erro'>";
            foreach ($msgErros as $erro) {
                echo "<p>$erro</p>";
            }
            echo "</div>";
            echo '<a href="../index.html">Voltar</a>';
        }

    } else{
        header("Location: sucesso.php");
        exit();
    }

?>