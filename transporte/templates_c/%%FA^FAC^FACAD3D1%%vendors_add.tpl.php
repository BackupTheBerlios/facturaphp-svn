<?php /* Smarty version 2.6.3, created on 2005-03-17 12:22:13
         compiled from vendors_add.tpl */ ?>
<td valign="top">
<form method="post" action="index.php?module=vendors&method=add" name="form_central">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>A&ntilde;adir Provedor</td>
			  </tr>
		  </table>
						<br>
		<table width="250px" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos de la empresa:</td>
				  </tr>
					
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" value="<?php echo $this->_tpl_vars['objeto']->name; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_name']; ?>
</font></td>
					</tr>
					 <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre Completo:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_full_name; ?>
" value="<?php echo $this->_tpl_vars['objeto']->full_name; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_full_name']; ?>
</font></td>
					</tr>
					 <tr>
						<td width="125px" align="right" class="CampoFormulario">CIF/NIF:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_cif_nif; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_cif_nif; ?>
" value="<?php echo $this->_tpl_vars['objeto']->cif_nif; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_cif_nif']; ?>
</font></td>
					</tr>
					<tr>
						<td width="125px" align="right" class="CampoFormulario">Direcci&oacute;n:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_address; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_address; ?>
" value="<?php echo $this->_tpl_vars['objeto']->address; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_address']; ?>
</font></td>
					</tr>
					<tr>
						<td width="125px" align="right" class="CampoFormulario">Direcci&oacute;n Fiscal:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_fiscal_address; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_fiscal_address; ?>
" value="<?php echo $this->_tpl_vars['objeto']->fiscal_address; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_fiscal_address']; ?>
</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Direcci&oacute;n Postal:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_postal_address; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_postal_address; ?>
" value="<?php echo $this->_tpl_vars['objeto']->postal_address; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_postal_address']; ?>
</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">C&oacute;digo Postal:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_postal_code; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_postal_code; ?>
" value="<?php echo $this->_tpl_vars['objeto']->postal_code; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_postal_code']; ?>
</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Ciudad:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_city; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_city; ?>
" value="<?php echo $this->_tpl_vars['objeto']->city; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_city']; ?>
</font></td>
					</tr>
										<tr>
					<td width="125px" align="right" class="CampoFormulario">Provincia:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_state; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_state; ?>
" value="<?php echo $this->_tpl_vars['objeto']->state; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_state']; ?>
</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Pa&iacute;s:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_country; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_country; ?>
" value="<?php echo $this->_tpl_vars['objeto']->country; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_country']; ?>
</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Tel&eacute;fono:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_phone; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_phone; ?>
" value="<?php echo $this->_tpl_vars['objeto']->phone; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_phone']; ?>
</font></td>
					</tr>
										<tr>
						<td width="125px" align="right" class="CampoFormulario">Tel&eacute;fono:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_mobile_phone; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_mobile_phone; ?>
" value="<?php echo $this->_tpl_vars['objeto']->mobile_phone; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_mobile_phone']; ?>
</font></td>
					</tr>					
															<tr>
						<td width="125px" align="right" class="CampoFormulario">Fax:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_fax; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_fax; ?>
" value="<?php echo $this->_tpl_vars['objeto']->fax; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_fax']; ?>
</font></td>
					</tr>
															<tr>
						<td width="125px" align="right" class="CampoFormulario">P&aacute;gina Web:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_url; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_url; ?>
" value="<?php echo $this->_tpl_vars['objeto']->url; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_url']; ?>
</font></td>
					</tr>
															<tr>
						<td width="125px" align="right" class="CampoFormulario">E-Mail:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_mail; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_mail; ?>
" value="<?php echo $this->_tpl_vars['objeto']->mail; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_mail']; ?>
</font></td>
					</tr>
					  <tr>
						<td width="125" align="right" class="CampoFormulario">Notas:</td>
						<td rowspan="2" ><textarea name="<?php echo $this->_tpl_vars['objeto']->ddbb_notes; ?>
" class="textoMenu" id="<?php echo $this->_tpl_vars['objeto']->ddbb_notes; ?>
"><?php echo $this->_tpl_vars['objeto']->notes; ?>
</textarea><font class="error"><?php echo $this->_tpl_vars['error_notes']; ?>
</font></td>
					</tr>				  
		</table>
		</td>
		</tr>	

		<tr>
			<td align="center"><br><br>
			<input type="submit" name="submit_add" id =" name="submit_add" "value="A&ntilde;adir" class="botones">			
			<input type="reset" Value="Limpiar Datos" class="botones">
			</td>
		</tr>
	  	</table>
	</form>
</td>