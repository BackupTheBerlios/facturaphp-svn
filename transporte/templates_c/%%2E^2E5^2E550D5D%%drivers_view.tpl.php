<?php /* Smarty version 2.6.3, created on 2005-02-07 21:03:21
         compiled from drivers_view.tpl */ ?>
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
						<td width="93%" valign="middle" nowrap>Detalle de conductores </td>
				</tr>
				
			  </table>
				
				<TABLE width="100%">		
				<tr class="cabeceraMultiLinea" width="100%">
				<td colspan="2">&nbsp;</td>	
				</tr>	
					<tr>
						<td valign="top">
							<table width="100%">
							
                              <tr height="15px">
                                 <td width="25%" nowrap class="camposVistas">Nombre:</td>
                                 <td width="25%" nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->name; ?>
</td>
								 <td width="25%"  nowrap class="camposVistas">Primer Apellido: </td>
                                 <td width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->last_name; ?>
</td>
                              </tr>
                              <tr>
								<td height="21" nowrap class="camposVistas">Segundo Apellido: </td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->last_name2; ?>
</td>                        
                                <td height="21" nowrap class="camposVistas">Empleado: </td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['emp_driver']; ?>
</td>
                              </tr>
                    		  <tr>      
			      				<td align="center">
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
										<a href="index.php?module=drivers&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_driver; ?>
">
										<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0"></a>
									<?php else: ?>
										<a href="index.php?module=drivers&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_driver; ?>
">
										<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0" onClick="confirm('¿Desea borrar este registro?\nSi pulsa Sí se borrarán tambien los registros relacionados con este conductor')"></a>
									<?php endif; ?>	
									<?php endfor; endif; ?>
								</td>
							 </tr>
								
						 	</table>
					   		<br>
							<p align="center" class="cabeceraCampoFormulario">Listados de vehículos asignados al conductor</p>
							<br>
					<a name="listado">
					  <table align="center" width="400" cellspacing="0" cellpadding="0">
					  <tr>
					  	
					  	
					  </tr>
					  	<td align="center" colspan="2"><img src="pics/barra.gif"></td>
					  </table>

					  <br>
					 
					  <div name="divMostrar" id="divMostrar" >
						
					</div>					
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = drivers_1;
					  </script>
					  <br>
					  <table align="center" width="400" cellpadding="0" cellspacing="0">
						  <tr><td><img src="pics/barra.gif"></td></tr>
					  </table>
					  <br>
					  
  					  </td>
						
					</tr>
					
					<tr class="cabeceraMultiLinea">
						<td colspan="2">&nbsp;
						</td>
					</tr>
					
				</TABLE>
			</td>