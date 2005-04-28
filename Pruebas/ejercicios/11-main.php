<?php
	require_once('11.php');
	$objeto=new clientesmarty;
	$objeto->coger_lista();
	//$objeto->display_list();
	$objeto->display_list_smarty();
	$objeto->destroy();
?>