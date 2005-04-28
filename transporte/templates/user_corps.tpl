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
{php}
	$linea = 0;
{/php}
{section name="i" loop=$user_corps}
	{if $linea==0}
	<tr class="multiLinea1">
		{php}
				$linea=1;
		{/php}
	{else}
	<tr class="multiLinea2">
		{php}
				$linea=0;
		{/php}
	{/if}
	
	<td width="25%"  nowrap class="camposVistas">{$user_corps[i]->name_corp}</td>
	<td>
	- <a href="#" class="enlaceMenu">Seleccionar</a> -<br>
	</td>           

{/section}

</table>			</td>

<br>
<br>
<table  width="100%" cellpadding="0" cellspacing="0"  bgcolor="#F0FFFF"><font color="#000000">
	<td  align="middle" valign="middle"><img src="pics/copiarPegar.png"></td>
</table>
	


	
			