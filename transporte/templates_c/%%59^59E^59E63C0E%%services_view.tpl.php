<?php /* Smarty version 2.6.3, created on 2005-02-03 20:47:52
         compiled from services_view.tpl */ ?>
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
								<td colspan="2" height="23" nowrap>Identificador de Categor&iacute;a: <?php echo $this->_tpl_vars['objeto']->id_service; ?>
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
										<a href="index.php?module=services&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_service; ?>
">
											<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0"></a>
									<?php else: ?>
										<a href="index.php?module=services&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_service; ?>
">
											<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0"></a>
									<?php endif; ?>	
									<?php endfor; endif; ?>
								</td>
							</tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Nombre:</td>
                                <td nowrap width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->name; ?>
</td>
                                <td height="21" nowrap class="camposVistas">Nombre Web:</td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->name_web; ?>
</td>  
                              </tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Precio:</td>
                                <td nowrap width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->pvp; ?>
</td>
                                <td height="21" nowrap class="camposVistas">IVA:</td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->tax; ?>
</td>  
                              </tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Precio con IVA:</td>
                                <td nowrap width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->pvp_tax; ?>
</td>
                                <td height="21" nowrap class="camposVistas">Stock minimo:</td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->minimun_stock; ?>
</td>  
                              </tr>
                              <tr>
								<td colspan="4" align="center">
                               <a href="index.php?module=services&method=show&id=<?php echo $this->_tpl_vars['objeto']->id_service; ?>
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