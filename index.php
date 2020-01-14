<?php

include_once __DIR__."/CONFIG.php";

$sql              = "SELECT * FROM `tabelanoBD` where 1==1";
$bases = mysqli_query($conexao,$sql);

function criarUsuariosBd($value)
{
    return "gcloud sql users create {$value['user']} --password={$value['pass']} --host=% -i ".GCLOUD_SQL_INSTANCIA;
}

function deletarUsuariosBd($value)
{
    return "gcloud sql users delete {$value['user']} -i ".GCLOUD_SQL_INSTANCIA;
}

function criarDatabases($value)
{
    return "gcloud sql databases create {$value['bd']} -i ".GCLOUD_SQL_INSTANCIA;
}

function deletarDatabases($value)
{
    return "gcloud sql databases delete {$value['bd']} -i ".GCLOUD_SQL_INSTANCIA;
}

function revogarAcessoUsuarioDatabase($value)
{
    return "mysql --host=".GCLOUD_IP." --user=root --password=".GCLOUD_ROOT_PASS." -e \"REVOKE ALL PRIVILEGES,GRANT OPTION from {$value['user']};\" {$value['bd']}";; 
}

function limitarAcessoUsuarioSuaDatabase($value)
{
    return "mysql --host=".GCLOUD_IP." --user=root --password=".GCLOUD_ROOT_PASS." -e \"GRANT ALL PRIVILEGES ON {$value['bd']}.* TO '{$value['user']}'@'%'\" {$value['bd']}";
}

function downloadBaseDados($value)
{
    return "mysqldump --host={$value['host']} --user={$value['user']} --password={$value['pass']} {$value['bd']} > {$value['bd']}.sql";; 
}

function uploadBaseDados($value)
{
    return "mysql --host=".GCLOUD_IP." --user={$value['user']} --password={$value['pass']} {$value['bd']} < {$value['bd']}.sql";
}

while ($value = $bases->fetch_assoc())
{
  shell_exec(criarUsuariosBd($value));

  shell_exec(criarDatabases($value));

  shell_exec(revogarAcessoUsuarioDatabase($value));

  shell_exec(limitarAcessoUsuarioSuaDatabase($value));

  shell_exec(downloadBaseDados($value));

  shell_exec(uploadBaseDados($value));

  echo "migrado:".$value['host'].PHP_EOL.PHP_EOL;
}

mysqli_free_result($bases);

