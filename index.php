<?php
	ob_start();	
	session_start();
	date_default_timezone_set('America/Halifax');

	if(isset($_GET['op'])) { $op = $_GET['op']; } 
	else if(isset($_POST['op'])) { $op = $_POST['op']; } 
	else { $op = 0; }
			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
  <head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
	<link href="css/style.css" rel="stylesheet" type="text/css" /> 
	<link href="css/table.css" rel="stylesheet" type="text/css" /> 
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
	<title>Sugestão de Compra</title>
  </head>
<body>
<center>
<div id="body">

<table>

<tr>
<td>
	<div align="center"><img src="img/MAIN_LOGO.png"/></div>
</td>
</tr>

<tr>
<td valign="top">
<div id="welcome">
	<?php
 		include("php/functions.php");  
		include("php/welcome.php");  
		verificaSession();
	?>
</div>
</td>

</tr>
<td>
	<div id="principal">

<?php
			switch ($op)
			{
				case 0: include("php/login/login.php"); break;
				case 1: include("php/sobre.php"); break;
				case 2: include("php/sugestao/sugestao_importa.php"); break;
				case 3: include("php/sair.php"); break;

				case 11: include("php/sugestao/sugestao_importa.php"); break;
				case 12: include("php/sugestao/sugestao_valida.php"); break;
				case 13: include("php/sugestao/sugestao_salva.php"); break;
				

				default: include("php/erro.php"); break;
			}
	print "</div>";
?>
</td>
</tr>

<tr>
<td valign="bottom" colspan="2">
   <div id="rodape">
   	  <hr />
	  <p>
      <strong>Sistema de Importação de Sugestão de Compra v2.0</strong><br  />
      Copyright <?php echo @date('Y'); ?> - Todos os direitos reservados a <a href="http://emilianofilho.com.br/" target="_blank">Emiliano Filho</a>.
	  </p>
   </div><!-- fecha o rodape -->
</tr>
</table>
</div><!--DIV MEIO-->


</center>
</body>
</html>