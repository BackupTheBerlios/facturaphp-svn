<?php /* Smarty version 2.6.3, created on 2005-03-04 19:08:56
         compiled from cat_prods_delete.tpl */ ?>
<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar categor&iacute;as de producto </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=cat_prods&method=delete&id=<?php echo $this->_tpl_vars['objeto']->id_cat_prod; ?>
">			  
			  
			  <br>
			  <p>Se va a proceder al borrado de la categor&iacute;a: <?php echo $this->_tpl_vars['objeto']->name; ?>
</p>
			  <p>Todas las categor&iacute;as que puedan tener a &eacute;sta como categor&iacute;a padre, no se borrar&aacute;n.
			  <?php echo $this->_tpl_vars['message']; ?>

  			  <br>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>