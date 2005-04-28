<td valign="top">
{$cadena}

{include file=capas.tpl}
	
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						 <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de usuarios </td>
				</tr>
			  </table>
				<br>
				<TABLE width="95%" align="center">
					<tr class="cabeceraMultiLinea">
						<td width="50%" height="23" nowrap>Identificador de Usuario: {$objeto->id_user}
						</td>
						<td nowrap width="50%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<table width="90%" align="center">
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Login:</td>
                                <td nowrap width="25%" class="datosVista">{$objeto->login}</td>
								<td height="21" nowrap class="camposVistas">Contrase&ntilde;a:</td>
                                <td nowrap class="datosVista"> <!--{$objeto->passwd}-->********</td>
                                
                              </tr>
                              
                              <tr height="15px">
                                <td width="25%" nowrap class="camposVistas">Nombre:</td>
                                <td width="25%" nowrap class="datosVista">{$objeto->name}</td>
								 <td width="25%"  nowrap class="camposVistas">Primer Apellido: </td>
                                 <td width="25%" class="datosVista">{$objeto->last_name}</td>
                                
                              </tr>
                              <tr height="15px">                               
                               <td height="21" nowrap class="camposVistas">Segundo Apellido: </td>
                                <td nowrap class="datosVista">{$objeto->last_name2}</td>
								<td><table align="center"><tr>

				{section name="indice" loop=$acciones}
				
				<td>
				{if $acciones[indice]== 'modify'}
				<a href="index.php?module=users&method={$acciones[indice]}&id={$objeto->id_user}">
				<img src="pics/btn{$acciones[indice]}.gif" border="0"></a></td>
				{else}
				<td><a href="index.php?module=users&method={$acciones[indice]}&id={$objeto->id_user}">
				<img src="pics/btn{$acciones[indice]}.gif" border="0" ></a></td>
				{/if}
				
				{/section}
								
							</tr>	</table></td>
								<td></td>
                              </tr>
                            </table>
							<br>
							<p align="center" class="cabeceraCampoFormulario">Listados de permisos por m&oacute;dulos y grupos</p>
							<br>
					<a name="listado">
					  <table align="center" width="400" cellspacing="0" cellpadding="0">
					  <tr>
					  	<td width="50%" align="center">
					<img src="pics/pestagna-modulessobre.gif" width="71" height="23"  name="boton" id="modules" onClick="Ocultar(this,'modules_1')"> 					</td>
					  	<td width="50%"  align="center">
					<img src="pics/pestagna-group_users.gif" width="71" height="23" id="group_users" name="boton" onClick="Ocultar(this,'group_users_1')">
						</td>
					  	
					  </tr>
					  	<td align="center" colspan="2"><img src="pics/barra.gif"></td>
					  </table>

					  <br>
					 
					  <div name="divMostrar" id="divMostrar" >
						
					</div>					
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = modules_1;
					  </script>
					  <br>
					  <table align="center" width="400" cellpadding="0" cellspacing="0">
						  <tr><td><img src="pics/barra.gif"></td></tr>
					  </table>
					  <br>
					  
  					  </td>
						
					</tr>
					
					<tr class="cabeceraMultiLinea">
						<td colspan="2">&nbsp;
						</td>
					</tr>
					
				</TABLE>
			</td>