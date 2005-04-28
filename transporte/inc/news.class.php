<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");
class news{


  	//constructor
	function news()
	{
	}
	
	
	function calculate_tpl($method, $tpl)
	{

		$tpl->assign('plantilla','noticias.tpl');					
		
		return $tpl;
	}

	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}		
		if ($corp != ""){
			$corp='<a href="index.php?module=corps&method=view&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = 'Zona Pública :: '.$corp.' <a href="index.php?module=news">Noticias</a>';

		return $nav_bar;
	}		

	function title($method,$corp)
	{
		if ($corp != "")
		{
			$corp=$corp." ::";
		}
		$title = "Zona Pública :: Noticias";
		return $title;
	}		
	
}
?>