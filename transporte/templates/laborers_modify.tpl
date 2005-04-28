<td valign="top">

<form method="post" action="index.php?module=laborers&method=modify&id={$objeto->id_laborer}" name="form_central">
<script src="inc/calendar.js" type="text/javascript" language="javascript"></script>
	 <table align="center" width="100%">
	<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						 <!--<img src="pics/usuariosico.png" width="32" height="32">-->
						</td>
						<td width="93%" valign="middle"  nowrap>Modificar peón</td>
				</tr>
			  </table>
						<br>
	<table align="center" width="90%"><tr><td width ="40%"valign="top">
	<tr>
					  <td  colspan="2" align="center" class="cabeceraCampoFormulario">Datos del peón:</td>
		  </tr>
		<tr><td valign="top">		  
		<table width="250px" align="center" >

					 
				  <tr>
						<td width="125" class="CampoFormulario">Empleado:</td>
						<td><select name="empleados" id="empleados">						
						{section name="indice" loop=$empleados}
						  <option value="{$empleados[indice].id_emp}"{if $objeto->id_emp == $empleados[indice].id_emp} selected{/if}>{$empleados[indice].nombre_completo}</option>						 
						  {/section}
						</select></td>
					</tr>
					
					<tr>
						<td width="125" class="CampoFormulario" nowrap>Fecha de asignación:</td>
						<td > <input class="textoMenu" type="text" name="{$objeto->ddbb_date}" value="{$objeto->date}" "size="15" maxlength="99" class="textfield"  id="{$objeto->ddbb_date}">
				 	
                                    <script type="text/javascript">
                                    
                    <!--
                    document.write('<a title="Calendario" href="javascript:openCalendar(\'lang=es-utf-8&amp;server=1\', \'form_central\', \'{$objeto->ddbb_date}\', \'date\')"><img class="calendar" valign="center" src="pics/calendar.png" alt="Calendario"/></a>');
                    //-->
                    </script><font class="error">{$error_date}</font>
		    
						
						</td>
				 </tr>
				<tr>
						<td width="125" class="CampoFormulario">Vehículos de la empresa:</td>
						<td><select name="vehiculos">
						<input type="hidden" name="{$vehiculo->ddbb_id_vehicle}" id="{$vehiculo->ddbb_id_vehicle}" value="{$vehiculo->id_vehicle}"}
						{section name="indice" loop=$vehiculos}
						  <option value="{$vehiculos[indice].id_vehicle}"{if $objeto->id_vehicle == $vehiculos[indice].id_vehicle} selected{/if}>{$vehiculos[indice].alias}</option>						 
						  {/section}
						</select></td>
					</tr>
				</table>
			
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><br><br><input type="submit" name="submit_modify" value="Modificar" class="botones">
			<input type="reset" Value="Borrar Datos" class="botones">
			</td>
		</tr>
	  	</table> </td>
		</form></td>