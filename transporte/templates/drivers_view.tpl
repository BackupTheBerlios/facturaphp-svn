<td valign="top">

{$cadena}


{include file=capas.tpl}
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de conductores </td>
				</tr>
				
			  </table>
				
				<TABLE width="100%">		
				<tr class="cabeceraMultiLinea" width="100%">
				<td colspan="2">&nbsp;</td>	
				</tr>	
					<tr>
						<td valign="top">
							<table width="100%">
							
                              <tr height="15px">
                                 <td width="25%" nowrap class="camposVistas">Nombre:</td>
                                 <td width="25%" nowrap class="datosVista">{$objeto->name}</td>
								 <td width="25%"  nowrap class="camposVistas">Primer Apellido: </td>
                                 <td width="25%" class="datosVista">{$objeto->last_name}</td>
                              </tr>
                              <tr>
								<td height="21" nowrap class="camposVistas">Segundo Apellido: </td>
                                <td nowrap class="datosVista">{$objeto->last_name2}</td>                        
                                <td height="21" nowrap class="camposVistas">Empleado: </td>
                                <td nowrap class="datosVista">{$emp_driver}</td>
                              </tr>
                    		  <tr>      
			      				<td align="center">
									{section name="indice" loop=$acciones}			
									{if $acciones[indice]== 'modify'}
										<a href="index.php?module=drivers&method={$acciones[indice]}&id={$objeto->id_driver}">
										<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
									{else}
										<a href="index.php?module=drivers&method={$acciones[indice]}&id={$objeto->id_driver}">
										<img src="pics/btn{$acciones[indice]}.gif" border="0" onClick="confirm('¿Desea borrar este registro?\nSi pulsa Sí se borrarán tambien los registros relacionados con este conductor')"></a>
									{/if}	
									{/section}
								</td>
							 </tr>
								
						 	</table>
					   		<br>
							<p align="center" class="cabeceraCampoFormulario">Listados de vehículos asignados al conductor</p>
							<br>
					<a name="listado">
					  <table align="center" width="400" cellspacing="0" cellpadding="0">
					  <tr>
					  	
					  	
					  </tr>
					  	<td align="center" colspan="2"><img src="pics/barra.gif"></td>
					  </table>

					  <br>
					 
					  <div name="divMostrar" id="divMostrar" >
						
					</div>					
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = drivers_1;
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