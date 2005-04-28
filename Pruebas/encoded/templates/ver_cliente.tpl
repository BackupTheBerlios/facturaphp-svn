<html>
<head>
	<title>Datos del cliente</title>
	<link rel="stylesheet" href="mistyle.css"> 
</head>
<body>
<h1 align="center">DATOS DEL CLIENTE</h1>
<table align="center">
	<tr>
		<td >
			ID :		
		</td>
		<td>
			{$objeto->ddbb_id}
		</td>
	</tr>
	<tr>
		<td>
			NOMBRE :		
		</td>
		<td>
			{$objeto->ddbb_name}
		</td>
	</tr>
	<tr>
		<td>
			TIPO :		
		</td>
		<td>
			<input type="text" name="{$objeto->ddbb_tipo}" id="{$objeto->ddbb_tipo}"></input>
		</td>
	</tr>
		<tr>
		<td>
			Borrar
		</td>
		<td>
			Editar
		</td>
	</tr>
</table>
</form>

</body>
</html>