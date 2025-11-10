<?php
    session_start();
    if(!isset($_SESSION['id_usuario'])){
        header('Location: login_usuario.html');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | Joana</title>
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Joana</div>
        <ul class="nav-links">
            <li><a href="menu.php">Início</a></li>
            <li><a href="perfil.php" class="ativo">Perfil</a></li>
            <li><a href="#">Configurações</a></li>
            <li><a href="#" id="btnLogout">Sair</a></li>
        </ul>
    </nav>

    <main class="perfil-container">
        <section class="perfil-card">
            <h2>Meu Perfil</h2>
            <div id="infoUsuario">
                <p><strong>Nome:</strong> <span id="nomeUsuario">Carregando...</span></p>
                <p><strong>Email:</strong> <span id="emailUsuario">Carregando...</span></p>
                <p><strong>Data de Nascimento:</strong> <span id="nascimentoUsuario">Carregando...</span></p>
            </div>

            <div class="botoes">
                <button id="btnEditar">Editar</button>
                <button id="btnSalvar" class="hidden">Salvar</button>
                <button id="btnCancelar" class="hidden">Cancelar</button>
            </div>
        </section>
    </main>

    <footer class="rodape">
        <p>&copy; <?php echo date('Y'); ?> Sistema Joana — Todos os direitos reservados.</p>
    </footer>

    <script src="../script/mascaras.js"></script>
    <script src="../script/perfil.js"></script>
    <script src="../script/logout.js"></script>
</body>
</html>
