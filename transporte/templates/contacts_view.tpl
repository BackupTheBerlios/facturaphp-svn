<td valign="top">
{$cadena}

{include file=capas.tpl}
	
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						 <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de contactos </td>
				</tr>
			  </table>
				<br>
				<TABLE width="95%" align="center">
					<tr class="cabeceraMultiLinea">
						<td width="50%" height="23" nowrap>Identificador de Contacto: {$objeto->id_contact}
						</td>
						<td nowrap width="50%">
						{section name="indice" loop=$acciones}
						{if $acciones[indice]== 'modify'}
							<a href="index.php?module=clients&method={$acciones[indice]}&id={$objeto->id_contact}">
							<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
						{else}
							<a href="index.php?module=clients&method={$acciones[indice]}&id={$objeto->id_contact}">
							<img src="pics/btn{$acciones[indice]}.gif" border="0" ></a>
						{/if}				
				{/section}
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table width="90%" align="center">                             
                              
                              <tr height="15px">
                                <td width="25%" nowrap class="camposVistas">Nombre:</td>
                                <td width="25%" nowrap class="datosVista">{$objeto->name}</td>
								 <td width="25%"  nowrap class="camposVistas">Direcci&oacute;n: </td>
                                 <td width="25%" class="datosVista">{$objeto->address}</td>
                                
                              </tr>
                              <tr height="15px">
                               <td width="25%"  nowrap class="camposVistas">Primer Apellido: </td>
                                 <td width="25%" class="datosVista">{$objeto->last_name}</td>
                               <td width="25%"  nowrap class="camposVistas">Provincia: </td>
                                 <td width="25%" class="datosVista">{$objeto->state}</td>
								 
                                
                              </tr>
                              <tr height="15px">
                              <td height="21" nowrap class="camposVistas">Segundo Apellido: </td>
                                <td nowrap class="datosVista">{$objeto->last_name2}</td>
                               <td height="21" nowrap class="camposVistas">Ciudad: </td>
                                <td nowrap class="datosVista">{$objeto->city}</td>
								 
                                
                              </tr>
                              <tr height="15px">
                               <td height="21" nowrap class="camposVistas">Pa&iacute;s: </td>
                                <td nowrap class="datosVista">{$objeto->country}</td>
								 <td width="25%"  nowrap class="camposVistas">C&oacute;digo Postal: </td>
                                 <td width="25%" class="datosVista">{$objeto->postal_code}</td>                                
                              </tr>
                              <tr height="15px">
                               <td height="21" nowrap class="camposVistas">Tel&eacute;fono: </td>
                                <td nowrap class="datosVista">{$objeto->phone}</td>
								 <td width="25%"  nowrap class="camposVistas">Tel&eacute;fono M&oacute;vil: </td>
                                 <td width="25%" class="datosVista">{$objeto->mobile_phone}</td>                                
                              </tr>
                              <tr height="15px">
                               <td height="21" nowrap class="camposVistas">Fecha nacimiento: </td>
                                <td nowrap class="datosVista">{$objeto->birthday}</td>
								 <td width="25%"  nowrap class="camposVistas">E-mail: </td>
                                 <td width="25%" class="datosVista">{$objeto->mail}</td>                                
                              </tr>
                            
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