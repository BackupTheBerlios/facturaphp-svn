<?php
	require_once('cliente.php');
	$objeto=new clientes;
	if(isset($_GET['id_clien']))
	{
			$objeto->id_cliente=$_GET['id_clien'];
			$objeto->coger_cliente();
			$objeto->display_list_smarty();
	}
		$objeto->destroy();
?>
