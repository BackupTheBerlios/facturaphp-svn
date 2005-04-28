<?php
	require_once('cliente.php');
	$objeto= new clientes;
	if(isset($_POST[$objeto->ddbb_id]))
		{
			$objeto->asignadatos($_POST[$objeto->ddbb_id],$_POST[$objeto->ddbb_name],$_POST[$objeto->ddbb_tipo]);
			$objeto->aniadir();
			$objeto->coger_lista();
			$objeto->display_list_smarty();
		}
else
		{
			require_once('/var/www/proyectos/transporte/inc/smarty/Smarty.class.php') ; 
			$tpl = new Smarty;
			$tpl->template_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates/' ; 
			$tpl->compile_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates_c/' ;
			$tpl->config_dir =  '/var/www/proyectos/Pruebas/ejercicios/configs/' ;
			$tpl->cache_dir =  '/var/www/proyectos/Pruebas/ejercicios/cache/' ;  
			$tpl->assign('objeto',$objeto);
			$tpl->display('formulario.tpl');
		}
		$objeto->destroy();
?>
