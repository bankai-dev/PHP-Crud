<?php

include('../database/conn.php');

$id = "";
$nome = "";
$custo = "";
$data_limite = "";

$errorMessage = "";
$sucessMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'GET'){
    // GET method: Mostra os dados das tarefas

    if ( !isset($_GET["id"] )){
        header("location: ../index.php");
        exit;
    }

    $id = $_GET["id"];

    //Faz a leitura da linha da tarefa selecionada no banco de dados 
    $sql = "SELECT * FROM tarefas WHERE id=$id";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: ../index.php");
        exit;
    }

    $nome = $row["nome"];
    $custo = $row["custo"];
    $data_limite = $row["data_limite"];
}
else {
     // POST method: Atualiza os dados das tarefas

    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $custo = $_POST["custo"];
    $data_limite = $_POST["data_limite"];

    do {
        if ( empty($id) || empty($nome) ||  empty($custo) || empty($data_limite) ) {
            $errorMessage = "Todos os campos são de preenchimento obrigatório ";
            break;
        }

        $sql = "UPDATE tarefas " .
                "SET nome = '$nome', custo = '$custo', data_limite= '$data_limite' " .
                "WHERE id = $id"; 

        $result = $mysqli->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query:  " . $mysqli->error;
            break;
        }

        $sucessMessage = "Tarefa atualizada com sucesso";

        header("location: ../index.php");
        exit;
    } while (true);
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Tarefas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Nova Tarefa</h2>

        <?php
        if ( !empty($errorMessage) ) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        
        <form method="post">
            <input type="hidden" name = "id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">nome</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nome" value="<?php echo $nome; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">custo</label>
                <div class="col-sm-6">
                    <input type="" class="form-control" name="custo" value="<?php echo $custo; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">data_limite</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="data_limite" value="<?php echo $data_limite; ?>">
                </div>
            </div>



            <?php
            if ( !empty($sucessMessage) ) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-sucess alert-dismissible fade show' role='alert'>
                            <strong>$sucessMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="../index.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>