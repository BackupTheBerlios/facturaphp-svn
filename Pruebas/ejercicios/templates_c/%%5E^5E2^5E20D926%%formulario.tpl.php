<?php /* Smarty version 2.6.3, created on 2005-04-18 13:39:23
         compiled from formulario.tpl */ ?>
<html>
<head>
	<title>Añadir</title>
	<link rel="stylesheet" href="mistyle.css"> 
</head>
<body>
<form method="post" action="aniadir_cliente.php" name="form_aniadir" enctype="multipart/form-data" >
<h1 align="center">A&ntilde;adir Clientes</h1>
<table align="center">
	<tr>
		<td >
			ID CLIENTE :		
		</td>
		<td>
			<input type="text" name="<?php echo $this->_tpl_vars['objeto']->ddbb_id; ?>
" id="<?php echo $this->_tpl_vars['objeto']->ddbb_id; ?>
"> </input>
		</td>
	</tr>
	<tr>
		<td>
			NOMBRE CLIENTE :		
		</td>
		<td>
			<input type="text" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
"> </input>
		</td>
	</tr>
	<tr>
		<td>
			TIPO DE CLIENTE :		
		</td>
		<td>
			<input type="text" name="<?php echo $this->_tpl_vars['objeto']->ddbb_tipo; ?>
" id="<?php echo $this->_tpl_vars['objeto']->ddbb_tipo; ?>
"> </input>
		</td>
	</tr>
		<tr>
		<td>
			<input type="submit" name="Enviar"></input>
		</td>
		<td>
			<input type="reset" name="Cancelar"></input>
		</td>
	</tr>
</table>
</form>

</body>
</html>