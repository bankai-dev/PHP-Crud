<?php
session_start();
include('../database/conn.php');

$nome = "";
$custo = "";
$data_limite = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"];
    $custo = $_POST["custo"];
    $data_limite = $_POST["data_limite"];

    if (empty($nome) || empty($custo) || empty($data_limite)) {
        $errorMessage = "Todos os campos são de preenchimento obrigatório";
    } else {
        // adicionar uma nova tarefa ao banco de dados
        $sql = "INSERT INTO tarefas (nome, custo, data_limite, ordem_apresentacao) " .
            "VALUES ('$nome', '$custo', '$data_limite', 0)";
        $result = $mysqli->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        } else {
            // Obter o próximo valor para ordem_apresentacao
            $sql = "SELECT MAX(ordem_apresentacao) AS max_ordem FROM tarefas";
            $result = $mysqli->query($sql);
            $row = $result->fetch_assoc();
            $nextOrder = $row['max_ordem'] + 1;

            // Atualizar a ordem_apresentacao com o próximo valor
            $sql = "UPDATE tarefas SET ordem_apresentacao = $nextOrder WHERE nome = '$nome'";
            $result = $mysqli->query($sql);

            // Redirecionar para o index.php após a inserção e atualização
            //header("Location: ./index.php");
            //exit;

            //Mensagem de sucesso anterior
            
            //$successMessage = "Tarefa adicionada com sucesso";
            //$_SESSION['successMessage'] = $successMessage;

            //header("Location: ./index.php");
            //exit;

            echo ("<script type='text/javascript'>
                    alert('Tarefa adicionada com sucesso');
                    window.location.href='../index.php';
                </script>");

            exit;
        }
    }
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>