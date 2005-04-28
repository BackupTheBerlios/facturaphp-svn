<td valign="top">

	{$cadena}
{include file=capas.tpl}

	  <table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Buscar contactos </td>
				</tr>
			  </table>
			  <table width="100%">
			  <tr><td class="message" align="center">{$message}</td></tr>
			  <tr><td valign="top"><form method="post" action="index.php?module=contacts&method=list">
			  	<table width="250px" align="center">
				 <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">B&uacute;squeda:</td>
				  </tr>
				  <tr>
				  <td width="125" class="CampoFormulario">Seleccione cliente:</td>
						<td><select name="client">		
						<option value="0" {if $objeto->client == 0 || $objeto->client=="" } selected{/if}>Seleccione un cliente...</option>				
						{section name="indice" loop=$clients}
						  <option value="{$clients[indice].id_client}"{if $objeto->client == $clients[indice].id_client} selected{/if}>{$clients[indice].name}</option>
						  {/section}
						</select></td>
				  </tr>
					  <tr>
						<td  width="125px" align="right" class="CampoFormulario">Introduzca su b&uacute;squeda:</td>
						<td><input type="text" id="{$objeto->ddbb_search}" name="{$objeto->ddbb_search}" value="{$objeto->search_query}" class="textoMenu"></td>
				  </tr>
				  
				    <tr>
						<td width="125" class="CampoFormulario">Nº de Registros por p&aacute;gina:</td>
						<td><select name="Registros">
						  <option selected>10</option>
						  <option>30</option>
						  <option>50</option>
						</select></td>
				 </tr>
				 <tr>
				 	<td align="center" colspan="2"><input type="submit" value="Buscar" name="submit_contacts_search" class="botones"></td>
				 </tr>
				  </table>
				</form><br>
				  <div name="divMostrar" id="divMostrar" >
						
					</div>	
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = contacts_1;
					  </script>
				  
			  </td></tr></table>
	  </td>
