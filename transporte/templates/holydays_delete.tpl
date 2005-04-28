<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar Empleados </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=holydays&method=delete&id={$objeto->id_holy}">			  
			  
			  <br>
			  <p>Se va a proceder al borrado de una baja/alta; Baja:{$objeto->gone} Alta:{$objeto->come} Motivo:{if $objeto->ill==0}Enfermedad{else}{if  $objeto->ill==1}Vacaciones{else}Otros{/if}{/if}</p>
			  
			  {$message}
  			  <br>
  			  <p>¿Desea continuar?</p>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>