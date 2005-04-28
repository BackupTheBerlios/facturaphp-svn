<?php /* Smarty version 2.6.3, created on 2005-04-21 13:13:48
         compiled from contacts_list.tpl */ ?>
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
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Buscar contactos </td>
				</tr>
			  </table>
			  <table width="100%">
			  <tr><td class="message" align="center"><?php echo $this->_tpl_vars['message']; ?>
</td></tr>
			  <tr><td valign="top"><form method="post" action="index.php?module=contacts&method=list">
			  	<table width="250px" align="center">
				 <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">B&uacute;squeda:</td>
				  </tr>
				  <tr>
				  <td width="125" class="CampoFormulario">Seleccione cliente:</td>
						<td><select name="client">		
						<option value="0" <?php if ($this->_tpl_vars['objeto']->client == 0 || $this->_tpl_vars['objeto']->client == ""): ?> selected<?php endif; ?>>Seleccione un cliente...</option>				
						<?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=$this->_tpl_vars['clients']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						  <option value="<?php echo $this->_tpl_vars['clients'][$this->_sections['indice']['index']]['id_client']; ?>
"<?php if ($this->_tpl_vars['objeto']->client == $this->_tpl_vars['clients'][$this->_sections['indice']['index']]['id_client']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['clients'][$this->_sections['indice']['index']]['name']; ?>
</option>
						  <?php endfor; endif; ?>
						</select></td>
				  </tr>
					  <tr>
						<td  width="125px" align="right" class="CampoFormulario">Introduzca su b&uacute;squeda:</td>
						<td><input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_search; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_search; ?>
" value="<?php echo $this->_tpl_vars['objeto']->search_query; ?>
" class="textoMenu"></td>
				  </tr>
				  
				    <tr>
						<td width="125" class="CampoFormulario">Nº de Registros por p&aacute;gina:</td>
						<td><select name="Registros">
						  <option selected>10</option>
						  <option>30</option>
						  <option>50</option>
						</select></td>
				 </tr>
				 <tr>
				 	<td align="center" colspan="2"><input type="submit" value="Buscar" name="submit_contacts_search" class="botones"></td>
				 </tr>
				  </table>
				</form><br>
				  <div name="divMostrar" id="divMostrar" >
						
					</div>	
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = contacts_1;
					  </script>
				  
			  </td></tr></table>
	  </td>