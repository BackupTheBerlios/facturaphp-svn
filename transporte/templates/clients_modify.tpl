<td valign="top">
<form method="post" action="index.php?module=clients&method=modify&id={$objeto->id_client}" name="form_central">
<script src="inc/calendar.js" type="text/javascript" language="javascript"></script>
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>Modificar Cliente</td>
			  </tr>
		  </table>
						<br>
		<table width="250px" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos del cliente:</td>
				  </tr>
					
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre:</td>
						<td> <input type="text" id="{$objeto->ddbb_name}" name="{$objeto->ddbb_name}" value="{$objeto->name}" class="textoMenu"><font class="error">{$error_name}</font></td>
					</tr>
					 <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre Completo:</td>
						<td> <input type="text" id="{$objeto->ddbb_name}" name="{$objeto->ddbb_full_name}" value="{$objeto->full_name}" class="textoMenu"><font class="error">{$error_full_name}</font></td>
					</tr>
					<tr>
						<td width="125" class="CampoFormulario">Categoria:</td>
						<td><select name="{$objeto->ddbb_id_cat_client}">						
						<option value="{$categorias[indice].id_cat_client}"{if $objeto->id_cat_client == "" || $objeto->id_cat_client == 0 } selected{/if}>Ninguna</option>
						{section name="indice" loop=$categorias}
						  <option value="{$categorias[indice].id_cat_client}"{if $objeto->id_cat_client == $categorias[indice].id_cat_client} selected{/if}>{$categorias[indice].name}</option>						 
						  {/section}
						</select></td>
				 </tr>
					 <tr>
						<td width="125px" align="right" class="CampoFormulario">CIF/NIF:</td>
						<td> <input type="text" id="{$objeto->ddbb_cif_nif}" name="{$objeto->ddbb_cif_nif}" value="{$objeto->cif_nif}" class="textoMenu"><font class="error">{$error_cif_nif}</font></td>
					</tr>
					<tr>
						<td width="125px" align="right" class="CampoFormulario">Direcci&oacute;n:</td>
						<td> <input type="text" id="{$objeto->ddbb_address}" name="{$objeto->ddbb_address}" value="{$objeto->address}" class="textoMenu"><font class="error">{$error_address}</font></td>
					</tr>
					<tr>
						<td width="125px" align="right" class="CampoFormulario">Direcci&oacute;n Fiscal:</td>
						<td> <input type="text" id="{$objeto->ddbb_fiscal_address}" name="{$objeto->ddbb_fiscal_address}" value="{$objeto->fiscal_address}" class="textoMenu"><font class="error">{$error_fiscal_address}</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Direcci&oacute;n Postal:</td>
						<td> <input type="text" id="{$objeto->ddbb_postal_address}" name="{$objeto->ddbb_postal_address}" value="{$objeto->postal_address}" class="textoMenu"><font class="error">{$error_postal_address}</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">C&oacute;digo Postal:</td>
						<td> <input type="text" id="{$objeto->ddbb_postal_code}" name="{$objeto->ddbb_postal_code}" value="{$objeto->postal_code}" class="textoMenu"><font class="error">{$error_postal_code}</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Ciudad:</td>
						<td> <input type="text" id="{$objeto->ddbb_city}" name="{$objeto->ddbb_city}" value="{$objeto->city}" class="textoMenu"><font class="error">{$error_city}</font></td>
					</tr>
										<tr>
					<td width="125px" align="right" class="CampoFormulario">Provincia:</td>
						<td> <input type="text" id="{$objeto->ddbb_state}" name="{$objeto->ddbb_state}" value="{$objeto->state}" class="textoMenu"><font class="error">{$error_state}</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Pa&iacute;s:</td>
						<td> <input type="text" id="{$objeto->ddbb_country}" name="{$objeto->ddbb_country}" value="{$objeto->country}" class="textoMenu"><font class="error">{$error_country}</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Tel&eacute;fono:</td>
						<td> <input type="text" id="{$objeto->ddbb_phone}" name="{$objeto->ddbb_phone}" value="{$objeto->phone}" class="textoMenu"><font class="error">{$error_phone}</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Tel&eacute;fono:</td>
						<td> <input type="text" id="{$objeto->ddbb_mobile_phone}" name="{$objeto->ddbb_mobile_phone}" value="{$objeto->mobile_phone}" class="textoMenu"><font class="error">{$error_mobile_phone}</font></td>
					</tr>					
															<tr>
						<td width="125px" align="right" class="CampoFormulario">Fax:</td>
						<td> <input type="text" id="{$objeto->ddbb_fax}" name="{$objeto->ddbb_fax}" value="{$objeto->fax}" class="textoMenu"><font class="error">{$error_fax}</font></td>
					</tr>
															<tr>
						<td width="125px" align="right" class="CampoFormulario">P&aacute;gina Web:</td>
						<td> <input type="text" id="{$objeto->ddbb_url}" name="{$objeto->ddbb_url}" value="{$objeto->url}" class="textoMenu"><font class="error">{$error_url}</font></td>
					</tr>
															<tr>
						<td width="125px" align="right" class="CampoFormulario">E-Mail:</td>
						<td> <input type="text" id="{$objeto->ddbb_mail}" name="{$objeto->ddbb_mail}" value="{$objeto->mail}" class="textoMenu"><font class="error">{$error_mail}</font></td>
					</tr>
					  	
					<tr>
						<td width="125" class="CampoFormulario">Forma t&iacute;pica de pago:</td>
						<td><select name="{$objeto->ddbb_id_pay_type}">
						<option value="{$tipo_pago[indice].id_pay_type}"{if $objeto->id_pay_type == "" || $objeto->id_pay_type == 0 } selected{/if}>Ninguna</option>
						{section name="indice" loop=$tipo_pago}
						  <option value="{$tipo_pago[indice].id_pay_type}"{if $objeto->id_pay_type == $tipo_pago[indice].id_pay_type} selected{/if}>{$tipo_pago[indice].name}</option>						 
						  {/section}
						</select></td>
				 </tr>
					<tr>
						<td width="125" class="CampoFormulario" nowrap>Fecha de pago:</td>
						<td > 
							<input class="textoMenu" type="text" id="{$objeto->ddbb_payday}" name="{$objeto->ddbb_payday}"  value="{$objeto->payday}" size="15" maxlength="99" class="textfield">
                                    <script type="text/javascript">
                                    
                    <!--
                    document.write('<a title="Calendario" href="javascript:openCalendar(\'lang=es-utf-8&amp;server=1\', \'form_central\', \'{$objeto->ddbb_payday}\', \'date\')"><img class="calendar" valign="center" src="pics/calendar.png" alt="Calendario"/></a>');
                    //-->
                    </script>
		    
						<font class="error">{$error_payday}</font>
						</td>
				 </tr>	
				<tr>
						<td width="125" align="right" class="CampoFormulario">Notas:</td>
						<td rowspan="2" ><textarea name="{$objeto->ddbb_notes}" class="textoMenu" id="{$objeto->ddbb_notes}">{$objeto->notes}</textarea><font class="error">{$error_notes}</font></td>
					</tr>	  
		</table>
		</td>
		</tr>	

		<tr>
			<td align="center"><br><br>
			<input type="submit" name="submit_modify" id ="submit_modify" "value="Modificar" class="botones">			
			<input type="reset" Value="Limpiar Datos" class="botones">
			</td>
		</tr>
	  	</table>
	</form>
</td>