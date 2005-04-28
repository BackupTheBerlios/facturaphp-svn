<?php /* Smarty version 2.6.3, created on 2005-03-22 10:11:34
         compiled from laborers_delete.tpl */ ?>
<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar Peones </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=laborers&method=delete&id=<?php echo $this->_tpl_vars['objeto']->id_laborer; ?>
">			  
			  
			  <br>
			  <p>Se va a proceder al borrado del peón con identificador <?php echo $this->_tpl_vars['objeto']->id_laborer; ?>
 </p>
			  
			  <?php echo $this->_tpl_vars['message']; ?>

  			  <br>
  			  <p>¿Desea continuar?</p>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>