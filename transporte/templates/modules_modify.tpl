<td valign="top">
<form method="post" action="index.php?module=modules&method=modify&id={$objeto->id_module}" name="form_central">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>Modificar M&oacute;dulo</td>
			  </tr>
		  </table>
						<br>
		<table width="250px" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos del m&oacute;dulo:</td>
				  </tr>		
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre Web:</td>
						<td> <input type="text" id="{$objeto->ddbb_name_web}" name="{$objeto->ddbb_name_web}" class="textoMenu" value="{$objeto->name_web}"><font class="error">{$error_name_web}</font></td>
					</tr>				  			
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre:</td>
						<td> <input type="text" id="{$objeto->ddbb_name}" name="{$objeto->ddbb_name}" class="textoMenu" value="{$objeto->name}"><font class="error">{$error_name}</font></td>
					</tr>
				  <tr>
						<td width="125px" align="right" class="CampoFormulario">Ruta:</td>
						<td> <input type="text" id="{$objeto->ddbb_path}" name="{$objeto->ddbb_path}" class="textoMenu" value="{$objeto->path}"><font class="error">{$error_path}</font></td>
					</tr>
				 <tr>
						<td width="125px" align="right" class="CampoFormulario">Activo:</td>
						<td> <select class="textoMenu" name="{$objeto->ddbb_active}" id="{$objeto->ddbb_active}">
							<option value="0" {if $objeto->active==0}selected{/if}>No</option>
							<option value="1" {if $objeto->active==1}selected{/if}>Sí</option>
						</select></td>
					</tr>	
				<tr>
						<td width="125px" align="right" class="CampoFormulario">P&uacute;blico:</td>
						<td> <select class="textoMenu"  name="{$objeto->ddbb_public}" id="{$objeto->ddbb_public}">
							<option value="0" {if $objeto->publico==0}selected{/if}>No</option>
							<option value="1" {if $objeto->publico==1}selected{/if}>Sí</option>
						</select> </td>
					</tr>		
				<tr>
						<td width="125px" align="right" class="CampoFormulario">Depende de:</td>
						<td><select class="textoMenu"  name="{$objeto->ddbb_parent}" id="{$objeto->ddbb_parent}">
							<option value="-2" {if $objeto->parent==-2}selected{/if}>Ninguno (sin enlace)</option>
							<option value="0" {if $objeto->parent==0}selected{/if}>Ninguno (con enlace)</option>
							{section name="indice" loop="$padres"}
								{if $padres[indice].id_module != $objeto->id_module}
								<option value="{$padres[indice].id_module}" {if $objeto->parent==$padres[indice].id_module}selected{/if} >{$padres[indice].name_web}</option>
								{/if}
							{/section}
							
						</select></td>
				</tr>

		</table>
		<br>
			<table width="90%" align="center">
				<tr class="cabeceracampoFormulario">
					<td colspan="6">M&eacute;todos que tendra:</td>
				</tr>
					<tr class="cabeceraMultilinea">
					  <td colspan="6">&nbsp;</td>
				  </tr>
				  <tr class="multilinea1">
				  
						<td align="center" class="multilinea1"><input type="checkbox" name="list" value="Listar" {if $module_methods.list.name == "list"}checked{/if}>Listar</td>
						<td align="center" class="multilinea1"><input type="checkbox" name="select" value="Seleccionar" {if $module_methods.select.name == "select"}checked{/if}>Seleccionar</td>
						<td align="center" class="multilinea1"><input type="checkbox" name="view" value="Ver" {if $module_methods.view.name == "view"}checked{/if}>Ver</td>
						<td align="center" class="multilinea1"><input type="checkbox" name="add" value="A&ntilde;adir" {if $module_methods.add.name == "add"}checked{/if}>A&ntilde;adir</td>						
						<td align="center" class="multilinea1"><input type="checkbox" name="modify" value="Modificar" {if $module_methods.modify.name == "modify"}checked{/if}>Modificar</td>
						<td align="center" class="multilinea1"><input type="checkbox" name="delete" value="Borrar" {if $module_methods.delete.name == "delete"}checked{/if}>Borrar</td>
				</tr>
			<tr class="cabeceraMultilinea">
					  <td colspan="6">&nbsp;</td>
				  </tr>
		</table>
		<p align="center">CUIDADO: Si elimina algun m&eacute;todo que tenga algun permiso con algun usuario o grupo, estos se borrarán</p>
		
		</td>
		</tr>	

		<tr>
			<td align="center"><br><br>
			<input type="submit" name="submit_modify" value="Modificar" class="botones">			
			<input type="reset" Value="Limpiar Datos" class="botones">
			</td>
		</tr>
	  	</table>
	</form>
</td>