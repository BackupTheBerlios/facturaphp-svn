<td valign="top">
{$cadena}
{include file=capas.tpl}
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de empresa </td>
				</tr>
			  </table>
				<br>
				<TABLE width="95%" align="center">
					<tr class="cabeceraMultiLinea">
						<td width="50%" height="23" nowrap>Identificador de Empresa: {$objeto->id_corp}</td>
						<td nowrap width="50%">{section name="indice" loop=$acciones}				
				
						{if $acciones[indice]== 'modify'}
						<a href="index.php?module=corps&method={$acciones[indice]}&id={$objeto->id_corp}">
						<img src="pics/btn{$acciones[indice]}.gif" border="0"></a>
						{else}
						<a href="index.php?module=corps&method={$acciones[indice]}&id={$objeto->id_corp}">
						<img src="pics/btn{$acciones[indice]}.gif" border="0" ></a>
						{/if}
				
						{/section}</td>
							</tr>
					<tr>
						<td colspan="2">
							<table width="100%" align="center">
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Nombre:</td>
                                <td nowrap width="25%" class="datosVista">{$objeto->name}</td>
								<td width="25%" nowrap class="camposVistas">CIF - NIF:</td>
                                <td width="25%" nowrap class="datosVista">{$objeto->cif_nif}</td>                                
                              </tr></table>
               <!--         </td>
					</tr>
				</table>-->
							
					  <br>
					  <table align="center" width="400" cellspacing="0" cellpadding="0">
					  <tr>
					
					  	<td align="center" valign="baseline">
					<img src="pics/pestagna-empssobre.gif" id="emps" onClick="Ocultar(this,'emps_1')" name="boton">
						</td>
						  	<td  align="center">
					<img src="pics/pestagna-clients.gif" id="clients" onClick="Ocultar(this,'clients_1')" name="boton"> 					</td>
					  	<td   align="center" >
					<img src="pics/pestagna-facturaspen.gif" id="facturaspen" onClick="Ocultar(this,'facturaspen_1')" name="boton">
					</td>
					  	<td  align="center">
					<img src="pics/pestagna-facturascob.gif" id="facturascob" onClick="Ocultar(this,'facturascob_1')" name="boton">
					</td>
					</tr>
										  <tr>
					  	<td align="center" colspan="4"><img src="pics/barra.gif" height="15"></td>
				</tr>
					<tr>
					<td  align="center">
					<img src="pics/pestagna-products.gif" id="products" onClick="Ocultar(this,'products_1')" name="boton"> 					</td>
					  	<td   align="center">
					<img src="pics/pestagna-services.gif" id="services" onClick="Ocultar(this,'services_1')" name="boton">
						</td>
					  	
					  	<td align="center">
					<img src="pics/pestagna-gestionalm.gif" id="gestionalm" onClick="Ocultar(this,'gestionalm_1')" name="boton"> 					</td>
					<td  align="center" >
					<img src="pics/pestagna-partes.gif" id="partes" onClick="Ocultar(this,'partes_1')" name="boton">
					</td>
					  </tr>
					  <tr>
					  	<td align="center" colspan="4"><img src="pics/barra.gif" height="15"></td>
				</tr>
					  </table>
					  	 
					  <div name="divMostrar" id="divMostrar" >
						
					</div>					
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = emps_1;
					  </script>
					  <br>
					  <table align="center" width="400" cellpadding="0" cellspacing="0">
						  <tr><td><img src="pics/barra.gif"></td></tr>
					  </table>
					  <br>
					  
					  					  </td>
						
					</tr>
					
					<tr class="cabeceraMultiLinea">
						<td colspan="2">&nbsp;
						</td>
					</tr>
					
				</TABLE>
			</td>