<?php

function redireciona($location)
{
	print  "<script LANGUAGE=\"JavaScript\" TYPE=\"text/javascript\">
				location.href=\"$location\";
			</script>";
	//	header("location: $location");
}
function voltaPagina($nr)
{
	print  "<script LANGUAGE=\"JavaScript\" TYPE=\"text/javascript\">
				history.go(-$nr);
			</script>";
}
/*###############################################*/
function FechaPagina()
{
	print  "<script LANGUAGE=\"JavaScript\" TYPE=\"text/javascript\">
				window.open('', '_self', '');
        		window.close();
			</script>";
}
/*###############################################*/

function ExibeMensagem($msg){
	print  "<script LANGUAGE=\"JavaScript\" TYPE=\"text/javascript\">
				window.alert (\"$msg \");
			</script>";
}
/*###############################################*/

/*###############################################*/

function conectaMySql(){
	$dbname="sugestao";
	$host = "192.168.0.16";
	$user = "pergamo";
	$pass = "pergamo";

	//1º passo - Conecta ao servidor MySQL
	if(!($conn = mysql_connect($host,$user,$pass))) {
	   exibeMensagem("Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.");
	}
	//2º passo - Seleciona o Banco de Dados
	if(!($con=mysql_select_db($dbname,$conn))) {
	   exibeMensagem("Não foi possível estabelecer uma conexão com o banco $dbname. Favor Contactar o Administrador.");
	} 
}
/*###############################################*/

function conectaOracle($banco){
	switch ($banco)
	{
		case "WINT": 		{$user = "dunorte";	 	$pass = "drq34wq12";	break; }
		case "DBBELEM": 	{$user = "supergiro";	$pass = "spr8k99pc";	break; }
		case "PROD": 		{$user = "dbrh";	 	$pass = "dbrh";  		break; }
	}
	$bd1 = "192.168.0.59";
	$bd2 = "192.168.0.60";

	$ora_bd1 = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS=(PROTOCOL=TCP) 
					(HOST=$bd1)(PORT=1521) ) ) (CONNECT_DATA=(SERVICE_NAME=$banco) ) )";  
	$ora_bd2 = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS=(PROTOCOL=TCP) 
					(HOST=$bd2)(PORT=1521) ) ) (CONNECT_DATA=(SERVICE_NAME=$banco) ) )"; 

	if(!@($conn = oci_connect($user,$pass,$ora_bd1)))
	{ 
		print "PRIMEIRA TENTATIVA DE CONEXAO COM O BANCO $banco FALHOU!<br />	"; 
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

		if(!@($conn = oci_connect($user,$pass,$ora_bd2)))
		{ 
			print "SEGUNDA TENTATIVA DE CONEXAO COM O BANCO $banco TAMBEM FALHOU!<br />	"; 
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			//die;
		}
		else{
			//print "CONECTOU NA SEGUNDA TENTATIVA COM O BANCO $banco!<br />";
		 	return $conn; 
		}
	} 
	else{
		//print "CONECTOU NA PRIMEIRA TENTATIVA COM O BANCO $banco!<br />";
		return $conn; 
	}
}
/*###############################################*/

function verificaSession() {
	if (!isset($_SESSION['nomeSession'])) 
	{
		unset($_SESSION['nomeSession']);
		unset($_SESSION['loginSession']);
	}
}
/*###############################################*/

function verificaPermissaoAcesso($iduser,$nivel){
	include "php/conexao.php";
	$sql = "SELECT count(*) FROM `permissoes` where cod_usuario = '$iduser' and cod_acesso like '$nivel'";
	//print $sql;
	$sqlExecuta = mysql_query($sql) or die(mysql_error());
	$linha_sql = mysql_fetch_array($sqlExecuta);

	if($linha_sql['count(*)'] <= 0){
		print  "<script LANGUAGE=\"JavaScript\" TYPE=\"text/javascript\"  charset=\"utf-8\">
					window.location=\"index.php?op=9\";
				</script>";
		die;
	}
}
/*###############################################*/
function FormataData($data){
	$array = explode('-',$data);
	$dia = $array[0];
	$mes = $array[1];
	switch ($mes)
	{
		case 1: $mes = "-jan-"; break;  case 7: $mes = "-jul-"; break; 
		case 2: $mes = "-feb-"; break;  case 8: $mes = "-aug-"; break; 
		case 3: $mes = "-mar-"; break;  case 9: $mes = "-sep-"; break; 
		case 4: $mes = "-apr-"; break;  case 10: $mes = "-oct-"; break; 
		case 5: $mes = "-may-"; break;  case 11: $mes = "-nov-"; break; 
		case 6: $mes = "-jun-"; break;  case 12: $mes = "-dec-"; break; 
	}
	$ano = $array[2];
	$data = $dia.$mes.$ano;
	return($data);
}
/*###############################################*/
function Moeda($valor){
	$valor = number_format($valor, 2, ',', '.');
	return($valor);
}

