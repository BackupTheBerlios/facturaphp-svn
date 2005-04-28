<td valign="top">
{$cadena}

{include file=capas.tpl}
	
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						 <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de grupo </td>
				</tr>
			  </table>
				<br>
				<TABLE width="95%" align="center">
					<tr class="cabeceraMultiLinea">
						<td width="50%" height="23" nowrap>Identificador de Grupo: {$objeto->id_group}
						</td>
						<td nowrap width="50%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<table width="90%" align="center">
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Nombre:</td>
                                <td nowrap width="25%" class="datosVista">{$objeto->name}</td>
								<td height="21" nowrap class="camposVistas">Nombre Web:</td>
                                <td nowrap class="datosVista"> {$objeto->name_web}</td>
                                
                              </tr>                              
                           
                              <tr height="15px">                               
                               <td height="21" nowrap class="camposVistas">Descripción: </td><td>&nbsp;</td>
								<td><table align="center"><tr><td></td>
				{section name="indice" loop=$acciones}
				
				<td>
				{if $acciones[indice]== 'modify'}
				<a href="index.php?module=groups&method={$acciones[indice]}&id={$objeto->id_group}">
				<img src="pics/btn{$acciones[indice]}.gif" border="0"></a></td>
				{else}
				<td><a href="index.php?module=groups&method={$acciones[indice]}&id={$objeto->id_group}">
				<img src="pics/btn{$acciones[indice]}.gif" border="0" ></a></td>
				{/if}
				
				{/section}

							</tr>	</table>
							</td>
								<td></td>
                              </tr>
                            </table>
                       <table class="cajaMenu" width="90%" align="center">
								<tr class="multiLinea1" ><td>{$objeto->descrip}</td></tr>
					  </table>
							<br>
							<p align="center" class="cabeceraCampoFormulario">Listados de permisos por m&oacute;dulos</p>
							<br>
					<a name="listado">
					  <table align="center" width="400" cellspacing="0" cellpadding="0">
					  <tr>
					  	<td width="100%" align="center">
					<img src="pics/pestagna-modulessobre.gif" width="71" height="23"  name="boton" id="modules" onClick="Ocultar(this,'modules_1')"> 					
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