

{literal}
<script language="javascript">
	function botones(obj,cadena){		
	   var botones = document.getElementsByName('boton');
   		for (i=0; i < botones.length; i++) 
      		botones[i].src = 'pics/pestagna-' + botones[i].id + '.gif';
		obj.src = 'pics/pestagna-' + obj.id + 'sobre.gif';
	}
	function Ocultar(obj,cad){
		if (obj!=''){
			 botones(obj, cad);
			}
		 miDivMostrar = document.getElementById('divMostrar');
		 switch (cad){
		 {/literal}
		 	{foreach from=$variables item=variable}
			 case '{$variable}':
			 			miDivMostrar.innerHTML = {$variable};
						break;
			{/foreach}					
			{literal}
		 }		
	}
</script>
{/literal}