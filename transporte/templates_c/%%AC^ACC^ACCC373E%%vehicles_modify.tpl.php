<?php /* Smarty version 2.6.3, created on 2005-03-30 11:17:26
         compiled from vehicles_modify.tpl */ ?>

<td valign="top">
<form method="post" action="index.php?module=vehicles&method=modify&id=<?php echo $this->_tpl_vars['objeto']->id_vehicle; ?>
" name="form_central" enctype="multipart/form-data">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
		
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
				<td width="7%"><img src="pics/usuariosico.png" width="32" height="32"></td>
				<td width="93%" valign="middle"  nowrap>Modificaci&oacute;n de veh&iacute;culos</td>
			  	</tr>
		    </table>
		    <br>
		    <table width="90%" align="center" border="0"><tr><td>
		<table width="50%" align="center">

				<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos del veh&iacute;culo:</td>
				  </tr>
					<tr>
						<td width="125px" class="CampoFormulario">Alias:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_alias; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_alias; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->alias; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_alias']; ?>
</font></td>
				  </tr>
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Matr&iacute;cula:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_number_plate; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_number_plate; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->number_plate; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_number_plate']; ?>
</font></td>
				  </tr>
				  
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Fotograf&iacute;a:</td>	
						<td><a href="index.php?module=vehicles&method=show&id=<?php echo $this->_tpl_vars['objeto']->id_vehicle; ?>
"><img src="<?php echo $this->_tpl_vars['objeto']->path_photo; ?>
" width="80" height="80"></a></td>					
						<td><input type="file" name="<?php echo $this->_tpl_vars['objeto']->ddbb_path_photo; ?>
"></input></td>	
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
			<td align="center"><br><br><input type="submit" name="submit_modify" value="Modificar" class="botones">
			<input type="reset" Value="Borrar Datos" class="botones">
			</td>

		</tr>
	  	</table>
	</form>
</td>		