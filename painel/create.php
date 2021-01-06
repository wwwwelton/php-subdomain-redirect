<?php

session_start();
$_SESSION["loterj"] = isset($_SESSION["loterj"]) ? $_SESSION["loterj"] : '';

if($_SESSION["loterj"] == 'logado') {
?>

<?php
require 'banco.php';
//Acompanha os erros de validação

// Processar so quando tenha uma chamada post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subdominioErro = null;
    $urlErro = null;

    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM pessoa where subdominio = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($_POST['subdominio']));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $registro = isset($data['subdominio']) ? $data['subdominio'] : '';
    Banco::desconectar();

    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
        
        if ($registro !== '') {
            $subdominioErro = 'Registro já existe!';
            $validacao = False;
        }
        else if (!empty($_POST['subdominio'])) {
            $subdominio = $_POST['subdominio'];
        } else {
            $subdominioErro = 'Por favor digite o subdominio!';
            $validacao = False;
        }


        if (!empty($_POST['url'])) {
            $url = $_POST['url'];
        } else {
            $urlErro = 'Por favor digite a URL de Redirecionamento!';
            $validacao = False;
        }

    }

//Inserindo no Banco:
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO pessoa (subdominio, url) VALUES(?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($subdominio, $url));
        Banco::desconectar();
        header("Location: index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Adicionar Redirecionamento</title>
</head>

<body>
<div class="container">
    <div clas="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> Adicionar Redirecionamento </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="create.php" method="post">

                    <div class="control-group  <?php echo !empty($subdominioErro) ? 'error ' : ''; ?>">
                        <label class="control-label">Nome do subdominio 'nome'.loterj.rio.br</label>
                        <div class="controls">
                            <input size="150" class="form-control" name="subdominio" type="text" placeholder="Nome exemplo: davi"
                                   value="<?php echo !empty($subdominio) ? $subdominio : ''; ?>">
                            <?php if (!empty($subdominioErro)): ?>
                                <span class="text-danger"><?php echo $subdominioErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($urlErro) ? 'error ' : ''; ?> py-3">
                        <label class="control-label">URL de Redirecionamento</label>
                        <div class="controls">
                            <input size="180" class="form-control" name="url" type="text" placeholder="https://bilhete.loterjloterias.com.br/?utm_source=Qrcode_loterj&utm_medium=venda#/"
                                   value="<?php echo !empty($url) ? $url : ''; ?>">
                            <?php if (!empty($urlErro)): ?>
                                <span class="text-danger"><?php echo $urlErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Adicionar</button>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
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