<?php /* Smarty version 2.6.3, created on 2005-04-06 13:29:47
         compiled from clients_modify.tpl */ ?>
<td valign="top">
<form method="post" action="index.php?module=clients&method=modify&id=<?php echo $this->_tpl_vars['objeto']->id_client; ?>
" name="form_central">
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
						<td width="125" class="CampoFormulario">Categoria:</td>
						<td><select name="<?php echo $this->_tpl_vars['objeto']->ddbb_id_cat_client; ?>
">						
						<option value="<?php echo $this->_tpl_vars['categorias'][$this->_sections['indice']['index']]['id_cat_client']; ?>
"<?php if ($this->_tpl_vars['objeto']->id_cat_client == "" || $this->_tpl_vars['objeto']->id_cat_client == 0): ?> selected<?php endif; ?>>Ninguna</option>
						<?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=$this->_tpl_vars['categorias']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['indice']['show'] = true;
$this->_sections['indice']['max'] = $this->_sections['indice']['loop'];
$this->_sections['indice']['step'] = 1;
$this->_sections['indice']['start'] = $this->_sections['indice']['step'] > 0 ? 0 : $this->_sections['indice']['loop']-1;
if ($this->_sections['indice']['show']) {
    $this->_sections['indice']['total'] = $this->_sections['indice']['loop'];
    if ($this->_sections['indice']['total'] == 0)
        $this->_sections['indice']['show'] = false;
} else
    $this->_sections['indice']['total'] = 0;
if ($this->_sections['indice']['show']):

            for ($this->_sections['indice']['index'] = $this->_sections['indice']['start'], $this->_sections['indice']['iteration'] = 1;
                 $this->_sections['indice']['iteration'] <= $this->_sections['indice']['total'];
                 $this->_sections['indice']['index'] += $this->_sections['indice']['step'], $this->_sections['indice']['iteration']++):
$this->_sections['indice']['rownum'] = $this->_sections['indice']['iteration'];
$this->_sections['indice']['index_prev'] = $this->_sections['indice']['index'] - $this->_sections['indice']['step'];
$this->_sections['indice']['index_next'] = $this->_sections['indice']['index'] + $this->_sections['indice']['step'];
$this->_sections['indice']['first']      = ($this->_sections['indice']['iteration'] == 1);
$this->_sections['indice']['last']       = ($this->_sections['indice']['iteration'] == $this->_sections['indice']['total']);
?>
						  <option value="<?php echo $this->_tpl_vars['categorias'][$this->_sections['indice']['index']]['id_cat_client']; ?>
"<?php if ($this->_tpl_vars['objeto']->id_cat_client == $this->_tpl_vars['categorias'][$this->_sections['indice']['index']]['id_cat_client']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['categorias'][$this->_sections['indice']['index']]['name']; ?>
</option>						 
						  <?php endfor; endif; ?>
						</select></td>
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
						<td width="125" class="CampoFormulario">Forma t&iacute;pica de pago:</td>
						<td><select name="<?php echo $this->_tpl_vars['objeto']->ddbb_id_pay_type; ?>
">
						<option value="<?php echo $this->_tpl_vars['tipo_pago'][$this->_sections['indice']['index']]['id_pay_type']; ?>
"<?php if ($this->_tpl_vars['objeto']->id_pay_type == "" || $this->_tpl_vars['objeto']->id_pay_type == 0): ?> selected<?php endif; ?>>Ninguna</option>
						<?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=$this->_tpl_vars['tipo_pago']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['indice']['show'] = true;
$this->_sections['indice']['max'] = $this->_sections['indice']['loop'];
$this->_sections['indice']['step'] = 1;
$this->_sections['indice']['start'] = $this->_sections['indice']['step'] > 0 ? 0 : $this->_sections['indice']['loop']-1;
if ($this->_sections['indice']['show']) {
    $this->_sections['indice']['total'] = $this->_sections['indice']['loop'];
    if ($this->_sections['indice']['total'] == 0)
        $this->_sections['indice']['show'] = false;
} else
    $this->_sections['indice']['total'] = 0;
if ($this->_sections['indice']['show']):

            for ($this->_sections['indice']['index'] = $this->_sections['indice']['start'], $this->_sections['indice']['iteration'] = 1;
                 $this->_sections['indice']['iteration'] <= $this->_sections['indice']['total'];
                 $this->_sections['indice']['index'] += $this->_sections['indice']['step'], $this->_sections['indice']['iteration']++):
$this->_sections['indice']['rownum'] = $this->_sections['indice']['iteration'];
$this->_sections['indice']['index_prev'] = $this->_sections['indice']['index'] - $this->_sections['indice']['step'];
$this->_sections['indice']['index_next'] = $this->_sections['indice']['index'] + $this->_sections['indice']['step'];
$this->_sections['indice']['first']      = ($this->_sections['indice']['iteration'] == 1);
$this->_sections['indice']['last']       = ($this->_sections['indice']['iteration'] == $this->_sections['indice']['total']);
?>
						  <option value="<?php echo $this->_tpl_vars['tipo_pago'][$this->_sections['indice']['index']]['id_pay_type']; ?>
"<?php if ($this->_tpl_vars['objeto']->id_pay_type == $this->_tpl_vars['tipo_pago'][$this->_sections['indice']['index']]['id_pay_type']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['tipo_pago'][$this->_sections['indice']['index']]['name']; ?>
</option>						 
						  <?php endfor; endif; ?>
						</select></td>
				 </tr>
					<tr>
						<td width="125" class="CampoFormulario" nowrap>Fecha de pago:</td>
						<td > 
							<input class="textoMenu" type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_payday; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_payday; ?>
"  value="<?php echo $this->_tpl_vars['objeto']->payday; ?>
" size="15" maxlength="99" class="textfield">
                                    <script type="text/javascript">
                                    
                    <!--
                    document.write('<a title="Calendario" href="javascript:openCalendar(\'lang=es-utf-8&amp;server=1\', \'form_central\', \'<?php echo $this->_tpl_vars['objeto']->ddbb_payday; ?>
\', \'date\')"><img class="calendar" valign="center" src="pics/calendar.png" alt="Calendario"/></a>');
                    //-->
                    </script>
		    
						<font class="error"><?php echo $this->_tpl_vars['error_payday']; ?>
</font>
						</td>
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
			<input type="submit" name="submit_modify" id ="submit_modify" "value="Modificar" class="botones">			
			<input type="reset" Value="Limpiar Datos" class="botones">
			</td>
		</tr>
	  	</table>
	</form>
</td>