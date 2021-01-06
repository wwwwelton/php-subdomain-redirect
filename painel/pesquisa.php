<?php

session_start();
$_SESSION["loterj"] = isset($_SESSION["loterj"]) ? $_SESSION["loterj"] : '';

if($_SESSION["loterj"] == 'logado') {
?>

<?php

$search = null;

if (!empty($_GET['search'])) {
    $search  = $_REQUEST['search'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <title>Pesquisa</title>
</head>

<body>
        <div class="container">
          <div class="jumbotron">
            <div class="row">
                <h2>Pesquisa <span class="badge badge-secondary">v 1.0.0 loterj.rio.br</span></h2>
            </div>
          </div>
            </br>
            <div class="row">
                <p>
                    <a href="index.php" class="btn btn-success">Voltar</a>
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
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT * FROM pessoa where subdominio = ?";
                        $q = $pdo->prepare($sql);
                        $q->execute(array($search));
                        $data = $q->fetch(PDO::FETCH_ASSOC);
                        $id = isset($data['id']) ? $data['id'] : '';
                        $subdominio = isset($data['subdominio']) ? $data['subdominio'] : '';
                        $domain = $subdominio !== '' ? ".loterj.rio.br" : "";
                        $url = isset($data['url']) ? $data['url'] : '';

        
                            echo '<tr>';
			                      echo '<th scope="row">'. $id . '</th>';
                            echo '<td><strong>'. $subdominio . '</strong>' . $domain. '</td>';
                            echo '<td>'. $url . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn btn-primary" href="read.php?id='.$id.'">Info</a>';
                            echo ' ';
                            echo '<a class="btn btn-warning" href="update.php?id='.$id.'">Atualizar</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id='.$id.'">Excluir</a>';
                            echo '</td>';
                            echo '</tr>';
          
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