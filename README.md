# dbToGcloud

Na [Icoop](http://icoopweb.com.br/), temos tido problemas de indisponibilidade do BD com o atual host de hospedagem, quando os BDs voltam, voltam backups antigos, com perda de informação, o que é inaceitável.

Ao migrar as bases para o gCloud, tinha a opção e fazer tudo manualmente, ou automatizar. Escolhi a secunda opção, e com 2horas e meia de programação, pude migrar 16 BD completamente para a estrutura do google. //Temos que migrar mais uns 90 =) //

## O que esse código faz?
A intenção dele é replicar a mesma base de dados, com o mesmo usuário e senha do host antigo para o gCloud.

- criar usuários para base de dados no gCloud
- criar Databases no gCloud
- revogar acessos Usuario na Database no gCloud
- limitar Acesso Usuario Sua Database no gCloud
- download Base de dados no host antigo
- upload base dados no gCloud

## Requisitos:
- [gCloud SDK](https://cloud.google.com/sdk/?hl=pt-br) instalado e configurado para o projeto que receberá as bases.

## Como usar?
Modifique o arquivo CONFIG.php para a sua realidade. Para nós, basta conectar a uma base de dados que contem nossa lista de BDs que gerenciamos, e com uma query, obtenho uma lista com todas as bases a serem migradas.

Se essa não é sua realidade, você pode montar um array dentro do CONFIG.PHP, pois o script usará um laço, e as funcoes precisam de um array com esta estrutura:

```
$bases = array(
  array('host' => 'ip.do.servidor','user' => 'userDB', 'pass' => 'passDB','bd' => 'databaseName'),
);
```
Você precisa setar também no arquivo CONFIG.PHP as constantes:

```
define('GCLOUD_IP', 'IPINSTANCIASQL');
define('GCLOUD_ROOT_PASS', 'password');
define('GCLOUD_SQL_INSTANCIA', 'nomeinstancia');
```

Elas são responsáveis por informar qual instancia receberá os dados.

No arquivo index.php na linha 48 há um laço, você precisa também adaptar a sua necessidade (resultado de query, array, etc).

Por fim, basta invocar via o script index.php, e aguardar as bases serem migradas.

## E depois?

Para checar a conexão, pode usar o cliente do mysql, ou alterar o arquivo de conexão do seu sistema para o novo IP do servidor.
