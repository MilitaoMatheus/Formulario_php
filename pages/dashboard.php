<?php
    session_start();
    if(!isset($_SESSION['id_usuario'])){
        header('Locarion: login_usuario.html');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Joana</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="logo">Joana</div>
        <ul class="nav-links">
            <li><a href="menu.php">Início</a></li>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="#" id="btnLogout">Sair</a></li>
        </ul>
    </nav>

    <main class="dashboard-container">
        <section class="cards">
            <div class="card receita">
                <h3>Receitas</h3>
                <p id="totalReceitas">R$ 0,00</p>
            </div>
            <div class="card despesa">
                <h3>Despesas</h3>
                <p id="totalDespesas">R$ 0,00</p>
            </div>
            <div class="card saldo">
                <h3>Saldo Atual</h3>
                <p id="saldoTotal">R$ 0,00</p>
            </div>
        </section>

        <section class="grafico-container">
            <canvas id="graficoPizza"></canvas>
        </section>
    </main>

    <footer class="rodape">
        <p>&copy; <?php echo date('Y'); ?> Sistema Joana — Todos os direitos reservados.</p>
    </footer>

<script src="../script/dashboard.js"></script>
<script src="../script/logout.js"></script>
</body>
</html>