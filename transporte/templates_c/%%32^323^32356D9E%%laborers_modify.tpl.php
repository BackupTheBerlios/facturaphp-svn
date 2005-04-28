<?php /* Smarty version 2.6.3, created on 2005-03-22 11:24:43
         compiled from laborers_modify.tpl */ ?>
<td valign="top">

<form method="post" action="index.php?module=laborers&method=modify&id=<?php echo $this->_tpl_vars['objeto']->id_laborer; ?>
" name="form_central">
<script src="inc/calendar.js" type="text/javascript" language="javascript"></script>
	 <table align="center" width="100%">
	<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						 <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>Modificar peón</td>
				</tr>
			  </table>
						<br>
	<table align="center" width="90%"><tr><td width ="40%"valign="top">
	<tr>
					  <td  colspan="2" align="center" class="cabeceraCampoFormulario">Datos del peón:</td>
		  </tr>
		<tr><td valign="top">		  
		<table width="250px" align="center" >

					 
				  <tr>
						<td width="125" class="CampoFormulario">Empleado:</td>
						<td><select name="empleados" id="empleados">						
						<?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=$this->_tpl_vars['empleados']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						  <option value="<?php echo $this->_tpl_vars['empleados'][$this->_sections['indice']['index']]['id_emp']; ?>
"<?php if ($this->_tpl_vars['objeto']->id_emp == $this->_tpl_vars['empleados'][$this->_sections['indice']['index']]['id_emp']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['empleados'][$this->_sections['indice']['index']]['nombre_completo']; ?>
</option>						 
						  <?php endfor; endif; ?>
						</select></td>
					</tr>
					
					<tr>
						<td width="125" class="CampoFormulario" nowrap>Fecha de asignación:</td>
						<td > <input class="textoMenu" type="text" name="<?php echo $this->_tpl_vars['objeto']->ddbb_date; ?>
" value="<?php echo $this->_tpl_vars['objeto']->date; ?>
" "size="15" maxlength="99" class="textfield"  id="<?php echo $this->_tpl_vars['objeto']->ddbb_date; ?>
">
				 	
                                    <script type="text/javascript">
                                    
                    <!--
                    document.write('<a title="Calendario" href="javascript:openCalendar(\'lang=es-utf-8&amp;server=1\', \'form_central\', \'<?php echo $this->_tpl_vars['objeto']->ddbb_date; ?>
\', \'date\')"><img class="calendar" valign="center" src="pics/calendar.png" alt="Calendario"/></a>');
                    //-->
                    </script><font class="error"><?php echo $this->_tpl_vars['error_date']; ?>
</font>
		    
						
						</td>
				 </tr>
				<tr>
						<td width="125" class="CampoFormulario">Vehículos de la empresa:</td>
						<td><select name="vehiculos">
						<input type="hidden" name="<?php echo $this->_tpl_vars['vehiculo']->ddbb_id_vehicle; ?>
" id="<?php echo $this->_tpl_vars['vehiculo']->ddbb_id_vehicle; ?>
" value="<?php echo $this->_tpl_vars['vehiculo']->id_vehicle; ?>
"}
						<?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=$this->_tpl_vars['vehiculos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						  <option value="<?php echo $this->_tpl_vars['vehiculos'][$this->_sections['indice']['index']]['id_vehicle']; ?>
"<?php if ($this->_tpl_vars['objeto']->id_vehicle == $this->_tpl_vars['vehiculos'][$this->_sections['indice']['index']]['id_vehicle']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['vehiculos'][$this->_sections['indice']['index']]['alias']; ?>
</option>						 
						  <?php endfor; endif; ?>
						</select></td>
					</tr>
				</table>
			
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><br><br><input type="submit" name="submit_modify" value="Modificar" class="botones">
			<input type="reset" Value="Borrar Datos" class="botones">
			</td>
		</tr>
	  	</table> </td>
		</form></td>