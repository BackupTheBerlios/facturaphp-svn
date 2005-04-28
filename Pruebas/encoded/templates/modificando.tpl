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
						{foreach from=$nombrecampos item=nombre} 
									<td class="cabeceratabla">
										{$nombre}
									</td>
								{/foreach}
						{foreach from=$valores item=campo} 			
					</tr>
					<tr>
						{assign var="i" value=0}
						{foreach   key=key item=iten from=$campo}
								 	 <td class="datostabla">
										<input type="label" value="{$iten}" name="{$key}"></input>
									 </td>
						{/foreach}
					</tr>
					{/foreach}	
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