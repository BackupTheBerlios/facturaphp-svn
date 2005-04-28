<?php /* Smarty version 2.6.3, created on 2005-04-07 18:13:30
         compiled from contacts_add.tpl */ ?>
<td valign="top">


<form method="post" action="index.php?module=contacts&method=add" name="form_central">
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
						<td width="93%" valign="middle"  nowrap>A&ntilde;adir contacto</td>
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
						<td> <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_name; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->name; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_name']; ?>
</font></td>
					</tr>
					<tr>
						<td width="125" class="CampoFormulario" >Primer apellido: </td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->last_name; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_last_name']; ?>
</font></td>
				  </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Segundo apellido:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name2; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_last_name2; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->last_name2; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_last_name2']; ?>
</font></td>
				  </tr>
				  <tr>
						<td width="125" class="CampoFormulario" nowrap>Fecha de nacimiento:</td>
						<td > 
							<input class="textoMenu" type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_birthday; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_birthday; ?>
"  value="<?php echo $this->_tpl_vars['objeto']->birthday; ?>
" size="15" maxlength="99" class="textfield">
                                    <script type="text/javascript">
                                    
                    <!--
                    document.write('<a title="Calendario" href="javascript:openCalendar(\'lang=es-utf-8&amp;server=1\', \'form_central\', \'<?php echo $this->_tpl_vars['objeto']->ddbb_birthday; ?>
\', \'date\')"><img class="calendar" valign="center" src="pics/calendar.png" alt="Calendario"/></a>');
                    //-->
                    </script>
		    
						<font class="error"><?php echo $this->_tpl_vars['error_birthday']; ?>
</font>
						</td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Direcci&oacute;n:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_address; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_address; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->address; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_address']; ?>
</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">C&oacute;digo postal:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_postal_code; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_postal_code; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->postal_code; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_postal_code']; ?>
</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Localidad:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_city; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_city; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->city; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_city']; ?>
</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Provincia:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_state; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_state; ?>
" class="textoMenu"  value="<?php echo $this->_tpl_vars['objeto']->state; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_state']; ?>
</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Pa&iacute;s:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_country; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_country; ?>
" class="textoMenu"  value="<?php echo $this->_tpl_vars['objeto']->country; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_country']; ?>
</font></td>
				 </tr>
				 
				</table>
			
			</td>
			<td width ="60%" valign="top">
			
			<table width="250px" align="center">
			<tr><td cospan="2" class="cabeceraCampoFormulario"></td></tr>
			 <tr>
						<td width="125" class="CampoFormulario">Tel&eacute;fono:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_phone; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_phone; ?>
" class="textoMenu"  value="<?php echo $this->_tpl_vars['objeto']->phone; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_phone']; ?>
</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">Tel&eacute;fono m&oacute;vil:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_mobile_phone; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_mobile_phone; ?>
" class="textoMenu"  value="<?php echo $this->_tpl_vars['objeto']->mobile_phone; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_mobile_phone']; ?>
</font></td>
				 </tr>
				<tr>
						<td width="125" class="CampoFormulario">Fax:</td>
						<td > <input type="text" id="<?php echo $this->_tpl_vars['objeto']->ddbb_fax; ?>
" name="<?php echo $this->_tpl_vars['objeto']->ddbb_fax; ?>
" class="textoMenu" value="<?php echo $this->_tpl_vars['objeto']->fax; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_fax']; ?>
</font></td>
				 </tr>
				  <tr>
						<td width="125" class="CampoFormulario">E-mail:</td>
						<td > <input name="<?php echo $this->_tpl_vars['objeto']->ddbb_mail; ?>
" type="text" class="textoMenu" id="<?php echo $this->_tpl_vars['objeto']->ddbb_mail; ?>
"  value="<?php echo $this->_tpl_vars['objeto']->mail; ?>
"><font class="error"><?php echo $this->_tpl_vars['error_mail']; ?>
</font></td>
				 </tr>				  
				 
				
			</table>
			<br>
			
			</td>
</tr>	
		
		<tr>
			<td align="center" colspan="2"><br><br><input type="submit" name="submit_add" value="A&ntilde;adir" class="botones">
			<input type="reset" Value="Borrar Datos" class="botones">
			</td>
		</tr>
	  	</table> </td></tr></table>
		</form></td>