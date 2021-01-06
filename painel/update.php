<?php

session_start();
$_SESSION["loterj"] = isset($_SESSION["loterj"]) ? $_SESSION["loterj"] : '';

if($_SESSION["loterj"] == 'logado') {
?>

<?php

require 'banco.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}

if (!empty($_POST)) {

    $subdominioErro = null;
    $urlErro = null;

    $subdominio = $_POST['subdominio'];
    $url = $_POST['url'];

    //Validação
    $validacao = true;
    if (empty($subdominio)) {
        $subdominioErro = 'Por favor digite o subdominio!';
        $validacao = false;
    }

    if (empty($url)) {
        $urlErro = 'Por favor digite a URL de Redirecionamento!';
        $validacao = false;
    } 

    // update data
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE pessoa  set subdominio = ?, url = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($subdominio, $url, $id));
        Banco::desconectar();
        header("Location: index.php");
    }
} else {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM pessoa where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $subdominio = $data['subdominio'];
    $url = $data['url'];
    Banco::desconectar();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- using new bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Atualizar Redirecionamento</title>
</head>

<body>
<div class="container">

    <div class="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> Atualizar Redirecionamento </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="update.php?id=<?php echo $id ?>" method="post">

                    <div class="control-group <?php echo !empty($subdominioErro) ? 'error' : ''; ?>">
                        <label class="control-label">Nome do subdominio 'nome'.loterj.rio.br</label>
                        <div class="controls">
                            <input name="subdominio" class="form-control" size="150" type="text" readonly placeholder="Nome exemplo: davi"
                                   value="<?php echo !empty($subdominio) ? $subdominio : ''; ?>">
                            <?php if (!empty($subdominioErro)): ?>
                                <span class="text-danger"><?php echo $subdominioErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($urlErro) ? 'error' : ''; ?> py-2">
                        <label class="control-label">URL de Redirecionamento</label>
                        <div class="controls">
                            <input name="url" class="form-control" size="180" type="text" placeholder="https://bilhete.loterjloterias.com.br/?utm_source=Qrcode_loterj&utm_medium=venda#/"
                                   value="<?php echo !empty($url) ? $url : ''; ?>">
                            <?php if (!empty($urlErro)): ?>
                                <span class="text-danger"><?php echo $urlErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <br/>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Atualizar</button>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
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