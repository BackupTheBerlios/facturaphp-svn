	  	<table width="90%" class="cajaMenu" cellpadding="3" cellspacing="0">
			<tr >
			  <td class="cabeceraMenu">.:Login:.</td>
			</tr>
			<tr class="textoMenuUsuarios">
				<form name="login" action="index.php" method=post>
				<td>
				
				{if $login == 1 }
				
				{if $error == 1}
				Usuario o contrase&ntilde;a inv&aacute;lidos<br>
				Vuelva a intentarlo<br>
				{/if}
				Usuario:<br> 
				<input type="text" class="textoMenuUsuarios"  name="user" id="user" size="17"><br>
					
			      Contrase&ntilde;a: <br> <input type="password" class="textoMenuUsuarios" name="passwd" id="pass" size="17"><br><br>
				  <input type="submit" name="submit" value="Entrar" class="botones"><br>
				  <a href="#">Recordar su contrase&ntilde;a</a>
				{/if}
				{if $login == 0 }
				
				Usuario:<br><br><b>{$user_name}</b><br><br> 
				<input type="submit" name="submit" value="Desconectar" class="botones">
			 	{/if}
			 	</td>
				</form>
			</tr>
		</table>
		<br>