/*###############################################*/
function Porcento($total, $parte){
	if($total==0) $total=1;
	if($parte > 0)
		$perc = number_format(($parte/$total)*100, 2, ',', '.') . " %"; // retorna 100,00 %
	else 
		$perc = number_format(0, 2, ',', '.') . " %"; // retorna 100,00 %
	return($perc);
}



/*#########################################################################################*/
function geraLogAcessos($user){
        $ip = ($_SERVER['REMOTE_ADDR']);
        $browser = ($_SERVER['HTTP_USER_AGENT']);
        $data = date('d/m/Y H:i:s');
		$conteudo  = "";
    	$arquivo = "../../log/log_de_acesso_".@date("Y").@date("m").".csv";
		if (!file_exists($arquivo)) {
			$conteudo    .=  "DATA; IP_ACESSO ; SISTEMA_OPERACIONAL ; NAVEGADOR;  USUARIO; APLICACAO".chr(13).chr(10);
		}
		
		//print $arquivo; die;

    if (strchr($browser, 'Firefox'))
        $nav = 'Firefox ';
      elseif (strchr($browser, 'Chromium'))
        $nav = 'Chromium ';
      elseif (strchr($browser, 'Chrome'))
        $nav = 'Chrome ';
      elseif (strchr($browser, 'Opera'))
        $nav = 'Opera ';
      elseif (strchr($browser, 'Windows'))
        $nav = 'Internet Explorer ';
      else
        $nav = 'Outro Navegador ';
	  
     if (strchr($browser, 'Linux'))
         $os = 'Linux ';
     elseif (strchr($browser, 'Windows'))
         $os = 'Windows ';
     else
         $os = 'Outro Sistema ';

    $conteudo    .=  @date('Y-m-d H:i:s').";"
					.$ip.";"
					.$os.";"
					.$nav.";"
					.$user.";"
					."Importacao de Pedido de compra"
					.chr(13).chr(10);

    if (!$abrir = fopen($arquivo, "a"))     exit;
    if (!fwrite($abrir, $conteudo))         exit;

    fclose($abrir);
  }//fim da função da exbir();
  
/*#########################################################################################*/
function geraLogImportacao($usuario,$banco,$file,$NUMSUGESTAO,$CODFORNEC,$CODFILIAL,$CODUSUARIOSUGESTAO,$qtitens,$VALORTOTAL){
	
	$conteudo  = "";
   	$arquivo = "log/log_de_importacao_".@date("Y").@date("m").".csv";
	if (!file_exists($arquivo)) {
		$conteudo .=  "DATA; USUARIO; BANCO; ARQUIVO; NUMSUGESTAO; CODFORNEC; CODFILIAL; CODUSUARIOSUGESTAO; QTITENS; VALORTOTAL".chr(13).chr(10);
	}

	$conteudo .= @date('Y-m-d H:i:s').";"
				.$usuario.";"
				.$banco.";"
				.$file.";"
				.$NUMSUGESTAO.";"
				.$CODFORNEC.";"
				.$CODFILIAL.";"
				.$CODUSUARIOSUGESTAO.";"
				.$qtitens.";"
				.$VALORTOTAL
				.chr(13).chr(10);

    if (!$f = fopen($arquivo, "a"))     exit;
    if (!fwrite($f, $conteudo))         exit;
    fclose($f);

}//fim da função da exbir();