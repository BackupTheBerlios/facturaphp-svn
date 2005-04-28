<?php
	require_once('cliente.php');
	$objeto= new clientes;
	if(isset($_GET['id_clien']))
		{
			$objeto->id_cliente=$_GET['id_clien'];
			$objeto->coger_cliente();
			$objeto->modificar=true;
			$objeto->display_list_smarty();
			$objeto->modificar=false;
//			print_r ($objeto->id_cliente);
			/*require_once('/var/www/proyectos/transporte/inc/smarty/Smarty.class.php') ; 
			$tpl = new Smarty;
			$tpl->template_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates/' ; 
			$tpl->compile_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates_c/' ;
			$tpl->config_dir =  '/var/www/proyectos/Pruebas/ejercicios/configs/' ;
			$tpl->cache_dir =  '/var/www/proyectos/Pruebas/ejercicios/cache/' ;  
			$tpl->assign('objeto',$objeto);
			$tpl->display('modificar_cliente.tpl');			*/
		}
	if(isset($_POST[$objeto->ddbb_id]))
	{
		/*print_r($_POST[$objeto->ddbb_id]);
		print_r($_POST[$objeto->ddbb_name]);
		print_r($_POST[$objeto->ddbb_tipo]);*/
			$objeto->asignadatos($_POST[$objeto->ddbb_id],$_POST[$objeto->ddbb_name],$_POST[$objeto->ddbb_tipo]);
/*		print_r($objeto->id_cliente);
		print_r($objeto->name_cliente);
		print_r($objeto->tipo_cliente);*/
			$objeto->modificar_cliente();
			$objeto->coger_lista();
			$objeto->display_list_smarty();
	}
		$objeto->destroy();
?>
