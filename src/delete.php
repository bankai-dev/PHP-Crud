
<?php

include('../database/conn.php');

if ( isset($_GET["id"]) ) {
    $id = $_GET["id"];

    $sql = "DELETE FROM tarefas WHERE id=$id";
    $mysqli->query($sql);
}

header("location: ../index.php");
exit;
?>