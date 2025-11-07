<?php
    session_start();
    if(!isset($_SESSION['id_usuario'])){
        header('Location: login_usuario.html');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu || Joana</title>
</head>
<body>
    <h1>login</h1>
    <button id="btnLogout">Sair</button>

<script src="../script/logout.js"></script>
</body>
</html>
