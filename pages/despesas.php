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
    <title>Despesas | Joana</title>
    <link rel="stylesheet" href="../css/despesas.css">
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

    <main>
        <section class="form-section">
            <h2>Cadastrar / Editar Despesa</h2>
            <form id="formDespesas" method="POST">
                <input type="hidden" id="idDespesaEdicao" value="">
                
                <div class="form-group">
                    <label for="valor">Valor (R$):</label>
                    <input type="number" name="valor" id="valor" step="0.01" min="0.01" required>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria:</label>
                    <div class="inline-group">
                        <select name="categoria" id="categoria" required>
                            <option value="">Selecione...</option>
                        </select>
                        <button type="button" id="btnNovaCategoria" class="btn-secundario">+</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pagamento">Método de Pagamento:</label>
                    <select name="pagamento" id="pagamento" required>
                        <option value="">Selecione...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="data">Data:</label>
                    <input type="date" name="data" id="data" required>
                </div>

                <input type="submit" value="Salvar Despesa" class="btn-enviar">
            </form>
        </section>

        <section class="tabela-section">
            <h2>Despesas Recentes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Valor (R$)</th>
                        <th>Data</th>
                        <th>Método</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaDespesas">
                    <tr><td colspan="5">Carregando...</td></tr>
                </tbody>
            </table>
        </section>
    </main>

    <footer class="rodape">
        <p>&copy; <?php echo date('Y'); ?> Sistema Joana — Todos os direitos reservados.</p>
    </footer>

    <script src="../script/logout.js"></script>
    <script src="../script/despesas.js"></script>
</body>
</html>
