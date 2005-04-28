<?php /* Smarty version 2.6.3, created on 2004-10-25 17:34:51
         compiled from user_corps.tpl */ ?>
<td valign="top">

	

<table width="100%" cellpadding="10" cellspacing="10"  bgcolor="#F0FFFF">
	<tr class="barraNavegacion">
		<td align="middle" valign="middle"><font color="#000000">Empresas</font></td>
	</tr>
</table>
<br>
<br>    

	<table width="50%" align="center" border="0">
	<tr class="cabeceraMultiLinea">
		<td width="30%">Empresas en las que trabaja
		</td>
		<td Colspan="4" width="70%">Acción</td>
	</tr>
<?php 
	$linea = 0;
  unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['user_corps']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
	<?php if ($this->_tpl_vars['linea'] == 0): ?>
	<tr class="multiLinea1">
		<?php 
				$linea=1;
		 ?>
	<?php else: ?>
	<tr class="multiLinea2">
		<?php 
				$linea=0;
		 ?>
	<?php endif; ?>
	
	<td width="25%"  nowrap class="camposVistas"><?php echo $this->_tpl_vars['user_corps'][$this->_sections['i']['index']]->name_corp; ?>
</td>
	<td>
	- <a href="#" class="enlaceMenu">Seleccionar</a> -<br>
	</td>           

<?php endfor; endif; ?>

</table>			</td>

<br>
<br>
<table  width="100%" cellpadding="0" cellspacing="0"  bgcolor="#F0FFFF"><font color="#000000">
	<td  align="middle" valign="middle"><img src="pics/copiarPegar.png"></td>
</table>
	


	
			