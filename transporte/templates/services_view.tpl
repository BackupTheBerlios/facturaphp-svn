<td valign="top">

{$cadena}


{include file=capas.tpl}
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de servicio </td>
				</tr>
			  </table>
				<br>
				<TABLE width="100%">			
					<tr>
						<td valign="top">
							<table width="100%">
							<tr class="cabeceraMultiLinea">
								<td colspan="2" height="23" nowrap>Identificador de Servicio: {$objeto->id_service}</td>
								<td align="center" colspan="2">
									{section name="indice" loop=$acciones}			
									{if $acciones[indice]== 'modify'}
										<a href="index.php?module=services&method={$acciones[indice]}&id={$objeto->id_service}">
											<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
									{else}
										<a href="index.php?module=services&method={$acciones[indice]}&id={$objeto->id_service}">
											<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
									{/if}	
									{/section}
								</td>
							</tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Nombre:</td>
                                <td nowrap width="25%" class="datosVista">{$objeto->name}</td>
                                <td height="21" nowrap class="camposVistas">Nombre Web:</td>
                                <td nowrap class="datosVista">{$objeto->name_web}</td>  
                              </tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Precio:</td>
                                <td nowrap width="25%" class="datosVista">{$objeto->pvp}</td>
                                <td height="21" nowrap class="camposVistas">IVA:</td>
                                <td nowrap class="datosVista">{$objeto->tax}</td>  
                              </tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Precio con IVA:</td>
                                <td nowrap width="25%" class="datosVista">{$objeto->pvp_tax}</td>
                                <td height="21" nowrap class="camposVistas">Stock minimo:</td>
                                <td nowrap class="datosVista">{$objeto->minimun_stock}</td>  
                              </tr>
                              <tr>
								<td colspan="4" align="center">
                               <a href="index.php?module=services&method=show&id={$objeto->id_service}"><img src="{$objeto->path_photo}" height="120"></a>
					   </td>                               
                              </tr>
                    		
							 <tr>      
			      				
							 </tr>
					  		</tr>
							 <tr class="cabeceraMultiLinea">
								<td colspan="4">&nbsp;</td>
							</tr>	
						 	</table>
					   	</td>
					   
					</tr>	
			 </TABLE>
</td>