<?php /* Smarty version 2.6.3, created on 2004-11-30 12:43:28
         compiled from emps_delete.tpl */ ?>
<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar Empleados </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=emps&method=delete&id=<?php echo $this->_tpl_vars['objeto']->id_emp; ?>
">			  
			  
			  <br>
			  <p>Se va a proceder al borrado del Empleado: <?php echo $this->_tpl_vars['objeto']->name; ?>
 <?php echo $this->_tpl_vars['objeto']->last_name; ?>
 <?php echo $this->_tpl_vars['objeto']->last_name2; ?>
</p>
			  <p>Se borrar&aacute;n las relaciones con las categorias, y altas y bajas a las que pertenezca. Si tiene algun usuario asignado, éste se mantendrá por que cabe la posibilidad de que también este asignado a otro empleado</p>
			  <?php echo $this->_tpl_vars['message']; ?>

  			  <br>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>