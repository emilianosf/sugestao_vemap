<?php
ob_start();
session_start();
	
$_SESSION['banco'] = 'WINT';
?>


<h1>Importação de Sugestão no banco <?php echo $_SESSION['banco']; ?></h1>

<link href="css/form2.css" rel="stylesheet" type="text/css">
<div id="stylized" class="myform">
	
<form name="form1" id="form1" action="index.php" method="POST" enctype="multipart/form-data">

	<input type="hidden" name="op" value="12" />
	<input type="hidden" name="tipo" value="$tipo" />


	<br />
		<label>Arquivo a importar:</label>
	<label1>
		<input type="file" name="file" id="file" size="10" value="Selecione o arquivo!" />
	</label1>

	<br />
	<input type="submit" name="acao" value="Enviar" />

</form>
</div> 