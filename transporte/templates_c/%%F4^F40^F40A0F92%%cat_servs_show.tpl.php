<?php /* Smarty version 2.6.3, created on 2005-03-09 14:44:42
         compiled from cat_servs_show.tpl */ ?>
<td valign="top">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "capas.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<table align="center" width="100%">
		<tr>
		<td valign="top">
	<table width="100%">
		<tr Class="CabeceraModulo"><td align=center>Nombre de la categor&iacute;a: <?php echo $this->_tpl_vars['objeto']->name; ?>
</td></tr>
		<tr><td></td></tr>
		<tr><td align=center><img src="<?php echo $this->_tpl_vars['objeto']->path_photo; ?>
" align=middle></td></tr>
		<tr><td></td></tr>
		<tr><td align=center><a href="javascript:history.go(-1)">- Volver -</a></td></tr>
	</table>
	</td>
	</tr>
	</table>
</td>