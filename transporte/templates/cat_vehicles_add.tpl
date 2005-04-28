<td valign="top">

<form method="post" action="index.php?module=cat_vehicles&method=add" name="form_central" enctype="multipart/form-data">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>Alta de categor&iacute;as de veh&iacute;culos</td>
			  </tr>
		  </table>
						<br>
		<table width="250px" align="center">

				<tr>
					<td colspan="2" class="cabeceraCampoFormulario">Datos de la categor&iacute;a del veh&iacute;culo:</td>
				</tr>
				<tr>
						<td width="125px" align="right" class="CampoFormulario" nowrap>Nombre de la categor&iacute;a:</td>
						<td > <input type="text" id="{$objeto->ddbb_name}" name="{$objeto->ddbb_name}" class="textoMenu" value="{$objeto->name}"><font class="error">{$error_name}</font></td>
					</tr>
					<tr>
						<td width="125px" class="CampoFormulario">Nombre de la categor&iacute;a en la web:</td>
						<td > <input type="text" id="{$objeto->ddbb_name_web}" name="{$objeto->ddbb_name_web}" class="textoMenu" value="{$objeto->name_web}"><font class="error">{$error_name_web}</font></td>
				  </tr>
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Descripci&oacute;n:</td>
						<td> <input type="text" id="{$objeto->ddbb_descrip}" name="{$objeto->ddbb_descrip}" class="textoMenu" value="{$objeto->descrip}"><font class="error">{$error_descrip}</font></td>
				  </tr>
				</table>
		</td>
		</tr>	
		
		<tr>

			<td valign="top">
			<br>
			<br> 
											
		</td>
		</tr>
		<tr>
			<td align="center"><br><br>
			<input type="submit" name="submit_add" id =" name="submit_add" "value="A&ntilde;adir" class="botones">			
			<input type="reset" Value="Limpiar Datos" class="botones">
			</td>
		</tr>
	  	</table> 
	</form>
</td>
