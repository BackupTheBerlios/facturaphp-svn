<?php /* Smarty version 2.6.3, created on 2004-12-13 23:15:14
         compiled from cat_emps_view.tpl */ ?>
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
						 <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de categor&iacute;a de empleados </td>
				</tr>
			  </table>
				<br>
				<TABLE width="95%" align="center">
					<tr class="cabeceraMultiLinea">
						<td width="50%" height="23" nowrap>Identificador de Categor&iacute;a: <?php echo $this->_tpl_vars['objeto']->id_cat_emp; ?>

						</td>
						<td nowrap width="50%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<table width="90%" align="center">
                                <tr height="15px">
                                <td width="25%" nowrap class="camposVistas">Nombre:</td>
                                <td width="25%" nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->name; ?>
</td>
								 <td>
								 	<table align="center"><tr>
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

				<td>
				<?php if ($this->_tpl_vars['acciones'][$this->_sections['indice']['index']] == 'modify'): ?>
				<a href="index.php?module=cat_emps&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_cat_emp; ?>
">
				<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0"></a></td>
				<?php else: ?>
				<td><a href="index.php?module=cat_emps&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_cat_emp; ?>
">
				<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0" ></a></td>
				<?php endif; ?>
				
				<?php endfor; endif; ?>
									</tr></table>
							</td>
								<td></td>
                              </tr>
                              <tr>
                              <td width="25%"  nowrap class="camposVistas">Descripción:</td>
                                <td nowrap width="25%" class="datosVista"></td>
                                <td></td>
                                <td></td>
                              </tr>
                            </table>
					
					<table class="cajaMenu" width="90%" align="center">
								<tr class="multiLinea1" ><td><?php echo $this->_tpl_vars['objeto']->descrip; ?>
</td></tr>
					  </table>
							
					  
  					  </td>
						
					</tr>
					
					<tr class="cabeceraMultiLinea">
						<td colspan="2">&nbsp;
						</td>
					</tr>
					
				</TABLE>
			</td>