<?php /* Smarty version 2.6.3, created on 2005-02-04 13:12:50
         compiled from laborers_list.tpl */ ?>
<td valign="top">
<?php echo $this->_tpl_vars['cadena']; ?>

	<?php 
		echo $this->_tpl_vars['cadena'];
	 ?>

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
						  Buscar peones </td>
				</tr>
			  </table>
			  <table width="100%">
			  <tr><td class="message" align="center"><?php echo $this->_tpl_vars['message']; ?>
</td></tr>
			  <tr><td valign="top"><form method="post" action="index.php?module=laborers&method=list">
			  	<table width="250px" align="center">
				 <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Criterios de b&uacute;squeda:</td>
				  </tr>
					 <tr>
						<td width="125px" class="CampoFormulario">Identificador del pe&oacute;n:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_id_laborer; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_id_laborer; ?>
" class="textoMenu"></td>
				  </tr>
				<tr>
						<td width="125px" class="CampoFormulario" >Nombre:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" class="textoMenu"></td>
				  </tr>
					<tr>
						<td width="125px" class="CampoFormulario" >Primer apellido:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name; ?>
" class="textoMenu"></td>
				  </tr>
				  <tr>
						<td width="125px" class="CampoFormulario" >Segundo apellido:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name2; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name2; ?>
" class="textoMenu"></td>
				  </tr>
				  <tr>
						<td width="125px" class="CampoFormulario" >Alias del veh&iacute;culo en el que trabaja:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_alias; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_alias; ?>
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
				 	<td align="center" colspan="2"><input type="submit" value="Buscar" name="Submit" class="botones"></td>
				 </tr>
				  </table>
				</form><br>
				  <div name="divMostrar" id="divMostrar" >
						
					</div>	
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = laborers_1;
					  </script>
			  </td></tr></table>
	  </td>