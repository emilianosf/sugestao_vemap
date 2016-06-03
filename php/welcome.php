<?php
ob_start();
	
print "<nav id=\"menu\">";
print "<ul>";

if(isset($_SESSION['nomeSession'])){
	print "<li><a href=\"index.php?op=2\" > Home <img src=\"img/home.png\" /></a></li>";
	print "<li><a href=\"index.php?op=1\">Sobre <img src=\"img/Information.png\" /></a></li>";
	print "<li>Seja bem vindo <b>$_SESSION[nomeSession]</b></li>";
	print "<li><a href=\"index.php?op=3\" > Logoff <img src=\"img/password2.png\" /></a></li>";
} else {
	print "<li><a href=\"index.php?op=0\" >Efetue o login <img src=\"img/permissao.png\" /></a></li>";
	unset($_SESSION['nomeSession']);
}
print "</ul>";
print "</nav>";

?>