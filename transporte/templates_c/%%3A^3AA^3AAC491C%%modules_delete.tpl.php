<?php /* Smarty version 2.6.3, created on 2004-11-19 01:50:26
         compiled from modules_delete.tpl */ ?>
<td valign="top">

	<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
				<tr Class="CabeceraModulo">
						<td width="7%">
                          <img src="pics/buscar.gif" width="32" height="31">						 
                          <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>
						  Borrar m&oacute;dulos </td>
				</tr>
	</table>
			  <form method="post" action="index.php?module=modules&method=delete&id=<?php echo $this->_tpl_vars['objeto']->id_module; ?>
">			  
			  
			  <br>
			  <p>Se va a proceder al borrado del m&oacute;dulo: <?php echo $this->_tpl_vars['objeto']->name_web; ?>
</p>
			  <p>Se borrar&aacute;n las relaciones con los metodos que le pertenezcan al igual que los permisos con los usuarios y grupos con los que este relacionado</p>
			  <!--<?php echo $this->_tpl_vars['message']; ?>
-->
  			  <br>
			  <table align="center"><tr><td align="center"><input type="submit" name="submit_delete" value="Borrar" class="botones"></td></tr></table>
			  </form>
			 
	  </td>