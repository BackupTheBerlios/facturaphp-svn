<?php /* Smarty version 2.6.3, created on 2005-03-23 11:41:14
         compiled from users_modify.tpl */ ?>
<td valign="top">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "checkbox.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form method="post" action="index.php?module=users&method=modify&id=<?php echo $this->_tpl_vars['objeto']->id_user; ?>
" name="form_central">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>Modificaci&oacute;n de usuarios</td>
								</tr>
						</table>
						<br>
		<table width="90%" align="center" border="0"><tr><td>
		<table width="50%" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos de Login:</td>
				  </tr>
					<tr>
						<td width="125px" align="right" class="CampoFormulario" nowrap>Login:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_login; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_login; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->login; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_login']; ?>
</font></td>
					</tr>
					<tr>
						<td width="125px" class="CampoFormulario">Password:</td>
						<td > <input type="password" id="<?php echo $this->_tpl_vars['objeto']->ddbb_passwd; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_passwd; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->passwd; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_passwd']; ?>
</font></td>
				  </tr>
				  <tr>
						<td width="125px" class="CampoFormulario">Re-escriba password:</td>
						<td > <input type="password" id="retype" name="retype" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->retype; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_retype']; ?>
</font></td>
				  </tr>
				  <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos del Usuario:</td>
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
						<td width="125px" class="CampoFormulario" >Primer Apellido:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->last_name; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_last_name']; ?>
</font></td>
				  </tr>
				  <tr>
						<td width="125px" class="CampoFormulario">Segundo Apellido:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name2; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name2; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->last_name2; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_last_name2']; ?>
</font></td>
				  </tr>
				   <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Permisos: </td>
				  </tr>
				  <tr>
				  	<td colspan="2">
				  		<input type="button" Value="Seleccionar Todos" class="botones" onClick="selectAll();">
					<input type="button" Value="Deseleccionar Todos" class="botones" onClick="unselectAll();">
				  	</td>
				  </tr>
		
				</table>
			</td><td>
			<table width="100%" align="center" border="0">
			 <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Grupos: </td>
			</tr>
			<tr class="cabeceraMultiLinea">
				<td width="100%" colspan="2">Grupos</td>				
			</tr>
			
			<?php 
				$linea = 0;
			 ?>
			<?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=$this->_tpl_vars['grupos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<?php 
				if ($linea==0){
					$clase="multiLinea1";
					$linea=1;
				}				
				else{
					$clase="multiLinea2";	
					$linea=0;
				}				
				print('<tr class="'.$clase.'">');
				 ?>
				<td>
				<input type="checkbox" value="1" name="grupo_<?php echo $this->_tpl_vars['grupos'][$this->_sections['indice']['index']]->id_group; ?>
" <?php if ($this->_tpl_vars['grupos'][$this->_sections['indice']['index']]->belong == true): ?>checked<?php endif; ?>><?php echo $this->_tpl_vars['grupos'][$this->_sections['indice']['index']]->name_web; ?>

				<?php $this->_sections['indice']['index']+=1;
					$this->_sections['indice']['iteration']+=1; ?>
				
				</td>
				<?php if (! $this->_sections['indice']['last']): ?>
				<td>
				<input type="checkbox" value="1" name="grupo_<?php echo $this->_tpl_vars['grupos'][$this->_sections['indice']['index']]->id_group; ?>
" <?php if ($this->_tpl_vars['grupos'][$this->_sections['indice']['index']]->belong == true): ?>checked<?php endif; ?>><?php echo $this->_tpl_vars['grupos'][$this->_sections['indice']['index']]->name_web; ?>

				</td>
				<?php else: ?>
				<td>
				&nbsp;
				</td>
				<?php endif; ?>
				
				</tr>
			<?php endfor; endif; ?>
			<tr class="cabeceraMultilinea"><td colspan="2">&nbsp</td></tr>
			</table>
			</td></tr></table>
		</td>
		</tr>				
			
		<tr>

			<td valign="top">
			<br>
			<br>    
		
		
			<table width="90%" align="center" border="0">
			 <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Permisos por modulos-metodos: </td>
			</tr>
			<tr class="cabeceraMultiLinea">
				<td width="30%">Nombre de Modulo</td>
				<td Colspan="4" width="70%">Metodos</td>
			</tr>
			
			<?php 
				$linea = 0;
			 ?>
			<?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=$this->_tpl_vars['modulos']->per_modules) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<?php 
				if ($linea==0){
					$clase="multiLinea1";
					$linea=1;
				}				
				else{
					$clase="multiLinea2";	
					$linea=0;
				}				
				print('<tr class="'.$clase.'">');
				 ?>

				<?php if ($this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->per == 1): ?>
					<td nowrap><input type="checkbox" name="modulo_<?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->id_module; ?>
" value="1" onClick="selectRow()" checked> <?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->module_name; ?>
</td> 
				<?php else: ?>
					<td nowrap><input type="checkbox" name="modulo_<?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->id_module; ?>
" value="1" onClick="selectRow()"> <?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->module_name; ?>
</td> 				
				<?php endif; ?>
				<td nowrap>						
					<table width="100%"><tr class="<?php print($clase); ?>">				
					 <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->per_methods) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
						<?php if ($this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->per_methods[$this->_sections['j']['index']]->per == 1): ?>
							<td width="20%"><input type="checkbox" name="modulo_<?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->id_module; ?>
_metodo_<?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->per_methods[$this->_sections['j']['index']]->id_method; ?>
" value="1" checked><?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->per_methods[$this->_sections['j']['index']]->method_name_web; ?>
</td>
						<?php else: ?>
							<td width="20%"><input type="checkbox" name="modulo_<?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->id_module; ?>
_metodo_<?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->per_methods[$this->_sections['j']['index']]->id_method; ?>
" value="1"><?php echo $this->_tpl_vars['modulos']->per_modules[$this->_sections['indice']['index']]->per_methods[$this->_sections['j']['index']]->method_name_web; ?>
</td>
						<?php endif; ?>
					<?php endfor; endif; ?>   
					</tr></table>
				</td>				
				</tr>				
			<?php endfor; endif; ?>
			<tr  class="cabeceraMultiLinea"><td colspan="2">&nbsp;</td></tr>
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