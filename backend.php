<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $mensagemUser = "";
        $nome = $_POST["nome"] ?? '';
        $email = $_POST["email"] ?? '';
        $senha = $_POST["senha"] ?? '';

        if(empty($nome) || empty($email) || empty($senha)){
            $mensagemUser = "Não deixe os campos vazios!";
            header('location: backend.php');
            exit();
        } else {
            header('location: sucesso.php');
            exit();
        }
    }
?>

<?php if (!empty($mensagemUser)): ?>
    <p><?php echo $mensagemUser; ?></p>
<?php endif; ?>