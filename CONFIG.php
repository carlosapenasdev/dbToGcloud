<?php
define('SERVIDOR', 'IPSERVIDORBD');
define('USUARIO', 'user');
define('SENHA', 'password');
define('BD', 'databasename');

define('GCLOUD_IP', 'IPINSTANCIASQL');
define('GCLOUD_ROOT_PASS', 'password');
define('GCLOUD_SQL_INSTANCIA', 'nomeinstancia');

$conexao = mysqli_connect(SERVIDOR, USUARIO, SENHA);
mysqli_select_db($conexao, BD);

mysqli_query($conexao,"SET NAMES 'utf8';");
?>