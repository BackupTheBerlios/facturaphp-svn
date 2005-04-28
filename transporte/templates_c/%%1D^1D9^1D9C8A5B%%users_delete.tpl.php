<?php /* Smarty version 2.6.3, created on 2004-11-30 15:28:13
         compiled from users_delete.tpl */ ?>
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
			  <form method="post" action="index.php?module=users&method=delete&id=<?php echo $this->_tpl_vars['objeto']->id_user; ?>
">			  
			  
			  <br>
			  <p>Se va a proceder al borrado del usuario: <?php echo $this->_tpl_vars['objeto']->login; ?>
</p>
			  <p>Se borrar&aacute;n las relaciones con los grupos a los que pertenezca al igual que los permisos a modulos y metodos en los que esté relacionado</p>
			  <?php echo $this->_tpl_vars['message']; ?>

  			  <br>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>