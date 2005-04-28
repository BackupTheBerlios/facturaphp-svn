<td valign="top">
<form method="post" action="index.php?module=cat_servs&method=modify&id={$objeto->id_cat_serv}" name="form_central" enctype="multipart/form-data">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>Modificar Categor&iacute;a de Servicio</td>
			  </tr>
		  </table>
						<br>
		<table width="250px" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos de la categoria:</td>
				  </tr>
					
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre:</td>
						<td> <input type="text" id="{$objeto->ddbb_name}" name="{$objeto->ddbb_name}" class="textoMenu" value="{$objeto->name}"><font class="error">{$error_name}</font></td>
					</tr>
					<tr>
						<td width="125px" align="right" class="CampoFormulario">Fotograf&iacute;a:</td>
						<td><a href="index.php?module=cat_servs&method=show&id={$objeto->id_cat_serv}"><img src="{$objeto->path_photo}" width="80" height="80"></a>
						<input type="file" name="{$objeto->ddbb_path_photo}"></input></td>	
				  </tr>
					 <tr>
						<td width="125px" align="right" class="CampoFormulario">Categor&iacute;a Padre:</td>
						<td> <select id="{$objeto->ddbb_id_parent_cat}" name="{$objeto->ddbb_id_parent_cat}">
						<option value="0" {if $objeto->id_parent_cat==0}selected{/if}>Ninguna</option>
						
						{section name="nombre" loop=$objeto->cat_servs_list}
							<option value="{$objeto->cat_servs_list[nombre].id_cat_serv}" {if $objeto->id_parent_cat==$objeto->cat_servs_list[nombre].id_cat_serv}selected{/if}>
								{$objeto->cat_servs_list[nombre].name}
							</option>
						{/section}	<font class="error">{$error_id_parent_cat}</font>					
						</td>
					</tr>
					  <tr>
						<td width="125" align="right" class="CampoFormulario">Descripcion:</td>
						<td rowspan="2" ><textarea name="{$objeto->ddbb_descrip}" class="textoMenu" id="{$objeto->ddbb_descrip}">{$objeto->descrip}</textarea><font class="error">{$error_descrip}</font></td>
					</tr>
		</table>
		</td>
		</tr>	

		<tr>
			<td align="center"><br><br>
			<input type="submit" name="submit_modify" id="submit_modify" value="A&ntilde;adir" class="botones">			
			<input type="reset" Value="Limpiar Datos" class="botones">
			</td>
		</tr>
	  	</table>
	</form>
</td>