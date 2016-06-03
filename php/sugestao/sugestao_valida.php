<?php
ob_start();
session_start();
//RECEBE ARQUIVO DO FORMULARIO

 $_SESSION['cabecalho'] = "";
 $_SESSION['itens'] = "";
 $_SESSION['qtitens'] = 0;
 $banco  = $_SESSION['banco'];

if ($_FILES["file"]["name"]<>""){
	
	// SALVA O ARQUIVO NO SERVIDOR
	$file 		= $_FILES["file"]["name"];
	$nometmp 	= $_FILES["file"]["tmp_name"];
	$dir 		= "csv/";
	$filename 	= $dir . $file;
	$extensao 	= strtolower(end(explode('.', $file)));
	
	if(!move_uploaded_file($nometmp,$filename))
		exibeMensagem("Erro ao importar o arquivo $file!");
	//else 
	//	exibeMensagem("Arquivo $file importado com sucesso!");

	$_SESSION['file'] = $file;	
	$arquivo = fopen ($filename,"r");
	
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	//PEGA O ULTIMO NUMERO DE SUGESTÃO
	$ociConn = conectaOracle($banco);
	$sql = "SELECT MAX(C.NUMSUGESTAO) AS MAXNUMSUGESTAO FROM PCSUGESTAOCOMPRAC C";
	if (!$ociHandle = @oci_parse($ociConn, $sql)) {
			$e = @oci_error($ociConn);
			//@trigger_error(@htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			print $e['message']."<br />";
		}
	if (!@oci_execute($ociHandle)) {
	 		$e = oci_error($ociHandle);
			//trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			print $e['message']."<br />";
		} else {
			$m=0;
			//print "  OK  - Consulta ao Wint realizada com sucesso!<br />";

			while($ociRow = oci_fetch_object($ociHandle)) 
			{
				$MAXNUMSUGESTAO	= $ociRow->MAXNUMSUGESTAO;
				$m++;
			}
			//print "  OK  - $m Registro encontrados no Wint!<br />";
			//print "  OK  - Ultima sugestao:  $MAXNUMSUGESTAO<br />";
		}//fim do if 
	oci_close($ociConn);	
	
	$sqlInsertC = "";
	$sqlInsertI = "";
		

	$VALORTOTAL=0;
	$i=0;

	while (!feof ($arquivo)) { 
		
		$i++;
		
		//echo $i."<br />";
		
		$linha[$i] = fgets($arquivo, 1024);
		$linha[$i] = explode(";",$linha[$i]);
		
		if($i > 1 && $linha[$i][1] <> ""){
			
			$NUMSUGESTAO			= ($MAXNUMSUGESTAO+1);
			$CODEDITAL				= ($MAXNUMSUGESTAO+1);
			$NUMEROITEMLICIT		= ($i-1);
			$CODFORNEC				= $linha[$i][1];
			$CODFILIAL				= $linha[$i][2];
			$CODUSUARIOSUGESTAO		= $linha[$i][3];
			$DATASUGESTAO			= $linha[$i][4];
			$CODPROD				= $linha[$i][6];
			$QTSUGERIDA				= $linha[$i][7];
			$QTPEDIDO				= $linha[$i][8];
			$OBS					= $linha[$i][9];
			$PCOMPRALIQSUGERIDO		= str_replace(',','.',(string)$linha[$i][10]);
			
			$_SESSION['NUMSUGESTAO'] 		= $NUMSUGESTAO;
			$_SESSION['CODFORNEC'] 			= $CODFORNEC;
			$_SESSION['CODFILIAL'] 			= $CODFILIAL;
			$_SESSION['CODUSUARIOSUGESTAO']	= $CODUSUARIOSUGESTAO;
			
			if($i == 2 && $linha[$i][1] <> ""){

				echo "<div class=\"datagrid\"><table>";

				echo "<thead>";
				echo "	<tr>";
				echo "		<th>Num Sugestão</th>";
				echo "		<th>Cod Fornecedor</th>";
				echo "		<th>Cod Filial</th>";
				echo "		<th>Cod Usuário</th>";
				echo "		<th>Data Sugestão</th>";
				echo "		<th>Cod Edital</th>";
				echo "	</tr>";
				echo "</thead>";

				echo "<tbody>";
				echo "	<tr>";
				echo "		<td>$NUMSUGESTAO</td>";
				echo "		<td>$CODFORNEC</td>";
				echo "		<td>$CODFILIAL</td>";
				echo "		<td>$CODUSUARIOSUGESTAO</td>";
				echo "		<td>$DATASUGESTAO</td>";
				echo "		<td>$CODEDITAL</td>";
				echo "	</tr>";
				echo "</tbody>";
				
				echo "</table></div>";


				echo "<br />";

				
				
				echo "<div class=\"datagrid\"><table>";

				echo "<thead>";
				echo "	<tr>";
				echo "		<th>Num Item</th>";
				echo "		<th>Cod Produto</th>";
				echo "		<th>Observação</th>";
				echo "		<th>Qt Sugerida</th>";
				echo "		<th>Qt Pedida</th>";
				echo "		<th>Valor Un</th>";
				echo "		<th>Valor Total</th>";
				echo "	</tr>";
				echo "</thead>";
				
				echo "<tbody>";
				
				

				$sqlInsertC .= "INSERT INTO PCSUGESTAOCOMPRAC( ";
				$sqlInsertC .= "	/*1*/ NUMSUGESTAO, ";
				$sqlInsertC .= "	/*2*/ CODFORNEC, ";
				$sqlInsertC .= "	/*3*/ CODFILIAL, ";
				$sqlInsertC .= "	/*4*/ CODUSUARIOSUGESTAO, ";
				$sqlInsertC .= "	/*5*/ DATASUGESTAO, ";
				$sqlInsertC .= "	/*6*/ CODEDITAL)  ";
				$sqlInsertC .= " VALUES ( ";
				$sqlInsertC .= "	/*1*/ ".$NUMSUGESTAO.", ";
				$sqlInsertC .= "	/*2*/ ".$CODFORNEC.", ";
				$sqlInsertC .= "	/*3*/ ".$CODFILIAL.", ";
				$sqlInsertC .= "	/*4*/ ".$CODUSUARIOSUGESTAO.", ";
				$sqlInsertC .= "	/*5*/ to_date('".$DATASUGESTAO."','DD/MM/YYYY'), ";
				$sqlInsertC .= "	/*6*/ ".$CODEDITAL.") ";
				
				 $_SESSION['cabecalho'] = $sqlInsertC;
				 $_SESSION['numsugestao'] = $NUMSUGESTAO;

			}

			$SUBTOTAL 	= ($PCOMPRALIQSUGERIDO * $QTSUGERIDA);
			$VALORTOTAL += $SUBTOTAL;
			
			echo "	<tr>";
			echo "		<td>$NUMEROITEMLICIT</td>";
			echo "		<td>$CODPROD</td>";
			echo "		<td>$OBS</td>";
			echo "		<td align=\"right\">$QTSUGERIDA</td>";
			echo "		<td align=\"right\">$QTPEDIDO</td>";
			echo "		<td align=\"right\">R$ " . ROUND($PCOMPRALIQSUGERIDO,2) . "</td>";
			echo "		<td align=\"right\">R$ " . ROUND($SUBTOTAL,2) . "</td>";
			echo "	</tr>";

			
			$sqlInsertI = "INSERT INTO PCSUGESTAOCOMPRAI(
								/*1*/ NUMSUGESTAO, 
								/*2*/ CODPROD, 
								/*3*/ QTSUGERIDA, 
								/*4*/ QTPEDIDO, 
								/*5*/ OBS, 
								/*6*/ PCOMPRALIQSUGERIDO, 
								/*7*/ NUMEROITEMLICIT )
							VALUES (
								/*1*/ ".$NUMSUGESTAO.",
								/*2*/ ".$CODPROD.",
								/*3*/ ".$QTSUGERIDA.",
								/*4*/ ".$QTPEDIDO.",
								/*5*/ '".$OBS."',
								/*6*/ ".str_replace(',','.',(string)$PCOMPRALIQSUGERIDO).", 
								/*7*/ ".$NUMEROITEMLICIT.")";
			
			 $_SESSION['itens'][$i] = $sqlInsertI;
								 

		} // FECHA O if($i>1){
		
		 $_SESSION['qtitens'] = $NUMEROITEMLICIT;

	} // FECHA O while (!feof ($arquivo))
	
	$_SESSION['VALORTOTAL'] = ROUND($VALORTOTAL,2);

	echo "</tbody>";
	
	echo '<tfoot>';
	echo '	<tr>';
	echo '		<td colspan="7"><div id="paging">';
	echo '			<ul>';
	echo '			<li>Valor Total</li>';
	echo '			<li>R$ ' . ROUND($VALORTOTAL,2).'</li>';
	echo '			</ul></div>';
	echo '	</tr>';
	echo '</tfoot>';
	
	echo "</table></div>";
	
	echo "<br />";
	
	echo "<a href=\"index.php?op=13\"><img src=\"img/salvar.png\" /></a>";

	geraLogImportacao($_SESSION['nomeSession'],
					$_SESSION['banco'],
					$_SESSION['file'],
					$_SESSION['NUMSUGESTAO'],
					$_SESSION['CODFORNEC'],
					$_SESSION['CODFILIAL'],
					$_SESSION['CODUSUARIOSUGESTAO'],
					$_SESSION['qtitens'],
					$_SESSION['VALORTOTAL']);
	//echo $sqlInsertC."<BR />";
	//echo $sqlInsertI."<BR />"; 
	
	
} else{

	exibeMensagem("Arquivo não selecionado");

} // FECHA O if ($_FILES["file"]["name"]<>""){
	
?>