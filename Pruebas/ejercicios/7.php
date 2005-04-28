<?php

require_once('/var/www/proyectos/transporte/inc/smarty/Smarty.class.php') ; 
$tpl = new Smarty;
$x1=1;
$x2=2;
$tpl->template_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates/' ; 
$tpl->compile_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates_c/' ;
$tpl->config_dir =  '/var/www/proyectos/Pruebas/ejercicios/configs/' ;
$tpl->cache_dir =  '/var/www/proyectos/Pruebas/ejercicios/cache/' ;   
$tpl->assign("Nombre",'Edu');
$tpl->assign("res1",$x1);
$tpl->assign("res2",$x2);
$tpl->display('funcion.tpl');
?>