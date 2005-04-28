<html>
<head>
	<title>Añadir</title>
	<link rel="stylesheet" href="mistyle.css"> 
</head>
<body>
<form method="post" action="Aniadir_Cliente.php" name="form_aniadir" enctype="multipart/form-data" >
<h1 align="center">A&ntilde;adir Clientes</h1>
<table align="center">
	<tr>
		<td >
			ID DEL CLIENTE :		
		</td>
		<td>
			<input type="text" name="{$objeto->ddbb_id}" id="{$objeto->ddbb_id}"></input>
		</td>
	</tr>
</table>
</form>

</body>
</html>