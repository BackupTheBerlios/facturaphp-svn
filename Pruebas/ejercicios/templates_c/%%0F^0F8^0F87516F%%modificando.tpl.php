<?php /* Smarty version 2.6.3, created on 2005-04-19 13:22:43
         compiled from modificando.tpl */ ?>
<html>
<head>
	<title>
		Modificando
	</title>
	<link rel="stylesheet" href="mistyle.css"> 
</head>
<body>
	<table align="center" >
		<tr>
			<td colspan="2">
				<h1> Cliente a Modificar</h1>
				<p align=right>
					<a href="gestion_cliente.php"><img src=imagenes/btCancelar.png></img></a>
				</p>
			</td>
		</tr>		
		<tr>
			<td>
				<form method="post" action="modificar_cliente.php" name="form_modificar" enctype="multipart/form-data" >
				<table align="center">
					<tr>
						<?php if (count($_from = (array)$this->_tpl_vars['nombrecampos'])):
    foreach ($_from as $this->_tpl_vars['nombre']):
?> 
									<td class="cabeceratabla">
										<?php echo $this->_tpl_vars['nombre']; ?>

									</td>
								<?php endforeach; unset($_from); endif; ?>
						<?php if (count($_from = (array)$this->_tpl_vars['valores'])):
    foreach ($_from as $this->_tpl_vars['campo']):
?> 			
					</tr>
					<tr>
						<?php $this->assign('i', 0); ?>
						<?php if (count($_from = (array)$this->_tpl_vars['campo'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['iten']):
?>
								 	 <td class="datostabla">
										<input type="label" value="<?php echo $this->_tpl_vars['iten']; ?>
" name="<?php echo $this->_tpl_vars['key']; ?>
"></input>
									 </td>
						<?php endforeach; unset($_from); endif; ?>
					</tr>
					<?php endforeach; unset($_from); endif; ?>	
					</a>
					<tr>
						<td>
							<input type="submit"></input>
						</td>
						<td>
							<input type="reset"></input>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
		
	</table>
	

</body>