<?php /* Smarty version 2.6.3, created on 2005-04-19 13:31:24
         compiled from verconsmarty.tpl */ ?>
<html>
<head>
	<title>
		A ver q se ve
	</title>
	<link rel="stylesheet" href="mistyle.css"> 
</head>
<body bgcolor="#000000">
	<table align="center" width="80%">
		<tr>
			<td colspan="2">
				<h1 align="center"><u><font color="orange">---</font> Listado de Clientes <font color="orange">---</font></u></h1>
				<p align=right>
					<a href="gestion_cliente.php"><img src=imagenes/pestagnaInicio.png></img></a>
				</p>
			</td>
		</tr>		
		<tr>
			<td>
				<table height="100%">
					<tr>
						<td valign="top">
							<a href="aniadir_cliente.php"><img src=imagenes/btNuevo2.png></img></a>
						</td>
					</tr>
				</table>
			</td>
			
			<td>
				<table align="center" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						
							<?php if (count($_from = (array)$this->_tpl_vars['nombrecampos'])):
    foreach ($_from as $this->_tpl_vars['nombre']):
?> 
								<td class="cabeceratabla">
									<?php echo $this->_tpl_vars['nombre']; ?>

								</td>
							<?php endforeach; unset($_from); endif; ?>
							<td class="cabeceratabla">
								Opciones
							</td>
					</tr>
					
					<?php if (count($_from = (array)$this->_tpl_vars['valores'])):
    foreach ($_from as $this->_tpl_vars['campo']):
?> 
					
					<tr>
						<?php $this->assign('i', 0); ?>
						<?php if (count($_from = (array)$this->_tpl_vars['campo'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['iten']):
?>
								 <td class="datostabla">
								 	<?php echo $this->_tpl_vars['iten']; ?>

								 	<?php if ($this->_tpl_vars['key'] == 'id_cliente'): ?>
									 	<?php $this->assign('id', $this->_tpl_vars['iten']); ?>
									 <?php endif; ?>							 
								 </td>
						<?php endforeach; unset($_from); endif; ?>
								<td class="datostabla" >
								<p align="right">
										<a href="ver_cliente.php?id_clien=<?php echo $this->_tpl_vars['id']; ?>
"><img src=imagenes/btVer.png></img></a>
										<a href="borrar_cliente.php?id_clien=<?php echo $this->_tpl_vars['id']; ?>
"><img src=imagenes/btBorrar.png></img></a>
										<a href="modificar_cliente.php?id_clien=<?php echo $this->_tpl_vars['id']; ?>
"><img src=imagenes/btEditar.png></img></a>
								</p>
								</td>
					</tr>
					<?php endforeach; unset($_from); endif; ?>	
					</a>
				</table>
				
			</td>
		</tr>
		<tr>
			<td colspan="2">
					<marquee><font color="white">fabricado </font><font color="black">con el </font><font color="green">php y</font><font color="yellow"> compa&ntilde;ia </font><font color="red">je je je</font></marquee>
			</td>
		</tr>		
	</table>
	<br><br><br>	

</body>
</html>