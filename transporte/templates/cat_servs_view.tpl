<td valign="top">

{$cadena}


{include file=capas.tpl}
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de categor&iacute;a </td>
				</tr>
			  </table>
				<br>
				<TABLE width="100%">			
					<tr>
						<td valign="top">
							<table width="100%">
							<tr class="cabeceraMultiLinea">
								<td colspan="2" height="23" nowrap>Identificador de Categor&iacute;a: {$objeto->id_cat_serv}</td>
								<td colspan="2">&nbsp;</td>
							</tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Nombre:</td>
                                <td nowrap width="25%" class="datosVista">{$objeto->name}</td>
                                <td height="21" nowrap class="camposVistas">Categor&iacute;a Padre:</td>
                                <td nowrap class="datosVista">{if $objeto->id_parent_cat==0}Ninguna{else}
                                {section name="nombre" loop=$objeto->cat_servs_list}
							{if $objeto->id_parent_cat==$objeto->cat_servs_list[nombre].id_cat_serv}{$objeto->cat_servs_list[nombre].name}{/if}>
								
							
						{/section}	
						{/if}	
                                </td>  
                              </tr>
                              <tr>
								
                              </tr>
                              <tr>
								<td height="21" nowrap class="camposVistas">Descripci&oacute;n:</td>
                                <td nowrap class="datosVista">{$objeto->descrip}</td>
                                <td align="center" colspan="2">
									{section name="indice" loop=$acciones}			
									{if $acciones[indice]== 'modify'}
										<a href="index.php?module=cat_servs&method={$acciones[indice]}&id={$objeto->id_cat_serv}">
											<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
									{else}
										<a href="index.php?module=cat_servs&method={$acciones[indice]}&id={$objeto->id_cat_serv}">
											<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
									{/if}	
									{/section}
								</td>
                              </tr>
                    		  <tr>
								<td colspan="4" align="center">
                               <a href="index.php?module=cat_servs&method=show&id={$objeto->id_cat_serv}"><img src="{$objeto->path_photo}" height="120"></a>
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