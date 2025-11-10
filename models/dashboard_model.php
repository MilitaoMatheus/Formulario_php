<?php
    session_start();
    require __DIR__ . '/conexao.php';
    header('Content-Type: application/json; charset=utf-8');

    if(!isset($_SESSION['id_usuario'])){
        http_response_code(401);
        echo json_encode(['erro' => 'Sessão exprada']);
        exit;
    }

    $idUsuario = $_SESSION['id_usuario'];

    try{
        //receitas
        $stmtReceita = $cn->prepare("select coalesce(sum(valor), 0) as total_receitas from tbl_receita where id_usuario = :id");
        $stmtReceita->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmtReceita->execute();
        $receita = $stmtReceita->fetch(PDO::FETCH_ASSOC);

        //Despesas
        $stmtDespesa = $cn->prepare("select coalesce(sum(valor), 0) as total_despesas from tbl_despesa where id_usuario = :id");
        $stmtDespesa->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmtDespesa->execute();
        $despesa = $stmtDespesa->fetch(PDO::FETCH_ASSOC);

        $totalReceitas = $receita['total_receitas'];
        $totalDespesas = $despesa['total_despesas'];

        $saldoTotal = $totalReceitas - $totalDespesas;

        echo json_encode([
            'total_receitas' => $totalReceitas,
            'total_despesas' => $totalDespesas,
            'saldo_total' => $saldoTotal
        ]);
    } catch(PDOException $e){
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao carregar dashboard: ' . $e->getMessage()]);
    }
?>