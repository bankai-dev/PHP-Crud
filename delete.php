<?php
if ( isset($_GET["ID"]) ) {
    $ID = $_GET["ID"];

    $hostname = "localhost";
    $bancodedados = "tarefas";
    $usuario = "root";
    $senha = "";

    // Conectando com o banco de dados
    $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

    $sql = "DELETE FROM tarefas WHERE ID=$ID";
    $mysqli->query($sql);
}

header("location: /lista--tarefas/index.php");
exit;
?>