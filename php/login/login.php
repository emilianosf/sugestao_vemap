<!--	CRIADO POR EMILIANO FILHO	-->
<!--	emilianosfilho@gmail.com 	-->

<link href="css/form2.css" rel="stylesheet" type="text/css"> 

<div id="stylized" class="myform">

		<form name="form1" id="form1" action="php/login/login_valida.php" method="post">

			<h1>LOGIN</h1>
            <p>O cadastro &eacute; necess&aacute;rio para acessar o sistema. Caso n&atilde;o tenha acesso 
            solicite <a href="index.php?op=6">clicando aqui</a></p>


            <table align="center" border="1">

            <tr>
            	<td><label>Login<span class="small">Login de acesso</span></label></td>
                <td><input type="text" name="login" id="login" /></td>
            </tr>
			
            <tr>
            	<td><label>Senha<span class="small">Senha de acesso</span></label></td>
                <td align="left"><input type="password" name="senha" id="senha" /></tr>
			
            <tr>
            	<td colspan="2">
                	<button type="submit" name="acao" value="excluir">Log in</button>
                </td>
            </tr>

			</table>

		
        <div class="spacer"></div>
		
        </form>

	</div><!--stylized-->  