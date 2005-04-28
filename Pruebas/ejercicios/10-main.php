<?php
	require_once('10.php');
	$objeto= new cliente;
	//$objeto->borrar();
	//$objeto->aniadir();
	//$objeto->modificar();
	$objeto->coger_listado();
	$objeto->display_list();
	/*$objeto->aniadir();
	$objeto->coger_listado();
	$objeto->display_list();
	$objeto->read(3);
	$objeto->modificar(3);
	$objeto->coger_listado();
	$objeto->display_list();
	$objeto->borrar(3);
	$objeto->coger_listado();
	$objeto->display_list();
	$objeto->read(2);
	$objeto->display_client();*/
	$objeto->destroy();
	
?>
