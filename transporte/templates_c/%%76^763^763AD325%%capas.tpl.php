<?php /* Smarty version 2.6.3, created on 2005-04-21 12:47:03
         compiled from capas.tpl */ ?>


<?php echo '
<script language="javascript">
	function botones(obj,cadena){		
	   var botones = document.getElementsByName(\'boton\');
   		for (i=0; i < botones.length; i++) 
      		botones[i].src = \'pics/pestagna-\' + botones[i].id + \'.gif\';
		obj.src = \'pics/pestagna-\' + obj.id + \'sobre.gif\';
	}
	function Ocultar(obj,cad){
		if (obj!=\'\'){
			 botones(obj, cad);
			}
		 miDivMostrar = document.getElementById(\'divMostrar\');
		 switch (cad){
		 '; ?>

		 	<?php if (count($_from = (array)$this->_tpl_vars['variables'])):
    foreach ($_from as $this->_tpl_vars['variable']):
?>
			 case '<?php echo $this->_tpl_vars['variable']; ?>
':
			 			miDivMostrar.innerHTML = <?php echo $this->_tpl_vars['variable']; ?>
;
						break;
			<?php endforeach; unset($_from); endif; ?>					
			<?php echo '
		 }		
	}
</script>
'; ?>