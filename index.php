<!DOCTYPE html>
<html lang="pt-br">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Tarefas</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="./script/subir-descer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Lista de tarefas</h2>
        <br>
        <table class="table" id="task-list">
            <thead>
                <tr>
                    <th>id</th>
                    <th>nome</th>
                    <th>custo</th>
                    <th>data_limite</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('./database/conn.php');

                $sql = "SELECT *, ordem_apresentacao FROM tarefas ORDER BY ordem_apresentacao";
                $result = $mysqli->query($sql);

                if (!$result) {
                    die("Invalid query: " . $mysqli->error);
                }

                while ($row = $result->fetch_assoc()) {
                    $class = "";
                    if ($row["custo"] >= 1000) {
                        $class = "table-warning";
                    }
                    $index = $row["ordem_apresentacao"];
                    echo "
                        <tr class='table-row $class draggable-row' id='task-$index' draggable='true' data-index='$index' data-id='$row[id]'>
                            <th>$row[id]</th>
                            <td>$row[nome]</td>
                            <td>$row[custo]</td>
                            <td>$row[data_limite]</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='../src/edit.php?id=$row[id]'>Editar</a>
                                <a class='btn btn-danger btn-sm delete-task-button' data-task-id='$row[id]' href='#'>Deletar</a>
                            </td>
                        </tr>
                    ";
                }

                ?>
            </tbody>   
        </table>
    </div>
    <div class="container">
        <a class="btn btn-primary btn-incluir" href="./src/create.php" role="button">Incluir</a>
    </div>
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirmação de Exclusão</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja excluir esta tarefa?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteButton">Excluir</button>
                        </div>
                    </div>
                </div>
            </div>
</body>

</html>