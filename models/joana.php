<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joana || Tela Principal</title>
</head>
<body>
    <?php
        include 'conexao.php';

        $consulta = $cn->query('select * from tbl_usuario');
    ?>
    <div class="dados">
        <?php while($exibe = $consulta->fetch(PDO::FETCH_ASSOC)){
            echo $exibe['nome_usuario'];
            echo '<br>';
            echo $exibe['email_usuario'];
            echo '<br>';
            echo $exibe['data_nasc'];
            echo '<br>';
        } 
        ?>
    </div>
</body>
</html>