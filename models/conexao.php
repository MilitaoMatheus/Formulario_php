<?php
    $servidor = "localhost";
    $usuario = "root";
    $senha = "12345678";
    $banco = "joana_db";

    $cn = New PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
?>