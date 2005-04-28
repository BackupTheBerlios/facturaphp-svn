<?php /* Smarty version 2.6.3, created on 2005-01-19 16:16:01
         compiled from cat_prods_view.tpl */ ?>
<td valign="top">

<?php echo $this->_tpl_vars['cadena']; ?>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "capas.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de categor&iacute;a </td>
				</tr>
			  </table>
				<br>
				<TABLE width="100%">			
					<tr>
						<td valign="top">
							<table width="100%">
							<tr class="cabeceraMultiLinea">
								<td colspan="2" height="23" nowrap>Identificador de Categor&iacute;a: <?php echo $this->_tpl_vars['objeto']->id_cat_prod; ?>
</td>
								<td colspan="2">&nbsp;</td>
							</tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Nombre:</td>
                                <td nowrap width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->name; ?>
</td>
                                <td height="21" nowrap class="camposVistas">Categor&iacute;a Padre:</td>
                                <td nowrap class="datosVista"><?php if ($this->_tpl_vars['objeto']->id_parent_cat == 0): ?>Ninguna<?php else: ?>
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
							<?php if ($this->_tpl_vars['objeto']->id_parent_cat == $this->_tpl_vars['objeto']->cat_prods_list[$this->_sections['nombre']['index']]['id_cat_prod']):  echo $this->_tpl_vars['objeto']->cat_prods_list[$this->_sections['nombre']['index']]['name'];  endif; ?>>
								
							
						<?php endfor; endif; ?>	
						<?php endif; ?>	
                                </td>  
                              </tr>
                              <tr>
								
                              </tr>
                              <tr>
								<td height="21" nowrap class="camposVistas">Descripci&oacute;n:</td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->descrip; ?>
</td>
                                <td align="center" colspan="2">
									<?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=$this->_tpl_vars['acciones']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
									<?php if ($this->_tpl_vars['acciones'][$this->_sections['indice']['index']] == 'modify'): ?>
										<a href="index.php?module=cat_prods&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_cat_prod; ?>
">
											<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0"></a>
									<?php else: ?>
										<a href="index.php?module=cat_prods&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_cat_prod; ?>
">
											<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0"></a>
									<?php endif; ?>	
									<?php endfor; endif; ?>
								</td>
                              </tr>
                    		  <tr>
								<td colspan="4" align="center">
                               <a href="index.php?module=cat_prods&method=show&id=<?php echo $this->_tpl_vars['objeto']->id_cat_prod; ?>
"><img src="<?php echo $this->_tpl_vars['objeto']->path_photo; ?>
" height="120"></a>
					   </td>
							 </tr>
							 <tr>      
			      				
							 </tr>
					  		</tr>
							 <tr class="cabeceraMultiLinea">
								<td colspan="4">&nbsp;</td>
							</tr>	
						 	</table>
					   	</td>
					   
					</tr>	
			 </TABLE>
</td>