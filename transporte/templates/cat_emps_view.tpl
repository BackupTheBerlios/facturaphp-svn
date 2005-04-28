<td valign="top">
{$cadena}

{include file=capas.tpl}
	
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						 <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de categor&iacute;a de empleados </td>
				</tr>
			  </table>
				<br>
				<TABLE width="95%" align="center">
					<tr class="cabeceraMultiLinea">
						<td width="50%" height="23" nowrap>Identificador de Categor&iacute;a: {$objeto->id_cat_emp}
						</td>
						<td nowrap width="50%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<table width="90%" align="center">
                                <tr height="15px">
                                <td width="25%" nowrap class="camposVistas">Nombre:</td>
                                <td width="25%" nowrap class="datosVista">{$objeto->name}</td>
								 <td>
								 	<table align="center"><tr>
								{section name="indice" loop=$acciones}

				<td>
				{if $acciones[indice]== 'modify'}
				<a href="index.php?module=cat_emps&method={$acciones[indice]}&id={$objeto->id_cat_emp}">
				<img src="pics/btn{$acciones[indice]}.gif" border="0"></a></td>
				{else}
				<td><a href="index.php?module=cat_emps&method={$acciones[indice]}&id={$objeto->id_cat_emp}">
				<img src="pics/btn{$acciones[indice]}.gif" border="0" ></a></td>
				{/if}
				
				{/section}
									</tr></table>
							</td>
								<td></td>
                              </tr>
                              <tr>
                              <td width="25%"  nowrap class="camposVistas">Descripción:</td>
                                <td nowrap width="25%" class="datosVista"></td>
                                <td></td>
                                <td></td>
                              </tr>
                            </table>
					
					<table class="cajaMenu" width="90%" align="center">
								<tr class="multiLinea1" ><td>{$objeto->descrip}</td></tr>
					  </table>
							
					  
  					  </td>
						
					</tr>
					
					<tr class="cabeceraMultiLinea">
						<td colspan="2">&nbsp;
						</td>
					</tr>
					
				</TABLE>
			</td>