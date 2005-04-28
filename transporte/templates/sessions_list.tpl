<td valign="top">
{$cadena}
	{php}
		echo $this->_tpl_vars['cadena'];
	{/php}

{include file=capas.tpl}

	  <table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%"> 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Listado sesiones </td>
				</tr>
				 
			  </table>
			   <table width="100%">
			  <tr><td valign="top"><form method="post" action="index.php?module=sessions&method=list" name="form_searchs">
			  	
			  	<table width="250px" align="center">
				    <tr>
						<td width="125" class="CampoFormulario">N� de Registros por p&aacute;gina:</td>
						<td><select name="regs">
						  <option {if $registro == 10}selected{/if}>10</option>
						  <option {if $registro == 30}selected{/if}>30</option>
						  <option {if $registro == 50}selected{/if}>50</option>
						</select></td>
				 </tr>
				 <tr>
				 	<td colspan="2"><input type="submit" value="Cambiar n� de registros" name="submit_sessions_reg" class="botones"></td>
				 </tr>
				  </table>
				</form><br>
				 </tr></table>
			  
			  <table width="100%>
			  <tr><td class="message" align="center">{$message}</td></tr>
			  <tr><td valign="top"><form method="post" action="index.php?module=sessions&method=list">
			  	
				</form><br>
				  <div name="divMostrar" id="divMostrar" >
						
					</div>	
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = sessions_1;
					  </script>
			  </td></tr></table>
	  </td>
