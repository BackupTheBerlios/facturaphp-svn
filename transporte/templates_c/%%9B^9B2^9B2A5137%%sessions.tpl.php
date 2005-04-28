<?php /* Smarty version 2.6.3, created on 2005-04-21 12:46:45
         compiled from sessions.tpl */ ?>
		<table width="90%" class="cajaMenu" cellpadding="3" cellspacing="0">
			<tr >
			  <td class="cabeceraMenu" colspan="2">.:Usuarios:.</td>
			</tr>
			<tr class="textoMenuUsuarios">			 
			<td><img src="pics/usuariosico.png"></td>
			  <td>
			  	Conectados: <b><?php echo $this->_tpl_vars['num_sessions']; ?>
</b><br>
			  	Registrados: <b><?php echo $this->_tpl_vars['num_users']; ?>
</b>
			  </td>
			</tr>
		</table>