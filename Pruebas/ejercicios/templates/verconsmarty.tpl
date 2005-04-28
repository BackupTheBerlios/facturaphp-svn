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
						
							{foreach from=$nombrecampos item=nombre} 
								<td class="cabeceratabla">
									{$nombre}
								</td>
							{/foreach}
							<td class="cabeceratabla">
								Opciones
							</td>
					</tr>
					
					{foreach from=$valores item=campo} 
					
					<tr>
						{assign var="i" value=0}
						{foreach   key=key item=iten from=$campo}
								 <td class="datostabla">
								 	{$iten}
								 	{if $key == "id_cliente"}
									 	{assign var="id" value=$iten}
									 {/if}							 
								 </td>
						{/foreach}
								<td class="datostabla" >
								<p align="right">
										<a href="ver_cliente.php?id_clien={$id}"><img src=imagenes/btVer.png></img></a>
										<a href="borrar_cliente.php?id_clien={$id}"><img src=imagenes/btBorrar.png></img></a>
										<a href="modificar_cliente.php?id_clien={$id}"><img src=imagenes/btEditar.png></img></a>
								</p>
								</td>
					</tr>
					{/foreach}	
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