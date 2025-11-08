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
    <link rel="stylesheet" href="../css/menu.css">
    <title>Menu || Joana</title>
</head>
<body>
    <nav class="navbar">
        <div class="logo">Joana</div>
        <ul class="nav-links">
            <li><a href="menu.php">Início</a></li>
            <li><a href="#">Perfil</a></li>
            <li><a href="#">Configurações</a></li>
            <li><a href="#" id="btnLogout">Sair</a></li>
        </ul>
    </nav>

    <section class="conteudo">
        <h1>Bem-vindo ao sistema, <?php echo $_SESSION['nome_usuario']; ?>!</h1>
        <p>Selecione uma opção abaixo para navegar:</p>

        <div class="cards-container">
            <div class="card">
                <h2>Registrar Receita</h2>
                <p>Adicione novas receitas ao sistema.</p>
                <a href="#" class="btn-card">Acessar</a>
            </div>

            <div class="card">
                <h2>Registrar Despesa</h2>
                <p>Adicione novas despesas ao sistema.</p>
                <a href="despesas.php" class="btn-card">Acessar</a>
            </div>

            <div class="card">
                <h2>Relatórios</h2>
                <p>Veja estatísticas e dados importantes.</p>
                <a href="#" class="btn-card">Acessar</a>
            </div>
        </div>
    </section>

<footer class="rodape">
    <p>&copy; <?php echo date('Y'); ?> Sistema Joana — Todos os direitos reservados.</p>
</footer>

<script src="../script/logout.js"></script>
</body>
</html>
