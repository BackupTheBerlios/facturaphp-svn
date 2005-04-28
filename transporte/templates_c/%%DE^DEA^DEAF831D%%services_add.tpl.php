<?php /* Smarty version 2.6.3, created on 2005-02-28 20:56:11
         compiled from services_add.tpl */ ?>
<td valign="top">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "checkbox.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form method="post" action="index.php?module=services&method=add" name="form_central" enctype="multipart/form-data">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>A&ntilde;adir Servicio</td>
			  </tr>
		  </table>
						<br>
		<table width="90%" align="center" border="0"><tr><td>
		<table width="50%" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos del producto:</td>
				  </tr>
					
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->name; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_name']; ?>
</font></td>
					</tr>
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre Web:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name_web; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name_web; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->name_web; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_name_web']; ?>
</font></td>
					</tr>
				<tr>
					<td width="125px" align="right" class="CampoFormulario">P.V.P.:</td>
					<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_pvp; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_pvp; ?>
" value="<?php echo $this->_tpl_vars['objeto']->pvp; ?>
" class="textoMenu">&euro;<font class="error"><?php echo $this->_tpl_vars['error_pvp']; ?>
</font></td>
				</tr>
				<tr>
					<td width="125px" align="right" class="CampoFormulario">Impuestos:</td>
					<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_tax; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_tax; ?>
" value="<?php echo $this->_tpl_vars['objeto']->tax; ?>
" class="textoMenu">%<font class="error"><?php echo $this->_tpl_vars['error_tax']; ?>
</font></td>
				</tr>
				<tr>
					<td width="125px" align="right" class="CampoFormulario">PVP-TAX:</td>
					<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_pvp_tax; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_pvp_tax; ?>
" value="<?php echo $this->_tpl_vars['objeto']->pvp_tax; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_pvp_tax']; ?>
</font></td>
				</tr>
				<tr>
					<td width="125px" align="right" class="CampoFormulario">Stock M&iacute;nimo:</td>
					<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_minimun_stock; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_minimun_stock; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->minimun_stock; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_minimun_stock']; ?>
</font></td>
				</tr>
				<tr>
				 	<td width="125px" class="CampoFormulario" >Imagen:</td>
					<td><input type="file" class="textoMenu" name="<?php echo $this->_tpl_vars['objeto']->ddbb_path_photo; ?>
"></input><font class="error"><?php echo $this->_tpl_vars['error_path_photo']; ?>
</font></td>	
				</tr>
		</table>
		</td><td>
		<table width="250px" align="center">

					<tr>
					  <td class="cabeceraCampoFormulario" align="center">Categor&iacute;as:</td>
				  </tr>
		</table>
		
		<table align="center"><tr><td>		
		<?php echo $this->_tpl_vars['tabla_checkbox']; ?>

		</td></tr></table>
		</td></tr></table>
		</td>
		</tr>
		<tr>
			<td align="center"><br><br>
			<input type="submit" name="submit_add" id="submit_add" value="A&ntilde;adir" class="botones">			
			<input type="reset" Value="Limpiar Datos" class="botones">
			</td>
		</tr>
	  	</table>
	</form>
</td>