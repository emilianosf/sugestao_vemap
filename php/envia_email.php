<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
$nome = "Email automático";
$email_from='indicadores@duno.com.br';	

if( PATH_SEPARATOR ==';'){ $quebra_linha="\r\n";
 
} elseif (PATH_SEPARATOR==':'){ $quebra_linha="\n";
 
} elseif ( PATH_SEPARATOR!=';' and PATH_SEPARATOR!=':' )  {echo ('Esse script não funcionará corretamente neste servidor, a função PATH_SEPARATOR não retornou o parâmetro esperado.');
 
}
 
// Para quem vai ser enviado o email
$para = "sistema@duno.com.br";
if (file_exists($nome_arquivo)) {
	$fp = fopen($nome_arquivo, "rb"); // abre o arquivo enviado
	$anexo = fread($fp, filesize($nome_arquivo)); // calcula o tamanho
	$anexo = base64_encode($anexo); // codifica o anexo em base 64
	fclose($fp); // fecha o arquivo
	$anexo = chunk_split($anexo); 
}

$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 
 
$mensagem = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
	<meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
	<style type="text/css">
		body {	font-family:Verdana, Geneva, sans-serif; }
		p{ 	font-size:11px; }
		strong{	color:#069;}
		h5{ 	font-size:12px;
				color:#F00;
				font-weight:bold; }
</style>
</head>
<body>
<h2>Painel de Indicadores</h2>
<p>
	E-mail enviado pelo Sistema de Apoio a Diretoria.<br />
	Enviando o arquivo <strong>'.$nome_arquivo.'</strong>
</p>';


if($mensagem_adicional!=""){
	$texto = htmlentities($mensagem_adicional);
	$texto = html_entity_decode($texto);
	$mensagem .= "<h5><strong>Mensagem Adicional: </strong><br />$texto</h5><BR />";
}

$mensagem .= '<p>Att,<br />
Dunorte - Distribuidora Produtos de Consumo LTDA.<br />
  Tel.:(92) 2126 - 2805 <br />
  E - mail: <a href="mailto:sistema@duno.com.br">sistema@duno.com.br</a> / Web: <a href="http://www.duno.com.br/">www.duno.com.br</a> <br />
End.: Avenida Cosme Ferreira, 3630 - Coroado,&nbsp; CEP: 69083 - 000 -  Manaus/AM </p>
</body>
</html>';

//print $mensagem; die;

$mens = "--$boundary" . $quebra_linha . ""; 
$mens .= "Content-Transfer-Encoding: 8bits" . $quebra_linha . ""; 
$mens .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $quebra_linha . $quebra_linha . ""; //plain 
$mens .= $mensagem . $quebra_linha . ""; 
$mens .= "--$boundary" . $quebra_linha . ""; 
$mens .= "Content-Type: application/vnd.ms-excel" . $quebra_linha . ""; 
$mens .= "Content-Disposition: attachment; filename=\"".$nome_arquivo."\"" . $quebra_linha . ""; 
$mens .= "Content-Transfer-Encoding: base64" . $quebra_linha . "" . $quebra_linha . ""; 
$mens .= "$anexo" . $quebra_linha . ""; 
$mens .= "--$boundary--" . $quebra_linha . ""; 

 
$headers = "MIME-Version: 1.0" . $quebra_linha . ""; 
$headers .= "From: $email_from " . $quebra_linha . ""; 
$headers .= "Return-Path: $email_from " . $quebra_linha . ""; 
$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"" . $quebra_linha . ""; 
$headers .= "$boundary" . $quebra_linha . ""; 
 
 
//envio o email com o anexo 
//print 'emails '.$emails.' assunto '.$assunto.' mens '.$mens.' headers '.$headers.' email_from '.$email_from; die;

if(!mail($emails,$assunto,$mens,$headers, "-r".$email_from))
	if(isset($_POST['email']))
		ExibeMensagem("Erro ao enviar arquivo"); 
else
	if(isset($_POST['email']))
		ExibeMensagem("Arquivo enviado com sucesso!");
?>