<?php
session_start();
include ("./recaptchlib.php");
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
   <!-- Link Recaptcha -->
   <script src="https://www.google.com/recaptcha/api.js?hl=pt-BR"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/flickity/1.0.0/flickity.css'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="../../components/header/assets/css/style.css">
  <script>document.getElementsByTagName("html")[0].className += " js";</script>
  
  <title>ParaSaberMais</title>
</head>
<body>
  <header class="cd-main-header js-cd-main-header">
  <div class="cd-logo-wrapper">
      <a href="../home/" class="cd-logo">Voltar</a>
    </div>
    
    <div class=" js-cd-search">
    </div>
  
    <button class="reset cd-nav-trigger js-cd-nav-trigger" aria-label="Toggle menu"><span></span></button>
  
    <ul class="cd-nav__list js-cd-nav__list">
      <li class="cd-nav__item"><a href="../help/index.php">Ajuda</a></li>
      <li class="cd-nav__item"><a href="../contato/index.php">Contato</a></li>
      <li class="cd-nav__item cd-nav__item--has-children cd-nav__item--account js-cd-item--has-children">
        <a href="#0">
          <img src="../../pages/perfil/uploads/<?php echo"$_SESSION[login].jpg "?>" onerror="this.src='../perfil/uploads/user.jpg'" alt="avatar">
          <span>Conta</span>
        </a>
    
        <ul class="cd-nav__sub-list">
          <li class="cd-nav__sub-item"><a href="../perfil/index.php">Editar Conta</a></li>
          <li class="cd-nav__sub-item"><a href="../../components/logout/index.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </header> <!-- .cd-main-header -->
  
    <div class="cd-content-wrapper">

	<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: ../login/index.php");
	exit;
  }


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <!-- Bootstrap CSS -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	  <link rel="stylesheet" href="./style.css">
	  <link rel="stylesheet" href="../../components/header/assets/css/style.css">
	  <title>Mural de postagens</title>
</head>
<body>
<br><br>
<div class="container" style="background-color:#f1f1f1">
</body>
</html>


<?php
include("../../../_bd/Config.php");

//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1; 
	
//***** sql para buscar qual user ta logado
if (!isset($_POST["login"])){
	$sql = "SELECT `id`, `login` FROM `usuarios` WHERE id = ".$_SESSION['id'];
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Resultado
    while($row = $result->fetch_assoc()) {
		$_SESSION['id'] = $row["id"];

		echo "<h4> Olá ".$row["login"]."!</h4>";		
    }
	
	echo "<br>";
	echo "	<div id=\"caixa-div\">
			<div id=\"caixa\">
				  <form action=\"publica.php\" method=\"post\">
				
					<label class=\"titleMargin\"for=\"lblpublicacao\">Faça uma nova publi&ccedil&atildeo</label>
					<textarea id=\"publicacao\" name=\"publicacao\" placeholder=\"Digite algo..\" style=\"height:100px\" required></textarea>

					<input type=\"submit\" value=\"Publicar\">
				  </form>
			</div>
			</div>";
			
	//*************** INICIO DA listagem de todos os posts ***********
	$sql = "SELECT post.id_P,post.publicacao,post.reg_date,usuarios.login FROM post,usuarios WHERE post.id_U = usuarios.id order by reg_date DESC";
	
	$result = $conn->query($sql);
	//conta o total de posts feitos 
    $total = $result->num_rows;
	//calcula o número de páginas
    $numPaginas = ceil($total/50);
	//variavel para calcular o início da visualização com base na página atual 
    $inicio = (50*$pagina)-50; 
 
    //seleciona os itens por página 
    $sql = "SELECT post.id_P,post.publicacao,DATE_FORMAT(post.reg_date, \"%d/%m/%Y às %H:%i\") as reg_date,usuarios.login FROM post,usuarios WHERE post.id_U = usuarios.id  order by reg_date DESC limit ".$inicio.",10"; 
			
    $result = $conn->query($sql); 
   
		if ($result->num_rows > 0) {
			// Resultado dos posts feito por todos usuários com cadastro
			echo "<div class=\"container\">
					<table> ";
			while($row = $result->fetch_assoc()) {
				echo "
					  <tr>
						<td>Publicado por ". $row["login"]." em ".$row["reg_date"]."</td> 
					  </tr>
					  <tr>
						<td><form action=\"\" method=\"post\">
							<input type=\"hidden\" name=\"postID\" value=".$row["id_P"]." /> 
							". $row["publicacao"]." 
							<br><br>
							</form>
						</td>
					  </tr>";		
			} 
		} else {
			echo "Nenhuma publi&ccedil&atildeo feita. ";
		}
//**************************************************************************
} else {
	echo "Desculpe mas o usuário ou a senha não foram encontrados.<br>Deseja se <a href=\"../cadastrp/index.php\">cadastrar</a> ou voltar para a tela de <a href=\"../login/index.php\">login</a>?";
}
$conn->close();

?>

  </div>

</body>
</html>

	</div>
