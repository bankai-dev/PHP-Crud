<?php
$hostname = "localhost";
$bancodedados = "tarefas";
$usuario = "root";
$senha = "";

// Conectando com o banco de dados
$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

$nome = "";
$custo = "";
$data_limite = "";

$errorMessage = "";
$sucessMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $nome = $_POST["nome"];
    $custo = $_POST["custo"];
    $data_limite = $_POST["data_limite"];

    do {
        if ( empty($nome) ||  empty($custo) || empty($data_limite) ) {
            $errorMessage = "Todos os campos são de preenchimento obrigatório ";
            break;
        }

        // adicionar uma nova tarefa ao banco de dados
        $sql = "INSERT INTO tarefas (nome, custo, data_limite) " .
               "VALUES ('$nome', '$custo', '$data_limite')";
        $result = $mysqli->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $nome = "";
        $custo = "";
        $data_limite = "";

        $sucessMessage = "Tarefa adicionada com sucesso";

        header("location: /lista--tarefas/index.php");
        exit;

    } while (false);
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
                    <a class="btn btn-outline-primary" href="/lista--tarefas/index.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>