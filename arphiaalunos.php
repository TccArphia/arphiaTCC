<? 
if(isset($_POST["nome"])) && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["CGM"])
{
    if(empty($_POST["nome"]))
    $erro = "Campo nome obrigatório";
else
if(empty($_POST["email"]))
    $erro = "Campo e-mail obrigatório";
else
if(empty($_POST["senhha"]))
		$erro = "Campo senha obrigatório";
	else
	if(empty($_POST["CGM"]))
		$erro = "Campo CGM obrigatório";
	else
$obj_mysqli = new mysqli("127.0.0.1", "seu_usuario", "sua_senha", "tutocrudphp");
 
if ($obj_mysqli->connect_errno)
{
	echo "Ocorreu um erro na conexão com o banco de dados.";
	exit;
}
 
mysqli_set_charset($obj_mysqli, 'utf8');
 
//Validando a existência dos dados
if(isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["CGM"]))
{
	if(empty($_POST["nome"]))
		$erro = "Campo nome obrigatório";
	else
	if(empty($_POST["email"]))
		$erro = "Campo e-mail obrigatório";
	else

	if(empty($_POST["senha"]))
    $erro = "Campo senha obrigatório";
else
if(empty($_POST["CGM"]))
    $erro = "Campo CGM obrigatório";
else
	{
		//Vamos realizar o cadastro ou alteração dos dados enviados.
        $nome   = $_POST["nome"];
		$email  = $_POST["email"];
		$cidade = $_POST["senha"];
		$uf     = $_POST["CGM"];
		
		$stmt = $obj_mysqli->prepare("INSERT INTO `cliente` (`nome`,`email`,`senha`,`CGM`) VALUES (?,?,?,?)");
		$stmt->bind_param('ssss', $nome, $email, $senha, $CGM);
		
		if(!$stmt->execute())
		{
			$erro = $stmt->error;
		}
		else
		{
			header("Location:cadastro.php");
            exit;
		}
    }
    //retorna um erro.
    else
    {
        $erro = "Número inválido";
    }
}
}
else
//Incluimos este bloco, onde vamos verificar a existência do id passado...
if(isset($_GET["id"]) && is_numeric($_GET["id"]))
{
    if(isset($_GET["id"]) && is_numeric($_GET["id"])) //Incluimos aqui...
{
	$id = (int)$_GET["id"];
	
	if(isset($_GET["del"]))
	{
		$stmt = $obj_mysqli->prepare("DELETE FROM `senha` WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		
		header("Location:cadastro.php");
		exit;
	}
	else
	{
		$stmt = $obj_mysqli->prepare("SELECT * FROM `cliente` WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$aux_query = $result->fetch_assoc();
		
		$nome = $aux_query["Nome"];
		$email = $aux_query["Email"];
		$senha = $aux_query["Senha"];
		$CGM = $aux_query["CGM"];
		
		$stmt->close();		
	}
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Banco de dados</title>
</head>
<body>
<?
if(isset($erro))
	echo '<div style="color:#F00">'.$erro.'</div><br/><br/>';
else
if(isset($sucesso))
	echo '<div style="color:#00f">'.$sucesso.'</div><br/><br/>';
 
?>
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
        Nome:<br/>
        <input type="text" name="nome" placeholder="Qual seu nome?"><br/><br/>
        E-mail:<br/>
        <input type="email" name="email" placeholder="Qual seu email?"><br/><br/>
        Senha:<br/>
        <input type="text" name="senha" placeholder="Qual sua senha?"><br/><br/>
        CGM:<br/>
        <input type="text" name="CGM" placeholder="Qual seu CGM?" value="<?=$CGM?>">
        <br/><br/>
        <input type="hidden" value="-1" name="id_escola">
        <input type="hidden" value="-1" name="is_admin">
        <button type="submit"><?=($id==-1)?"Cadastrar":"Salvar"?></button>

</form>
<br>
<br>
<table width="400px" border="0" cellspacing="0">
    <tr>
    <td><strong>#</strong></td>
    <td><strong>Nome</strong></td>
    <td><strong>Email</strong></td>
    <td><strong>Senha</strong></td>
    <td><strong>CGM</strong></td>
    <td><strong>#</strong></td>
    </tr>
<?
$result = $obj_mysqli->query("SELECT * FROM `cliente`");
while ($aux_query = $result->fetch_assoc()) 
{
    echo '<tr>';
    echo '  <td>'.$aux_query["Id"].'</td>';
    echo '  <td>'.$aux_query["Nome"].'</td>';
    echo '  <td>'.$aux_query["Email"].'</td>';
    echo '  <td>'.$aux_query["Senha"].'</td>';
    echo '  <td>'.$aux_query["CGM"].'</td>';
    echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'">Editar</a></td>';
    echo '</tr>';
}
while ($aux_query = $result->fetch_assoc()) 
{
  echo '<tr>';
  echo '  <td>'.$aux_query["Id"].'</td>';
  echo '  <td>'.$aux_query["Nome"].'</td>';
  echo '  <td>'.$aux_query["Email"].'</td>';
  echo '  <td>'.$aux_query["Cidade"].'</td>';
  echo '  <td>'.$aux_query["UF"].'</td>';
  echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'">Editar</a></td>';
  echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'&del=true">Excluir</a></td>';
  echo '</tr>';
}
?>
</table>
</body>
</html>