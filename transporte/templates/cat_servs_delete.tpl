<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar categor&iacute;as de servicio </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=cat_servs&method=delete&id={$objeto->id_cat_serv}">			  
			  
			  <br>
			  <p>Se va a proceder al borrado de la categor&iacute;a: {$objeto->name}</p>
			  <p>Todas las categor&iacute;as que puedan tener a &eacute;sta como categor&iacute;a padre, no se borrar&aacute;n.
			  {$message}
  			  <br>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>