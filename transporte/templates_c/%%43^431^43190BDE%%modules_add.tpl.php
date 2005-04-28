<?php /* Smarty version 2.6.3, created on 2005-03-16 11:49:21
         compiled from modules_add.tpl */ ?>
<td valign="top">
<form method="post" action="index.php?module=modules&method=add" name="form_central">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>A&ntilde;adir M&oacute;dulo</td>
			  </tr>
		  </table>
						<br>
		<table width="250px" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos del m&oacute;dulo:</td>
				  </tr>		
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre Web:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name_web; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name_web; ?>
" value="<?php echo $this->_tpl_vars['objeto']->name_web; ?>
" class="textoMenu"><font class="error"><?php echo $this->_tpl_vars['error_name_web']; ?>
</font></td>
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
						<td width="125px" align="right" class="CampoFormulario">Ruta:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_path; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_path; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->path; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_path']; ?>
</font></td>
					</tr>
				 <tr>
						<td width="125px" align="right" class="CampoFormulario">Activo:</td>
						<td> <select class="textoMenu" name="<?php echo $this->_tpl_vars['objeto']->ddbb_active; ?>
" id="<?php echo $this->_tpl_vars['objeto']->ddbb_active; ?>
">
							<option value="0" <?php if ($this->_tpl_vars['objeto']->active == 0): ?>selected<?php endif; ?>>No</option>
							<option value="1" <?php if ($this->_tpl_vars['objeto']->active == 1 || $this->_tpl_vars['objeto']->active == ''): ?>selected<?php endif; ?>>Sí</option>
						</select></td>
					</tr>	
				<tr>
						<td width="125px" align="right" class="CampoFormulario">P&uacute;blico:</td>
						<td> <select class="textoMenu"  name="<?php echo $this->_tpl_vars['objeto']->ddbb_public; ?>
" id="<?php echo $this->_tpl_vars['objeto']->ddbb_public; ?>
">
							<option value="0" <?php if ($this->_tpl_vars['objeto']->public == 0): ?>selected<?php endif; ?>>No</option>
							<option value="1" <?php if ($this->_tpl_vars['objeto']->public == 1 || $this->_tpl_vars['objeto']->public == ''): ?>selected<?php endif; ?>>Sí</option>
						</select> </td>
					</tr>		
				<tr>
						<td width="125px" align="right" class="CampoFormulario">Depende de:</td>
						<td><select class="textoMenu"  name="<?php echo $this->_tpl_vars['objeto']->ddbb_parent; ?>
" id="<?php echo $this->_tpl_vars['objeto']->ddbb_parent; ?>
">
							<option value="-2" <?php if ($this->_tpl_vars['objeto']->parent == -2 || $this->_tpl_vars['objeto']->parent == ''): ?>selected<?php endif; ?>>Ninguno (sin enlace)</option>
							<option value="0" <?php if ($this->_tpl_vars['objeto']->parent == 0): ?>selected<?php endif; ?>>Ninguno (con enlace)</option>
							<?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=($this->_tpl_vars['padres'])) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
								<option value="<?php echo $this->_tpl_vars['padres'][$this->_sections['indice']['index']]['id_module']; ?>
" <?php if ($this->_tpl_vars['objeto']->parent == $this->_tpl_vars['padres'][$this->_sections['indice']['index']]['id_module']): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['padres'][$this->_sections['indice']['index']]['name_web']; ?>
</option>
							<?php endfor; endif; ?>
							
						</select></td>
				</tr>

		</table>
		<br>
			<table width="90%" align="center">
				<tr class="cabeceracampoFormulario">
					<td colspan="6">M&eacute;todos que tendra:</td>
				</tr>
					<tr class="cabeceraMultilinea">
					  <td colspan="6">&nbsp;</td>
				  </tr>
				  <tr class="multilinea1">
						<td align="center" class="multilinea1"><input type="checkbox" name="list" value="Listar" <?php if ($this->_tpl_vars['module_methods']['list']['name'] == 'list'): ?>checked<?php endif; ?>>Listar</td>
						<td align="center" class="multilinea1"><input type="checkbox" name="select" value="Seleccionar" <?php if ($this->_tpl_vars['module_methods']['select']['name'] == 'select'): ?>checked<?php endif; ?>>Seleccionar</td>
						<td align="center" class="multilinea1"><input type="checkbox" name="view" value="Ver" <?php if ($this->_tpl_vars['module_methods']['view']['name'] == 'view'): ?>checked<?php endif; ?>>Ver</td>
						<td align="center" class="multilinea1"><input type="checkbox" name="add" value="A&ntilde;adir" <?php if ($this->_tpl_vars['module_methods']['add']['name'] == 'add'): ?>checked<?php endif; ?>>A&ntilde;adir</td>						
						<td align="center" class="multilinea1"><input type="checkbox" name="modify" value="Modificar" <?php if ($this->_tpl_vars['module_methods']['modify']['name'] == 'modify'): ?>checked<?php endif; ?>>Modificar</td>
						<td align="center" class="multilinea1"><input type="checkbox" name="delete" value="Borrar" <?php if ($this->_tpl_vars['module_methods']['delete']['name'] == 'delete'): ?>checked<?php endif; ?>>Borrar</td>
				</tr>
			<tr class="cabeceraMultilinea">
					  <td colspan="6">&nbsp;</td>
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