<td valign="top">
{include file=checkbox.tpl}
<form method="post" action="index.php?module=groups&method=add" name="form_central">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>Alta de grupos</td>
			  </tr>
		  </table>
						<br>
		<table width="250px" align="center">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos del grupo :</td>
				  </tr>
					<tr>
						<td width="125" align="right" class="CampoFormulario" nowrap>Nombre:</td>
						<td > <input type="text" id="{$objeto->ddbb_name}" name="{$objeto->ddbb_name}" class="textoMenu" value="{$objeto->name}"><font class="error">{$error_name}</font></td>
					</tr>
					<tr>
						<td width="125" class="CampoFormulario">Nombre web: </td>
						<td > <input type="text" id="{$objeto->ddbb_name_web}" name="{$objeto->ddbb_name_web}" class="textoMenu" value="{$objeto->name_web}"><font class="error">{$error_name_web}</font></td>
				  </tr>
				  <tr>
						<td width="125" align="right" class="CampoFormulario">Descripcion:</td>
						<td rowspan="2" ><textarea name="{$objeto->ddbb_descrip}" class="textoMenu" id="{$objeto->ddbb_descrip}">{$objeto->descrip}</textarea> <font class="error">{$error_descrip}</font></td>
					</tr>
					<tr>
					  <td colspan="2" >&nbsp;</td>
				  </tr>
					 <tr>
				  	<td colspan="2">
				  		<input type="button" Value="Seleccionar Todos" class="botones" onClick="selectAll();">
					<input type="button" Value="Deseleccionar Todos" class="botones" onClick="unselectAll();">
				  	</td>
				  </tr>
				</table>
</td>
		</tr>		
		<tr>

			<td valign="top">
			<br>
			<br>    
			
			<table width="90%" align="center" border="0">
			 <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Permisos por modulos-metodos: </td>
			</tr>
			<tr class="cabeceraMultiLinea">
				<td width="30%">Nombre de Modulo</td>
				<td Colspan="4" width="70%">Metodos</td>
			</tr>
			
			{php}
				$linea = 0;
			{/php}
			{section name="indice" loop=$modulos->per_modules}
				{php}
				if ($linea==0){
					$clase="multiLinea1";
					$linea=1;
				}				
				else{
					$clase="multiLinea2";	
					$linea=0;
				}				
				print('<tr class="'.$clase.'">');
				{/php}

				{if $modulos->per_modules[indice]->per==1}
					<td nowrap><input type="checkbox" name="modulo_{$modulos->per_modules[indice]->id_module}" value="1" onClick="selectRow()" checked> {$modulos->per_modules[indice]->module_name}</td> 
				{else}
					<td nowrap><input type="checkbox" name="modulo_{$modulos->per_modules[indice]->id_module}" value="1" onClick="selectRow()"> {$modulos->per_modules[indice]->module_name}</td> 				
				{/if}
				<td nowrap>						
					<table width="100%"><tr class="{php}print($clase);{/php}">				
					 {section name="j" loop=$modulos->per_modules[indice]->per_methods}
						{if $modulos->per_modules[indice]->per_methods[j]->per==1}
							<td width="20%"><input type="checkbox" name="modulo_{$modulos->per_modules[indice]->id_module}_metodo_{$modulos->per_modules[indice]->per_methods[j]->id_method}" value="1" checked>{$modulos->per_modules[indice]->per_methods[j]->method_name_web}</td>
						{else}
							<td width="20%"><input type="checkbox" name="modulo_{$modulos->per_modules[indice]->id_module}_metodo_{$modulos->per_modules[indice]->per_methods[j]->id_method}" value="1">{$modulos->per_modules[indice]->per_methods[j]->method_name_web}</td>
						{/if}
					{/section}   
					</tr></table>
				</td>				
				</tr>				
			{/section}
			<tr  class="cabeceraMultiLinea"><td colspan="2">&nbsp;</td></tr>
			</table>
		
											
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