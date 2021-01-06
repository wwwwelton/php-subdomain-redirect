<?php

session_start();
$_SESSION["loterj"] = isset($_SESSION["loterj"]) ? $_SESSION["loterj"] : '';

if($_SESSION["loterj"] == 'logado') {
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Página Inicial</title>
</head>

<body>
        <div class="container"> 
        <div class="col-6 mx-auto py-3">
            <form action="login.php" method="post">          
                <button class="btn btn-danger btn-lg btn-block">Sair</button>                
            </form>
        </div>       
          <div class="jumbotron">
            <div class="row">
                <h2>Redirect Center <span class="badge badge-secondary">v 1.0.0 loterj.rio.br</span></h2>
            </div>       
          </div>
            </br>
            <div class="row">
                <p>
                    <a href="create.php" class="btn btn-success">Adicionar</a>
                </p>
                <form action="./pesquisa.php">
                    <div class="form-row ml-5">
                        <div class="col">
                            <input type="text" size="50" class="form-control" placeholder="Pesquisar" name="search">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Pesquisar</button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Subdominio</th>
                            <th scope="col">URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'banco.php';
                        $pdo = Banco::conectar();
                        $sql = 'SELECT * FROM pessoa ORDER BY id DESC';

                        foreach($pdo->query($sql)as $row)
                        {
                            echo '<tr>';
			                      echo '<th scope="row">'. $row['id'] . '</th>';
                            echo '<td><strong>'. $row['subdominio'] . '</strong>.loterj.rio.br</td>';
                            echo '<td>'. $row['url'] . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn btn-primary" href="read.php?id='.$row['id'].'">Info</a>';
                            echo ' ';
                            echo '<a class="btn btn-warning" href="update.php?id='.$row['id'].'">Atualizar</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Excluir</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        Banco::desconectar();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>

<?php
} else {
    session_start();
    $_SESSION["loterj"] = 'deslogado';
    header('Location: login.php');
}
?>