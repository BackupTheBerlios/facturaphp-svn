<?php
	require_once('cliente.php');
	$objeto= new clientes;
	if(isset($_GET['id_clien']))
		{
			$objeto->borrar_cliente($_GET['id_clien']);
			$objeto->coger_lista();
			$objeto->display_list_smarty();
		}
		$objeto->destroy();
?>
