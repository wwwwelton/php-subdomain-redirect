<?php 

session_start();
$_SESSION["loterj"] = isset($_SESSION["loterj"]) ? $_SESSION["loterj"] : '';
$_POST['user'] = isset($_POST['user']) ? $_POST['user'] : "";
$_POST['password'] = isset($_POST['password']) ? $_POST['password'] : '';

if($_POST['user'] == "admin" && $_POST['password'] == "passloterj20") {
    session_start();
    $_SESSION["loterj"] = 'logado';
    header('Location: index.php');
} else {
    $_SESSION["loterj"] = 'deslogado';
}
?>


<!DOCTYPE html>
<html lang="pt-br" style="height: 100%">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Página Inicial</title>
</head>

<body style="height: 100%">
    

<div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">            
            <div class="d-flex justify-content-center"><img src="assets/LOTERJ-DE-PREMIOS-LOGO-159x159.png"></div>
            <form action="login.php" method="post">            
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" name="user" placeholder="Usuario" type="text">
                </div>                
                <div class="form-group">
                    <input class="form-control form-control-lg" name="password" placeholder="Senha" type="password">
                </div>
                <div class="form-group">
                    <button class="btn btn-info btn-lg btn-block">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>