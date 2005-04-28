<?php
require_once ('includes.php');
class template extends Smarty{
	
	var $dir_smarty;
	var $dir_templates;
	var $dir_templates_c;
	var $dir_configs;
	var $dir_cache;
	function template(){

		global 	$INSTALL_DIR,$SMARTY_DIR, $ADODB_DIR;
		$this->template_dir = $INSTALL_DIR.'templates/';
		$this->compile_dir = $INSTALL_DIR.'templates_c/';
		$this->config_dir = $INSTALL_DIR.'configs/';
		$this->cache_dir = $INSTALL_DIR.'cache/';

		
	}
	
}
?>