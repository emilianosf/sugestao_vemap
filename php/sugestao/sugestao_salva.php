<?php
ob_start();
session_start();

$banco = $_SESSION['banco'];


$countErro=0;

	
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	// SALVA OS REGISTROS DO CABECALHO NO BANCO
	//print "<hr />".$_SESSION['cabecalho'];
	
	$ociConn = conectaOracle($banco);
	
	if (!$ociHandle = @oci_parse($ociConn, $_SESSION['cabecalho'] )) {
			$e = @oci_error($ociConn);
			//@trigger_error(@htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			print "ERRO oci_parse:  ".$e['message']."<br />" . $_SESSION['cabecalho']."<br />";
			$countErro++;
		}
	if (!@oci_execute($ociHandle)) {
			$e = oci_error($ociHandle);
			//trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			print "ERRO oci_execute:  ".$e['message']."<br />" . $_SESSION['cabecalho']."<br />";
			$countErro++;
		} 

	oci_close($ociConn);


	//print "<br />".$_SESSION['qtitens'];
	for($i=2;$i<=($_SESSION['qtitens']+1);$i++){
		//print "<br />".$_SESSION['itens'][$i];

		$ociConn = conectaOracle($banco);
		
		if (!$ociHandle = @oci_parse($ociConn, $_SESSION['itens'][$i] )) {
				$e = @oci_error($ociConn);
				//@trigger_error(@htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
				print "ERRO oci_parse:  ".$e['message']."<br />" . $_SESSION['itens'][$i] . "<br />";
				$countErro++;
			}
		if (!@oci_execute($ociHandle)) {
				$e = oci_error($ociHandle);
				//trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
				print "ERRO oci_execute:  ".$e['message']."<br />" . $_SESSION['itens'][$i] . "<br />";
				$countErro++;
			} 

		oci_close($ociConn);

	}

	if($countErro==0){
		//exibeMensagem("Sugestão salva com sucesso");

		echo "<h1>SUGESTÃO NR <strong>" . $_SESSION['numsugestao'] . "  </strong> IMPORTADO COM SUCESSO!</h1>";
		echo "<a href=\"index.php?op=2\"></a>";
		}

?>