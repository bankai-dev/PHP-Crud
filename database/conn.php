<?php
$hostname = "localhost";
$bancodedados = "tarefas";
$usuario = "root";
$senha = "123456";

// Conectando com o banco de dados
$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
if ($mysqli->connect_errno) {
    echo "falha ao conectar:(" . $mysqli->connect_errno . ")" .$mysqli->connect_errno;

   }
?>