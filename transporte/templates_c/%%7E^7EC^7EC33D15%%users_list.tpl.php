<?php /* Smarty version 2.6.3, created on 2005-04-21 12:47:35
         compiled from users_list.tpl */ ?>
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
						  Buscar usuarios </td>
				</tr>
			  </table>
			  <table width="100%">
			  <tr><td class="message" align="center"><?php echo $this->_tpl_vars['message']; ?>
</td></tr>
			  <tr><td valign="top"><form method="post" action="index.php?module=users&method=list" name="form_searchs">
			  	<table width="250px" align="center">
				 <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">B&uacute;squeda:</td>
				  </tr>
					<tr>
						<td  width="125px" align="right" class="CampoFormulario">Introduzca su b&uacute;squeda:</td>
						<td ><input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_search; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_search; ?>
" value="<?php echo $this->_tpl_vars['objeto']->search_query; ?>
" class="textoMenu"></td>
				  </tr>
			    <tr>
						<td width="125" class="CampoFormulario">Nº de Registros por p&aacute;gina:</td>
						<td><select name="regs">
						 <option <?php if ($this->_tpl_vars['registro'] == 10): ?>selected<?php endif; ?>>10</option>
						  <option <?php if ($this->_tpl_vars['registro'] == 30): ?>selected<?php endif; ?>>30</option>
						  <option <?php if ($this->_tpl_vars['registro'] == 50): ?>selected<?php endif; ?>>50</option>
						</select></td>
				 </tr>
				  <tr>
				 	<td colspan="2" align="center"><input type="submit" value="Buscar" name="submit_users_search" class="botones"></td>
				 </tr> </table>
				</form><br>
				  <div name="divMostrar" id="divMostrar" >
						
					</div>	
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = users_1;
					  </script>
				  
			  </td></tr></table>
	  </td>