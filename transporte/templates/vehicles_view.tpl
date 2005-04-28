<td valign="top">

{$cadena}


{include file=capas.tpl}
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de veh&iacute;culo </td>
				</tr>
			  </table>
				<br>
				<TABLE width="100%">			
					<tr>
						<td valign="top">
							<table width="100%">
							<tr class="cabeceraMultiLinea">
								<td height="23" nowrap>Identificador de Veh&iacute;culo: {$objeto->id_vehicle}</td>
								<td width="50%" nowrap align="center">
								{section name="indice" loop=$acciones}				
				
						{if $acciones[indice]== 'modify'}
						<a href="index.php?module=vehicles&method={$acciones[indice]}&id={$objeto->id_vehicle}">
						<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
						{else}
						<a href="index.php?module=vehicles&method={$acciones[indice]}&id={$objeto->id_vehicle}">
						<img src="pics/btn{$acciones[indice]}.gif" border="0" ></a>
						{/if}
				
						{/section}
								</td>
							</tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Alias:</td>
                                <td nowrap width="25%" class="datosVista">{$objeto->alias}</td>
                              </tr>
                              <tr>
								<td height="21" nowrap class="camposVistas">Matr&iacute;cula:</td>
                                <td nowrap class="datosVista">{$objeto->number_plate}</td>  
                              </tr>
                              <tr>
								<td height="21" nowrap class="camposVistas">Categor&iacute;a:</td>
                                <td nowrap class="datosVista">{$objeto->category}</td>  
                              </tr>
                    		  <tr>      
			      				<td align="center">
									{section name="indice" loop=$acciones}			
									{if $acciones[indice]== 'modify'}
										<a href="index.php?module=vehicles&method={$acciones[indice]}&id={$objeto->id_vehicle}">
											<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
									{else}
										<a href="index.php?module=vehicles&method={$acciones[indice]}&id={$objeto->id_vehicle}">
											<img src="pics/btn{$acciones[indice]}.gif" border="0" onClick="confirm('¿Desea borrar este registro?\nSi pulsa Sí se borrarán tambien los registros relacionados con este vehículo (p.ej: datos de vehículo)')"></a>
									{/if}	
									{/section}
								</td>
							 </tr>
							 <tr class="cabeceraMultiLinea">
								<td colspan="2">&nbsp;</td>
							</tr>	
						 	</table>
					   	</td>
					   	
					   <td>
                               <a href="index.php?module=vehicles&method=show&id={$objeto->id_vehicle}"><img src="{$objeto->path_photo}" height="120"></a>
					   </td>
					</tr>
					</tr>	
					
							
					
					<a name="listado">
					  <table align="center" width="400" cellspacing="0" cellpadding="0">
					  <tr>
					  <br>
							<p align="center" class="cabeceraCampoFormulario">Listados de conductores y peones</p>
					  <br>
					  </tr>
					  <tr>
					  	<td width="50%" align="center">
					<img src="pics/pestagna-driverssobre.gif" width="71" height="23"  name="boton" id="drivers" onClick="Ocultar(this,'drivers_1')"> 					</td>
					  	<td width="50%"  align="center">
					<img src="pics/pestagna-laborers.gif" width="71" height="23" id="laborers" name="boton" onClick="Ocultar(this,'laborers_1')">
						</td>
					  	
					  </tr>
					  	<td align="center" colspan="2"><img src="pics/barra.gif"></td>
					  </table>

					  <br>
					 
					  <div name="divMostrar" id="divMostrar" >
						
					</div>					
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = laborers_1;
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