<td valign="top">
{include file=checkbox.tpl}
<form method="post" action="index.php?module=users&method=add" name="form_central">
	  	<table align="center" width="100%">
		<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						 <img src="pics/usuariosico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle"  nowrap>Alta de usuarios</td>
			  </tr>
		  </table>
						<br>
		<table width="90%" align="center" border="0"><tr><td>
		<table width="50%" align="left">

					<tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos de Login:</td>
				  </tr>
					<tr>
						<td width="125px" align="right" class="CampoFormulario" nowrap>Login:</td>
						<td > <input type="text" id="{$objeto->ddbb_login}" name="{$objeto->ddbb_login}" class="textoMenu" value="{$objeto->login}"><font class="error">{$error_login}</font></td>
					</tr>
					<tr>
						<td width="125px" class="CampoFormulario">Password:</td>
						<td > <input type="password" id="{$objeto->ddbb_passwd}" name="{$objeto->ddbb_passwd}" class="textoMenu" value="{$objeto->passwd}"><font class="error">{$error_passwd}</font></td>
				  </tr>
				  <tr>
						<td width="125px" class="CampoFormulario">Re-escriba password:</td>
						<td > <input type="password" id="retype" name="retype" class="textoMenu" value="{$objeto->retype}"><font class="error">{$error_retype}</font></td>
				  </tr>
				  <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Datos del Usuario:</td>
				  </tr>
				 <tr>
						<td width="125px" align="right" class="CampoFormulario">Nombre:</td>
						<td> <input type="text" id="{$objeto->ddbb_name}" name="{$objeto->ddbb_name}" class="textoMenu" value="{$objeto->name}"><font class="error">{$error_name}</font></td>
					</tr>
					<tr>
						<td width="125px" class="CampoFormulario" >Primer Apellido:</td>
						<td > <input type="text" id="{$objeto->ddbb_last_name}" name="{$objeto->ddbb_last_name}" class="textoMenu" value="{$objeto->last_name}"><font class="error">{$error_last_name}</font></td>
				  </tr>
				  <tr>
						<td width="125px" class="CampoFormulario">Segundo Apellido:</td>
						<td > <input type="text" id="{$objeto->ddbb_last_name2}" name="{$objeto->ddbb_last_name2}" class="textoMenu" value="{$objeto->last_name2}"><font class="error">{$error_last_name2}</font></td>
				  </tr>
				   <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Permisos: </td>
				  </tr>
				  <tr>
				  	<td colspan="2">
				  		<input type="button" Value="Seleccionar Todos" class="botones" onClick="selectAll();">
					<input type="button" Value="Deseleccionar Todos" class="botones" onClick="unselectAll();">
				  	</td>
				  </tr>

			
		</table>
		</td><td>
		<table width="100%" align="center" border="0">
			 <tr>
					  <td colspan="2" class="cabeceraCampoFormulario">Grupos: </td>
			</tr>
			<tr class="cabeceraMultiLinea">
				<td width="100%" colspan="2">Grupos</td>				
			</tr>
			
			{php}
				$linea = 0;
			{/php}
			{section name="indice" loop=$grupos}
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
				<td>
				<input type="checkbox" value="1" name="grupo_{$grupos[indice]->id_group}" {if $grupos[indice]->belong==true}checked{/if}>{$grupos[indice]->name_web}
				{php}$this->_sections['indice']['index']+=1;
					$this->_sections['indice']['iteration']+=1;{/php}
				
				</td>
				{if !$smarty.section.indice.last}
				<td>
				<input type="checkbox" value="1" name="grupo_{$grupos[indice]->id_group}" {if $grupos[indice]->belong==true}checked{/if}>{$grupos[indice]->name_web}
				</td>
				{else}
				<td>
				&nbsp;
				</td>
				{/if}
				</tr>
			{/section}
			<tr class="cabeceraMultilinea"><td colspan="2">&nbsp</td></tr>
			</table>
		</td></tr></table>
		
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