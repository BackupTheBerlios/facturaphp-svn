<?php

class plantilla{
	
	var $tpl;
	var $x1;
	var $x2;
	
	function plantilla()
	{
		require_once('/var/www/proyectos/transporte/inc/smarty/Smarty.class.php') ; 
		$this->tpl=new Smarty;
		$this->tpl->template_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates/' ; 
		$this->tpl->compile_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates_c/' ;
		$this->tpl->config_dir =  '/var/www/proyectos/Pruebas/ejercicios/configs/' ;
		$this->tpl->cache_dir =  '/var/www/proyectos/Pruebas/ejercicios/cache/' ;  
		return 1;
	}
	function set_x1($val1)
	{
				$this->x1=$val1;
				$this->tpl->assign("res1",$this->x1);
	}
	function set_x2($val2)
	{
				$this->x2=$val2;
				$this->tpl->assign("res2",$this->x2);
	}
	function display()
	{
		$this->tpl->assign("Nombre",'Edu');
		$this->tpl->display('funcion.tpl');
	}
}
?>
