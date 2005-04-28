<?php
global $INSTALL_DIR;

require_once($INSTALL_DIR.'inc/includes.php');

function initialize_object($module)
{
	switch($module){
		case 'users':
					$objeto=new users();		
					break;
		case 'user_groups':
					$objeto=new user_groups();		
					break;
		case 'clients':
					$objeto=new clients();		
					break;
		case 'groups':
					$objeto=new groups();
					break;
		case 'modules':
					$objeto=new modules();
					break;
		case 'corps':
					$objeto=new corps();
					break;					
		case 'emps':
					$objeto=new emps();
					break;
		case 'cat_emps':
					$objeto=new cat_emps();
					break;
		case 'holydays':
					$objeto=new holydays();
					break;
		case 'methods':
					$objeto=new methods();
					break;
		case 'news':
					$objeto=new news();
					break;
		case 'contacts':
					$objeto=new contacts();
					break;
		case 'products':
					$objeto=new products();
					break;
		case 'services':
					$objeto=new services();
					break;
		case 'cat_servs':
					$objeto=new cat_servs();
					break;
		case 'error':
					$objeto=new error();
					break;
		case 'expire':
					$objeto=new expire();
					break;
		case 'cat_prods':
					$objeto=new cat_prods();
					break;
		case 'vehicles':
					$objeto=new vehicles();
					break;	
		case 'cat_vehicles':
					$objeto=new cat_vehicles();
					break;	
		case 'drivers':
					$objeto=new drivers();
					break;		
		case 'laborers':
					$objeto=new laborers();
					break;
		case 'vendors':
					$objeto=new vendors();
					break;	
		case 'sessions':
					$objeto=new sessions();
					break;
		case 'cat_clients':
					$objeto=new cat_clients();
					break;
		default:		
					if(!isset($_SESSION['user']))
					{
						$objeto = null;
					}
					else
					{
						$objeto=new user_corps();	
					} 
					break;
	}
	
	return $objeto;
}


?>