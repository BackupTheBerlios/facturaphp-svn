<?php /* Smarty version 2.6.3, created on 2005-03-22 12:09:48
         compiled from cat_vehicles_modify.tpl */ ?>
<td valign="top">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "checkbox.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form method="post" action="index.php?module=cat_vehicles&method=modify&id=<?php echo $this->_tpl_vars['objeto']->id_cat_vehicle; ?>
" name="form_central" enctype="multipart/form-data">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>Modificaci&oacute;n de categor&iacute;as de veh&iacute;culos</td>
								</tr>
						</table>
						<br>
		<table width="250px" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos de la categor&iacute;a:</td>
				  </tr>
					<tr>
						<td width="125px" align="right" class="CampoFormulario" nowrap>Nombre de la categor&iacute;a:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->name; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_name']; ?>
</font></td>
					</tr>
					<tr>
						<td width="125px" class="CampoFormulario">Nombre de la categor&iacute;a en la web:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name_web; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name_web; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->name_web; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_name_web']; ?>
</font></td>
				  </tr>
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Descripci&oacute;n:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_descrip; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_descrip; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->descrip; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_descrip']; ?>
</font></td>
				  </tr>
				 
		 
				</table>
		</td>
		</tr>				
		<tr>
			<td align="center"><br><br><input type="submit" name="submit_modify" value="Modificar" class="botones">

			<input type="reset" Value="Borrar Datos" class="botones">
			</td>
		</tr>
	
	  	</table> 
	</form>
</td>