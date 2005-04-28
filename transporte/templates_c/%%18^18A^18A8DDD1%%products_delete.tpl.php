<?php /* Smarty version 2.6.3, created on 2005-01-28 16:26:17
         compiled from products_delete.tpl */ ?>
<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar Producto </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=products&method=delete&id=<?php echo $this->_tpl_vars['objeto']->id_product; ?>
">			  
			  
			  <br>
			  <p>Se va a proceder al borrado del producto: <?php echo $this->_tpl_vars['objeto']->name_web; ?>
</p>
			  <p>Todas las relaciones de categor&iacute;as con este producto ser&aacute;n borradas</p>
			  <?php echo $this->_tpl_vars['message']; ?>

  			  <br>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>