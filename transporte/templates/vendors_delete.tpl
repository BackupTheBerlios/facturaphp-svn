<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar empresa proveedora</td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=vendors&method=delete&id={$objeto->id_vendor}">			  
			  
			  <br>
			  <p>Se va a proceder al borrado de la empresa proveedora: {$objeto->name}|{$objeto->full_name}</p>
			 
			  {$message}
  			  <br>
  			  <P>¿Esta seguro de continuar?</p>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>
