<?php /* Smarty version 2.6.3, created on 2005-03-17 10:42:39
         compiled from vehicles_delete.tpl */ ?>
<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar usuarios </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=vehicles&method=delete&id=<?php echo $this->_tpl_vars['objeto']->id_vehicle; ?>
">			  
			  
			  <br>
			  <p>Se va a proceder al borrado del veh&iacute;culo <?php echo $this->_tpl_vars['objeto']->alias; ?>
</p>
			  <p>Se borrar&aacute;n las relaciones con las empresas a las que pertenezca al igual que las categorías con las que esté relacionado</p>
			  <?php echo $this->_tpl_vars['message']; ?>

  			  <br>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>