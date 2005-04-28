<?php /* Smarty version 2.6.3, created on 2004-11-15 20:16:19
         compiled from cat_emps_delete.tpl */ ?>
<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar categor&iacute;a de empleado </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=cat_emps&method=delete&id=<?php echo $this->_tpl_vars['objeto']->id_cat_emp; ?>
">			  
			  
			  <br>
			  <p>Se va a proceder al borrado de la categor&iacute;a de empleado: <?php echo $this->_tpl_vars['objeto']->name; ?>
</p>			 
			  <?php echo $this->_tpl_vars['message']; ?>

  			  <br>
  			  <p>¿Realmente desea realizar esta operaci&oacute;n?</p>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>