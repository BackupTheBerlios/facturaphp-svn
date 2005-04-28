<?php /* Smarty version 2.6.3, created on 2005-03-03 11:04:07
         compiled from emps_view.tpl */ ?>
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
						<td width="93%" valign="middle" nowrap>Detalle de empleados </td>
				</tr>
			  </table>
				<br>
				<TABLE width="95%" align="center">
					<tr class="cabeceraMultiLinea">
						<td width="50%" height="23" nowrap>Identificador de Empleado: <?php echo $this->_tpl_vars['objeto']->id_emp; ?>

						</td>
						<td nowrap width="50%">
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
							<a href="index.php?module=emps&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_emp; ?>
">
							<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0"></a>
						<?php else: ?>
							<a href="index.php?module=emps&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_emp; ?>
">
							<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0" ></a>
						<?php endif; ?>				
				<?php endfor; endif; ?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table width="90%" align="center">                             
                              
                              <tr height="15px">
                                <td width="25%" nowrap class="camposVistas">Nombre:</td>
                                <td width="25%" nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->name; ?>
</td>
								 <td width="25%"  nowrap class="camposVistas">Direcci&oacute;n: </td>
                                 <td width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->address; ?>
</td>
                                
                              </tr>
                              <tr height="15px">
                               <td width="25%"  nowrap class="camposVistas">Primer Apellido: </td>
                                 <td width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->last_name; ?>
</td>
                               <td width="25%"  nowrap class="camposVistas">Provincia: </td>
                                 <td width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->state; ?>
</td>
								 
                                
                              </tr>
                              <tr height="15px">
                              <td height="21" nowrap class="camposVistas">Segundo Apellido: </td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->last_name2; ?>
</td>
                               <td height="21" nowrap class="camposVistas">Ciudad: </td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->city; ?>
</td>
								 
                                
                              </tr>
                              <tr height="15px">
                               <td height="21" nowrap class="camposVistas">Pa&iacute;s: </td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->country; ?>
</td>
								 <td width="25%"  nowrap class="camposVistas">C&oacute;digo Postal: </td>
                                 <td width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->postal_code; ?>
</td>                                
                              </tr>
                              <tr height="15px">
                               <td height="21" nowrap class="camposVistas">Tel&eacute;fono: </td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->phone; ?>
</td>
								 <td width="25%"  nowrap class="camposVistas">Tel&eacute;fono M&oacute;vil: </td>
                                 <td width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->mobile_phone; ?>
</td>                                
                              </tr>
                              <tr height="15px">
                               <td height="21" nowrap class="camposVistas">Fecha nacimiento: </td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['cumplecambiado']; ?>
</td>
								 <td width="25%"  nowrap class="camposVistas">E-mail: </td>
                                 <td width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->mail; ?>
</td>                                
                              </tr>
                              <tr height="15px">                               
                               <td height="21" nowrap class="camposVistas">Usuario: </td>
                                <td nowrap class="datosVista"><?php echo $this->_tpl_vars['user_emp']; ?>
</td>
								<td>&nbsp;</td>
								<td></td>
                              </tr>
                            </table>
							<br>
							<p align="center" class="cabeceraCampoFormulario">Listados Altas-Bajas</p>
							
							<?php if ($this->_tpl_vars['message'] != ""): ?><p align="center"><?php echo $this->_tpl_vars['message']; ?>
</p><?php else: ?><br><?php endif; ?>
							
					   <div name="divMostrar" id="divMostrar" >
						
					</div>					
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = holydays_1;
					  </script>
  					  </td>
						
					</tr>
					
					<tr class="cabeceraMultiLinea">
						<td colspan="2">&nbsp;
						</td>
					</tr>
					
				</TABLE>
			</td>