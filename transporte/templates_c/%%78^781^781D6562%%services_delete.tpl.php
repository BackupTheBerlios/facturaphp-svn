<?php /* Smarty version 2.6.3, created on 2005-02-03 19:30:18
         compiled from services_delete.tpl */ ?>
<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar Servicio </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=services&method=delete&id=<?php echo $this->_tpl_vars['objeto']->id_service; ?>
">			  
			  
			  <br>
			  <p>Se va a proceder al borrado del servicio: <?php echo $this->_tpl_vars['objeto']->name_web; ?>
</p>
			  <p>Todas las relaciones de categor&iacute;as con este servicio ser&aacute;n borradas</p>
			  <?php echo $this->_tpl_vars['message']; ?>

  			  <br>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>