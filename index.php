<?php 

include 'painel/banco.php';  

$url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$parsedUrl = parse_url($url);

$host = explode('.', $parsedUrl['host']);

$subdomain = $host[0];
$url = '';

echo $subdomain;
echo $url;

echo '<hr>';

$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM pessoa where subdominio = ?";
$q = $pdo->prepare($sql);
$q->execute(array($subdomain));
$data = $q->fetch(PDO::FETCH_ASSOC);
$id = isset($data['id']) ? $data['id'] : "";
$subdominio = isset($data['subdominio']) ? $data['subdominio'] : "";
$url = isset($data['url']) ? $data['url'] : "";

Banco::desconectar();

echo $subdomain;
echo $url;

//loterj
if ($url == "") { 
    header("Location: https://bilhete.loterjloterias.com.br/?utm_source=Qrcode_loterj&utm_medium=venda#/"); 
} else {
    header("Location: {$url}"); 
}

?>