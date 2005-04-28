<?php /* Smarty version 2.6.3, created on 2005-01-19 13:51:46
         compiled from cat_prods_modify.tpl */ ?>
<td valign="top">
<form method="post" action="index.php?module=cat_prods&method=modify&id=<?php echo $this->_tpl_vars['objeto']->id_cat_prod; ?>
" name="form_central" enctype="multipart/form-data">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>A&ntilde;adir Catego&iacute;a de Producto</td>
			  </tr>
		  </table>
						<br>
		<table width="250px" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos de la categoria:</td>
				  </tr>
					
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre:</td>
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->name; ?>
"></td>
					</tr>
					<tr>
						<td width="125px" align="right" class="CampoFormulario">Fotograf&iacute;a:</td>
						<td><a href="index.php?module=cat_prods&method=show&id=<?php echo $this->_tpl_vars['objeto']->id_cat_prod; ?>
"><img src="<?php echo $this->_tpl_vars['objeto']->path_photo; ?>
" width="80" height="80"></a>
						<input type="file" name="<?php echo $this->_tpl_vars['objeto']->ddbb_path_photo; ?>
"></input></td>	
				  </tr>
					 <tr>
						<td width="125px" align="right" class="CampoFormulario">Categoria Padre:</td>
						<td> <select id="<?php echo $this->_tpl_vars['objeto']->ddbb_id_parent_cat; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_id_parent_cat; ?>
">
						<option value="0" <?php if ($this->_tpl_vars['objeto']->id_parent_cat == 0): ?>selected<?php endif; ?>>Ninguna</option>
						
						<?php unset($this->_sections['nombre']);
$this->_sections['nombre']['name'] = 'nombre';
$this->_sections['nombre']['loop'] = is_array($_loop=$this->_tpl_vars['objeto']->cat_prods_list) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nombre']['show'] = true;
$this->_sections['nombre']['max'] = $this->_sections['nombre']['loop'];
$this->_sections['nombre']['step'] = 1;
$this->_sections['nombre']['start'] = $this->_sections['nombre']['step'] > 0 ? 0 : $this->_sections['nombre']['loop']-1;
if ($this->_sections['nombre']['show']) {
    $this->_sections['nombre']['total'] = $this->_sections['nombre']['loop'];
    if ($this->_sections['nombre']['total'] == 0)
        $this->_sections['nombre']['show'] = false;
} else
    $this->_sections['nombre']['total'] = 0;
if ($this->_sections['nombre']['show']):

            for ($this->_sections['nombre']['index'] = $this->_sections['nombre']['start'], $this->_sections['nombre']['iteration'] = 1;
                 $this->_sections['nombre']['iteration'] <= $this->_sections['nombre']['total'];
                 $this->_sections['nombre']['index'] += $this->_sections['nombre']['step'], $this->_sections['nombre']['iteration']++):
$this->_sections['nombre']['rownum'] = $this->_sections['nombre']['iteration'];
$this->_sections['nombre']['index_prev'] = $this->_sections['nombre']['index'] - $this->_sections['nombre']['step'];
$this->_sections['nombre']['index_next'] = $this->_sections['nombre']['index'] + $this->_sections['nombre']['step'];
$this->_sections['nombre']['first']      = ($this->_sections['nombre']['iteration'] == 1);
$this->_sections['nombre']['last']       = ($this->_sections['nombre']['iteration'] == $this->_sections['nombre']['total']);
?>
							<option value="<?php echo $this->_tpl_vars['objeto']->cat_prods_list[$this->_sections['nombre']['index']]['id_cat_prod']; ?>
" <?php if ($this->_tpl_vars['objeto']->id_parent_cat == $this->_tpl_vars['objeto']->cat_prods_list[$this->_sections['nombre']['index']]['id_cat_prod']): ?>selected<?php endif; ?>>
								<?php echo $this->_tpl_vars['objeto']->cat_prods_list[$this->_sections['nombre']['index']]['name']; ?>

							</option>
						<?php endfor; endif; ?>						
						</td>
					</tr>
					  <tr>
						<td width="125" align="right" class="CampoFormulario">Descripcion:</td>
						<td rowspan="2" ><textarea name="<?php echo $this->_tpl_vars['objeto']->ddbb_descrip; ?>
" class="textoMenu" id="<?php echo $this->_tpl_vars['objeto']->ddbb_descrip; ?>
"><?php echo $this->_tpl_vars['objeto']->descrip; ?>
</textarea> </td>
					</tr>
		</table>
		</td>
		</tr>	

		<tr>
			<td align="center"><br><br>
			<input type="submit" name="submit_modify" id="submit_modify" value="A&ntilde;adir" class="botones">			
			<input type="reset" Value="Limpiar Datos" class="botones">
			</td>
		</tr>
	  	</table>
	</form>
</td>