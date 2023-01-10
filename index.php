<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Tarefas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="subir-descer.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Lista de tarefas</h2>
        <a class="btn btn-primary" href="/lista--tarefas/create.php" role="button">Nova Tarefa</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>nome</th>
                    <th>custo</th>
                    <th>data_limite</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $hostname = "localhost";
            $bancodedados = "tarefas";
            $usuario = "root";
            $senha = "";

            // Conectando com o banco de dados
             $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
            if ($mysqli->connect_errno) {
             echo "falha ao conectar:(" . $mysqli->connect_errno . ")" .$mysqli->connect_errno;

            }

            $sql = "SELECT * FROM tarefas";
            $result = $mysqli->query($sql);

            if (!$result) {
                die("Invalid query: " . $mysqli->error);
            }

            while($row = $result->fetch_assoc()){
                $class = "";
                if ($row["custo"] >= 1000) {
                    $class = "table-warning";
                }
                echo "
                <tr class='$class' draggable='true' ondragstart='drag(event)' ondrop='drop(event)'>
                    <th>$row[ID]</th>
                    <th>$row[nome]</th>
                    <th>$row[custo]</th>
                    <th>$row[data_limite]</th>
                    <td>
                        <a class='btn btn-primary btn-sm' href='/lista--tarefas/edit.php?ID=$row[ID]'>Editar</a>
                        <a class='btn btn-danger btn-sm' href='/lista--tarefas/delete.php?ID=$row[ID]'>Deletar</a>
                    </td>
                    <td>
                        <button class='btn btn-primary btn-sm' onclick='moveUp($row[ID])'>Subir</button>
                        <button class='btn btn-primary btn-sm' onclick='moveDown($row[ID])'>Descer</button>                    
                    </td>
                </tr>
                ";
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID']) && isset($_POST['direction'])) {
                header('Content-Type: application/json');
                //Continua o código
            } else {
                //Retorna um erro   
                echo json_encode(array('error' => 'Invalid request'));
                exit();
            }
            
            $id = $_POST['ID'];
            $direction = $_POST['direction'];
            $sql = "SELECT ordem FROM tarefas WHERE ID = $id";
            $result = $mysqli->query($sql);
            $task = $result->fetch_assoc();
            $currentPosition = $task['ordem'];

            if ($direction === 'up') {
                $sql = "UPDATE tarefas SET ordem = $currentPosition-1 WHERE ordem = $currentPosition-1";
                $sql2 = "UPDATE tarefas SET ordem = $currentPosition-1 WHERE ID = $id";
            } else {
                $sql = "UPDATE tarefas SET ordem = $currentPosition+1 WHERE ordem = $currentPosition+1";
                $sql2 = "UPDATE tarefas SET ordem = $currentPosition+1 WHERE ID = $id";
            }

            $result = $mysqli->query($sql);
            $result = $mysqli->query($sql2);

            if (!$result) {
                die(json_encode(array('error' => 'Failed to move task in the database: ' . $mysqli->error)));
            }
            echo json_encode(array('success' => 'Task moved successfully!'));
                                        
            ?>
                
            </tbody>
        </table>
    </div>
</body>
</html>
