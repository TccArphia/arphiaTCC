<?
$obj_mysqli = new mysqli("127.0.0.1", "root", "", "tutocrudphp");
 
if ($obj_mysqli->connect_errno)
{
	echo "Ocorreu um erro na conexão com o banco de dados.";
	exit;
}
 
mysqli_set_charset($obj_mysqli, 'utf8');
 
//Incluímos um código aqui...
$id     = -1;
$título  = "";
$conteúdo  = "";
$cidade = "";
$CGM    = "";
 
//Validando a existência dos dados
if(isset($_POST["título"]) && isset($_POST["conteúdo"]) && isset($_POST["datapostagem"]) && isset($_POST["CGM"]))
{
	if(empty($_POST["conteúdo"]))
		$erro = "Campo conteúdo obrigatório";
	else
	if(empty($_POST["título"]))
		$erro = "Campo título obrigatório";
	else
	{
		//Alteramos aqui também.
		//Agora, o $id, pode vir com o valor -1, que nos indica novo registro, 
		//ou, vir com um valor diferente de -1, ou seja, 
                //o código do registro no banco, que nos indica alteração dos dados.
		$id     = $_POST["id"];		
		$nome   = $_POST["título"];
		$conteúdo  = $_POST["conteúdo"];
		$datapostagem = $_POST["datapostagem"];
		$CGM     = $_POST["CGM"];
				
		//Se o id for -1, vamos realizar o cadastro ou alteração dos dados enviados.
		if($id == -1)
		{
			$stmt = $obj_mysqli->prepare("INSERT INTO `cliente` (`título`,`conteúdo`,`datapostagem`,`CGM`) VALUES (?,?,?,?)");
			$stmt->bind_param('ssss', $título, $conteúdo, $cidade, $uf);	
		
			if(!$stmt->execute())
			{
				$erro = $stmt->error;
			}
			else
			{
				header("Location:postagem.php");
				exit;
			}
		}
		//se não, vamos realizar a alteraçao dos dados,
                //porém, vamos nos certificar que o valor passado no $id, seja válido para nosso caso.
		else
		if(is_numeric($id) && $id >= 1)
		{
			$stmt = $obj_mysqli->prepare("UPDATE `cliente` SET `nome`=?, `conteúdo`=?, `datapostagem`=?, `CGM`=? WHERE id = ? ");
			$stmt->bind_param('ssssi', $título, $email, $cidade, $CGM, $id);
		
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
        //..,pegamos aqui o id passado...
	$id = (int)$_GET["id"];
	
        //...montamos a consulta que será realizada....
	$stmt = $obj_mysqli->prepare("SELECT * FROM `cliente` WHERE id = ?"); //
        //passamos o id como parâmetro, do tipo i = int, inteiro...
	$stmt->bind_param('i', $id);
        //...mandamos executar a consulta...
	$stmt->execute();
	//...retornamos o resultado, e atribuímos à variável $result...
	$result = $stmt->get_result();
        //...atribuímos o retorno, como um array de valores,
        //por meio do método fetch_assoc, que realiza um associação dos valores em forma de array...
        $aux_query = $result->fetch_assoc();
	//...onde aqui, nós atribuímos às variáveis.
	$título = $aux_query["título"];
	$email = $aux_query["conteúdo"];
	$datapostagem = $aux_query["datapostagem"];
	$CGM = $aux_query["CGM"];
 
	$stmt->close();
}
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<title>Post</title>
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
	  <input type="text" name="título" placeholder="Inserir título" value="<?=$nome?>"><br/><br/>
	  E-mail:<br/> 
	  <input type="text" name="conteúdo" placeholder="Inserir potagem" value="<?=$email?>"><br/><br/>
	  Cidade:<br/> 
	  <input type="text" name="datapostagem" placeholder="Data da postagem" value="<?=$cidade?>"><br/><br/>
	  UF:<br/> 
	  <input type="text" name="CGM" size="2" placeholder="CGM" value="<?=$uf?>">
	  <br/><br/>
	  <input type="hidden" value="<?=$id?>" name="id" >
          <!--Alteramos aqui também, para poder mostrar o texto Cadastrar, ou Salvar, de acordo com o momento. :)-->
	  <button type="submit"><?=($id==-1)?"Publiicar":"Salvar"?></button>
	</form>
	<br>
	<br>
	<table width="400px" border="0" cellspacing="0">
	  <tr>
	    <td><strong>#</strong></td>
	    <td><strong>Título</strong></td>
	    <td><strong>Conteúdo</strong></td>
	    <td><strong>Data postagem</strong></td>
	    <td><strong>CGM</strong></td>
	    <td><strong>#</strong></td>
	  </tr>
	<?
	$result = $obj_mysqli->query("SELECT * FROM `cliente`");
	while ($aux_query = $result->fetch_assoc()) 
    {
	  echo '<tr>';
	  echo '  <td>'.$aux_query["Id"].'</td>';
	  echo '  <td>'.$aux_query["Título"].'</td>';
	  echo '  <td>'.$aux_query["Conteúdo"].'</td>';
	  echo '  <td>'.$aux_query["Data postagem"].'</td>';
	  echo '  <td>'.$aux_query["CGM"].'</td>';
	  echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'">Editar</a></td>';
	  echo '</tr>';
	}
    while ($aux_query = $result->fetch_assoc()) 
{
  echo '<tr>';
  echo '  <td>'.$aux_query["Id"].'</td>';
  echo '  <td>'.$aux_query["Título"].'</td>';
  echo '  <td>'.$aux_query["Conteúdo"].'</td>';
  echo '  <td>'.$aux_query["Data postagem"].'</td>';
  echo '  <td>'.$aux_query["CGM"].'</td>';
  echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'">Editar</a></td>';
  echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'&del=true">Excluir</a></td>';
  echo '</tr>';
}
	?>
	</table>
  </body>
</html>
</table>
  </body>
</html>