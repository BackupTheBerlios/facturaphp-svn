<td valign="top">


<form method="post" action="index.php?module=contacts&method=modify&id={$objeto->id_contact}" name="form_central">
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
						<td width="93%" valign="middle"  nowrap>Modificar contacto</td>
				</tr>
			  </table>
						<br>
	<table align="center" width="90%"><tr><td width ="40%"valign="top">
	<tr>
					  <td  colspan="2" class="cabeceraCampoFormulario">Datos del empleado:</td>
		  </tr>
		<tr><td valign="top">

		
			
		  <table width="250px" align="center" >

					 
				  <tr>
						<td width="125" align="right" class="CampoFormulario">Nombre:</td>
						<td> <input type="text" id="{$objeto->ddbb_name}" name="{$objeto->ddbb_name}" class="textoMenu" value="{$objeto->name}"><font class="error">{$error_name}</font></td>
					</tr>
					<tr>
						<td width="125" class="CampoFormulario" >Primer apellido: </td>
						<td > <input type="text" id="{$objeto->ddbb_last_name}" name="{$objeto->ddbb_last_name}" class="textoMenu" value="{$objeto->last_name}"><font class="error">{$error_last_name}</font></td>
				  </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Segundo apellido:</td>
						<td > <input type="text" id="{$objeto->ddbb_last_name2}" name="{$objeto->ddbb_last_name2}" class="textoMenu" value="{$objeto->last_name2}"><font class="error">{$error_last_name2}</font></td>
				  </tr>
				  <tr>
						<td width="125" class="CampoFormulario" nowrap>Fecha de nacimiento:</td>
						<td > 
							<input class="textoMenu" type="text" id="{$objeto->ddbb_birthday}" name="{$objeto->ddbb_birthday}"  value="{$objeto->birthday}" size="15" maxlength="99" class="textfield">
                                    <script type="text/javascript">
                                    
                    <!--
                    document.write('<a title="Calendario" href="javascript:openCalendar(\'lang=es-utf-8&amp;server=1\', \'form_central\', \'{$objeto->ddbb_birthday}\', \'date\')"><img class="calendar" valign="center" src="pics/calendar.png" alt="Calendario"/></a>');
                    //-->
                    </script>
		    
						<font class="error">{$error_birthday}</font>
						</td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Direcci&oacute;n:</td>
						<td > <input type="text" id="{$objeto->ddbb_address}" name="{$objeto->ddbb_address}" class="textoMenu" value="{$objeto->address}"><font class="error">{$error_address}</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">C&oacute;digo postal:</td>
						<td > <input type="text" id="{$objeto->ddbb_postal_code}" name="{$objeto->ddbb_postal_code}" class="textoMenu" value="{$objeto->postal_code}"><font class="error">{$error_postal_code}</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Localidad:</td>
						<td > <input type="text" id="{$objeto->ddbb_city}" name="{$objeto->ddbb_city}" class="textoMenu" value="{$objeto->city}"><font class="error">{$error_city}</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Provincia:</td>
						<td > <input type="text" id="{$objeto->ddbb_state}" name="{$objeto->ddbb_state}" class="textoMenu"  value="{$objeto->state}"><font class="error">{$error_state}</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Pa&iacute;s:</td>
						<td > <input type="text" id="{$objeto->ddbb_country}" name="{$objeto->ddbb_country}" class="textoMenu"  value="{$objeto->country}"><font class="error">{$error_country}</font></td>
				 </tr>
				 
				</table>
			
			</td>
			<td width ="60%" valign="top">
			
			<table width="250px" align="center">
			<tr><td cospan="2" class="cabeceraCampoFormulario"></td></tr>
			 <tr>
						<td width="125" class="CampoFormulario">Tel&eacute;fono:</td>
						<td > <input type="text" id="{$objeto->ddbb_phone}" name="{$objeto->ddbb_phone}" class="textoMenu"  value="{$objeto->phone}"><font class="error">{$error_phone}</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Tel&eacute;fono m&oacute;vil:</td>
						<td > <input type="text" id="{$objeto->ddbb_mobile_phone}" name="{$objeto->ddbb_mobile_phone}" class="textoMenu"  value="{$objeto->mobile_phone}"><font class="error">{$error_mobile_phone}</font></td>
				 </tr>
				<tr>
						<td width="125" class="CampoFormulario">Fax:</td>
						<td > <input type="text" id="{$objeto->ddbb_fax}" name="{$objeto->ddbb_fax}" class="textoMenu" value="{$objeto->fax}"><font class="error">{$error_fax}</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">E-mail:</td>
						<td > <input name="{$objeto->ddbb_mail}" type="text" class="textoMenu" id="{$objeto->ddbb_mail}"  value="{$objeto->mail}"><font class="error">{$error_mail}</font></td>
				 </tr>				  
				 
				
			</table>
			<br>
			
			</td>
</tr>	
		
		<tr>
			<td align="center" colspan="2"><br><br><input type="submit" name="submit_modify" value="Modificar" class="botones">
			<input type="reset" Value="Borrar Datos" class="botones">
			</td>
		</tr>
	  	</table> </td></tr></table>
		</form></td>