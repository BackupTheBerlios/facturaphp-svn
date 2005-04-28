<td valign="top">

{$cadena}
{include file=capas.tpl}
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de la categor&iacute;a </td>
				</tr>
			  </table>
				<br>
				<TABLE align = "center" width="80%">			
					<tr>
						<td valign="top">
							<table width="100%">
							<tr class="cabeceraMultiLinea">
								<td height="23" nowrap>Identificador de la categoría: {$objeto->id_cat_client}</td>
								<td width="50%" align="center">
								{section name="indice" loop=$acciones}				
				
						{if $acciones[indice]== 'modify'}
						<a href="index.php?module=cat_clients&method={$acciones[indice]}&id={$objeto->id_cat_client}">
						<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
						{else}
						<a href="index.php?module=cat_clients&method={$acciones[indice]}&id={$objeto->id_cat_client}">
						<img src="pics/btn{$acciones[indice]}.gif" border="0" ></a>
						{/if}
				
						{/section}
								</td>
							</tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Nombre:</td>
                                <td nowrap width="25%" class="datosVista">{$objeto->name}</td>
                              </tr>
                               <tr>
							  <td height="21" nowrap class="camposVistas">Descripci&oacute;n: </td>
							  <td colspan="3">&nbsp; </td>
							  </tr>
                
							<table class="cajaMenu" width="90%" align="center">
								<tr class="multiLinea1" ><td>{$objeto->descrip}</td></tr>
					  		</table>
					 		 
                    		  
							 <tr class="cabeceraMultiLinea">
								<td colspan="2">&nbsp;</td>
							</tr>	
						 	</table>
					   	</td>
					   
					</tr>	
			 </TABLE>
</td>
						
					
					