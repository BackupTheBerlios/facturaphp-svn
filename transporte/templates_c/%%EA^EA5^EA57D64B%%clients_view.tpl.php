<?php /* Smarty version 2.6.3, created on 2005-04-07 18:35:52
         compiled from clients_view.tpl */ ?>
<td valign="top">
<?php echo $this->_tpl_vars['cadena']; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "capas.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#000000">
						<tr Class="CabeceraModulo">
						<td width="7%">
						<img src="pics/clientesico.png" width="32" height="32">
						</td>
						<td width="93%" valign="middle" nowrap>Detalle de cliente </td>
				</tr>
			  </table>
				<br>
				<TABLE width="95%" align="center">
					<tr class="cabeceraMultiLinea">
						<td width="50%" height="23" nowrap>Identificador de Empresa: <?php echo $this->_tpl_vars['objeto']->id_client; ?>
</td>
						<td nowrap width="50%"><?php unset($this->_sections['indice']);
$this->_sections['indice']['name'] = 'indice';
$this->_sections['indice']['loop'] = is_array($_loop=$this->_tpl_vars['acciones']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['indice']['show'] = true;
$this->_sections['indice']['max'] = $this->_sections['indice']['loop'];
$this->_sections['indice']['step'] = 1;
$this->_sections['indice']['start'] = $this->_sections['indice']['step'] > 0 ? 0 : $this->_sections['indice']['loop']-1;
if ($this->_sections['indice']['show']) {
    $this->_sections['indice']['total'] = $this->_sections['indice']['loop'];
    if ($this->_sections['indice']['total'] == 0)
        $this->_sections['indice']['show'] = false;
} else
    $this->_sections['indice']['total'] = 0;
if ($this->_sections['indice']['show']):

            for ($this->_sections['indice']['index'] = $this->_sections['indice']['start'], $this->_sections['indice']['iteration'] = 1;
                 $this->_sections['indice']['iteration'] <= $this->_sections['indice']['total'];
                 $this->_sections['indice']['index'] += $this->_sections['indice']['step'], $this->_sections['indice']['iteration']++):
$this->_sections['indice']['rownum'] = $this->_sections['indice']['iteration'];
$this->_sections['indice']['index_prev'] = $this->_sections['indice']['index'] - $this->_sections['indice']['step'];
$this->_sections['indice']['index_next'] = $this->_sections['indice']['index'] + $this->_sections['indice']['step'];
$this->_sections['indice']['first']      = ($this->_sections['indice']['iteration'] == 1);
$this->_sections['indice']['last']       = ($this->_sections['indice']['iteration'] == $this->_sections['indice']['total']);
?>				
				
						<?php if ($this->_tpl_vars['acciones'][$this->_sections['indice']['index']] == 'modify'): ?>
						<a href="index.php?module=clients&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_client; ?>
">
						<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0"></a>
						<?php else: ?>
						<a href="index.php?module=clients&method=<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
&id=<?php echo $this->_tpl_vars['objeto']->id_client; ?>
">
						<img src="pics/btn<?php echo $this->_tpl_vars['acciones'][$this->_sections['indice']['index']]; ?>
.gif" border="0" ></a>
						<?php endif; ?>
				
						<?php endfor; endif; ?></td>
							</tr>
					<tr>
						<td colspan="2">
							<table width="100%" align="center">
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Nombre:</td>
                                <td nowrap width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->name; ?>
</td>
								<td width="25%" nowrap class="camposVistas">CIF - NIF:</td>
                                <td width="25%" nowrap class="datosVista"><?php echo $this->_tpl_vars['objeto']->cif_nif; ?>
</td>                                
                              </tr>
                              <tr height="15px">
                                <td width="25%"  nowrap class="camposVistas">Nombre Completo:</td>
                                <td nowrap width="25%" class="datosVista"><?php echo $this->_tpl_vars['objeto']->full_name; ?>
</td>
								<td width="25%" nowrap class="datosVista">&nbsp;</td>
                                <td width="25%" nowrap class="datosVista">&nbsp;</td>                                
                              </tr>
                              </table>
               <!--         </td>
					</tr>
				</table>-->
							
					  <br>
					  <table align="center" width="400" cellspacing="0" cellpadding="0">
					  <tr>
					
					  	<td align="center" valign="baseline">
					<img src="pics/pestagna-contactssobre.gif" id="contacts" onClick="Ocultar(this,'contacts_1')" name="boton">
						</td>
						  	<td  align="center" >
					<img src="pics/pestagna-partes.gif" id="partes" onClick="Ocultar(this,'partes_1')" name="boton">
					</td>
					  	<td   align="center" >
					<img src="pics/pestagna-facturaspen.gif" id="facturaspen" onClick="Ocultar(this,'facturaspen_1')" name="boton">
					</td>
					  	<td  align="center">
					<img src="pics/pestagna-facturascob.gif" id="facturascob" onClick="Ocultar(this,'facturascob_1')" name="boton">
					</td>
					<td  align="center">
					<img src="pics/pestagna-albaranes.gif" id="albaranes" onClick="Ocultar(this,'albaranes_1')" name="boton">
					</td>
					</tr>
										  <tr>
					  	<td align="center" colspan="5"><img src="pics/barra.gif" height="15"></td>
				</tr>
					<!--<tr>
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
				</tr>-->
					  </table>
					  	 
					  <div name="divMostrar" id="divMostrar" >
						
					</div>					
					 <script>	
					  	document.getElementById("divMostrar").innerHTML = contacts_1;
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