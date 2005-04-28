<?php
//Comprueba si existe la bbdd
//si no existe la bbdd va a la instalaci�n
//aqui debe de irse a la instalaci�n de la aplicaci�n
//si existe la bbdd ya puede conectarse con lo que sea

//inicia o retoma una sesion
session_start();

//realiza todos los includes necesarios
//Si estamos en windows comentar el config que tenga / si no comentar el config \\
//require_once('inc\\config.inc.php');
require_once('inc/config.inc.php');
global $INSTALL_DIR;
require_once('inc/index.inc.php');

//En inc/photos.php realizan las operaciones necesarias por cada modulo para el trabajo con las fotos
require_once($INSTALL_DIR.'inc/photos.php');
require_once($INSTALL_DIR.'inc/includes.php');
//inicializamos algunas variables
$title="::Gesti&oacute;n::";
$nav_bar="::Gesti&oacute;n::";

//inicializa una plantilla
$tpl= new template;
	

//Comprobar si la sesi�n debe caducar
if(isset($_SESSION['max_page_time'])&& time() >= $_SESSION['max_page_time'])
{
	//Desconectar al usuario porque caduc� su sesi�n
	$session=new sessions();
	$session->unregister();
	unset($_COOKIE[session_name()]);
	session_unset();
	session_destroy();
	session_start();
		
	//Se recalcula los m�dulos p�blicos para el men�
	$menu = new menu();
	$_SESSION['public_modules'] = $menu->table_modules(0);
		
	$tpl->assign('user_name','');
	$tpl->assign('corp_id',0);
	$tpl->assign('error',0);
	$tpl->assign('login',1);
	$index_template='index.tpl';
	$_SESSION['expire'] = 1;	
} 

//Comprobar si hay usuarios caducados
$session = new sessions();
$session->comprobar_conectados();


/******************************************* Identificaci�n de usuario ***************************************************/

//comprueba si existe el usuario en la sesion
if(!isset($_SESSION['user']))
{
	//comprobamos si estan mandando el formulario
	$post_user= new users(); 
	$menu = new menu();
	$_SESSION['public_modules'] = $menu->table_modules(0);

	
	if(isset($_POST['passwd'])&& isset($_POST['user'])&&$post_user->validate_user($_POST['user'],$_POST['passwd'])==1)
	{	
		//registra la variable de sesion user con el nombre de usuario
		$_SESSION['user']=$_POST['user'];
		
		//Se toma el identificador del usuario para ahorrar c�lculos
		$_SESSION['ident_user'] = $post_user->get_id($_SESSION['user']);
		
		//Comprobación de usuario normal o cliente
		if($post_user->is_client($_SESSION['ident_user'])==1)
			$_SESSION['client']=1;
		else
			$_SESSION['client']=0;
		
			
			
			
		$_SESSION['queries']= new log_methods();
		$_SESSION['queries']->id_user = $_SESSION['ident_user'];
		
		//Se busca registro de la sesi�n (ya se conoce al usuario)
		$session=new sessions();
		$_SESSION['ident_sesion'] = $session->register();

		
		//Comprueba si es admin o super
		$num_groups = $post_user->get_groups($_SESSION['ident_user']);
		$_SESSION['super'] = false;
		$_SESSION['admin'] = false;
		
		for($i = 0; $i < $num_groups; $i++)
		{	
			if($post_user->groups_list[$i]['id_group'] == 2)
			{
				$_SESSION['admin'] = true;

			}
			else
			if($post_user->groups_list[$i]['id_group'] == 1)
			{	

				$_SESSION['super'] = true;				
			}
		}
		
		
		//Inicia empresas a 0 (no se conoce empresa con la que se quiere trabajar)
		$_SESSION['ident_corp'] = 0;
		//Inicia el n� de registros a la hora de listar
		$_SESSION['num_regs']=10;
		
		//Se crea coockie
		if(!isset($_COOKIE[session_name()]))
       	{
           // Gives the user 30 seconds to type the password.
           // Should be enough :-)
           setcookie(session_name(), 1,time()+60);
       	}
		
		
	/*	//Tomamos IP del cliente
		if ($for = getenv('HTTP_X_FORWARDED_FOR'))
   		{
    		 $afor = explode(",", $for);
    		 print trim($afor[0]);
  		}
  		 else
   		{
			print "aqu� tamos";
     		print getenv('REMOTE_ADDR');
   		}
*/
		//Al iniciar sesi�n no ha podido expirar esta a�n
		$_SESSION['expire']=0;
		
		
		
		$permisos = new permissions();
		$_SESSION['permisos_group_methods'] = $permisos->get_per_group_methods();
		$_SESSION['permisos_group_modules'] = $permisos->get_per_group_modules();
		$_SESSION['permisos_user_modules'] = $permisos->get_per_user_modules();
		$_SESSION['permisos_user_methods'] = $permisos->get_per_user_methods();
		
		/*
		Para acceder a cualquier tabla se hace de la siguiente manera
		$_SESSION['nombre_tabla'][id_user/id_group][id_module/id_method]
		
		Comprobar en el caso de que no est� en la lista y escribir en su caso un 0
		if(!isset($_SESSION['permisos_group_methods'][9][21]))
			print "permisos 0";
		else
			print "permisos ".$_SESSION['permisos_group_methods'][9][21];
			
		Ahora siempre que se necesite buscar algo se puede acceder de esta manera o creando un bucle 
		que recorra los identificadores y compruebe si est� o no en la lista y su valor
		*/

		//Se crea el men� de usuario	
		$_SESSION['modules_list'] = $menu->table_modules(-2);
		
		//como el usuario esta validado asigna su nombre a la plantilla
		$tpl->assign('user_name',$_SESSION['user']);
		$tpl->assign('login',0);
		

	
		
		//inicializa la plantilla principal de empresas a las que pertenece el usuario
		//El usuario est� logeado y se le presenta la plantilla de las empresas con las que trabaja
		$index_template="index.tpl";	
		
		
	}
	else
	{
		//printf('usuario no validado');
		if(isset($_POST['user']))
		{
				//segundo intento
				$tpl->assign('user_name', $_POST['user']);
				$tpl->assign('error',1);
				$tpl->assign('login',1);
		}
		else
		{
			//primer intento
			$tpl->assign('user_name','');
			$tpl->assign('error',0);
			$tpl->assign('login',1);
		}
		$index_template='login.tpl';	
	
	}
	
}
else
{
	//usuario registrado en la sesion
	if(isset($_POST['submit'])&& $_POST['submit']=='Desconectar')
	{
		$session=new sessions();
		$session->unregister();
		unset($_COOKIE[session_name()]);
		session_unset();
		session_destroy();
		session_start();
		
		//Se recalcula los m�dulos p�blicos para el men�
		$menu = new menu();
		$_SESSION['public_modules'] = $menu->table_modules(0);
		
		$tpl->assign('user_name','');
		$tpl->assign('corp_id',0);
		$tpl->assign('error',0);
		$tpl->assign('login',1);
		$index_template='index.tpl';
		
	}
	else
	{
		$tpl->assign('user_name',$_SESSION['user']);
		$tpl->assign('login',0);
		$index_template='index.tpl';
	} 
}

/************************************ Se preparan menus ************************************************/

//coge el listado de modulos disponibles para el usuario
$tpl->assign('modules_list',$_SESSION['modules_list']);
$tpl->assign('public_modules',$_SESSION['public_modules']);

/********************************** Se identifica modulo ************************************************************/
//identifica el modulo 
if(isset($_GET['module']))
{
	$module=$_GET['module'];
}

//Operaciones con m�dulos
if(isset($_SESSION['user']) && isset($_GET['module']))
{
	$module_name=$_GET['module'];

	//Se comprueba si se pasa de nuevo a elegir empresa
	if((!isset($_GET['method'])&&($_GET['module'] =='user_corps')))
	{
		//registra la variable de sesion ident_corp con el identificador nulo para diferenciar en los men�s
		$_SESSION['ident_corp']=0;
	}
	
	//Se indica si se trabaja con una empresa, con cu�l se est� trabajando
	//Se comprueba si estan eligiendo empresa
	if(isset($_GET['method'])&&(($_GET['module']=='user_corps')&&($_GET['method']=='select')))
	{	
		//registra la variable de sesion user con el nombre de usuario
		$_SESSION['ident_corp']=$_GET['id'];	
	}	
}

/********************************* Comprobaci�n de permisos sobre m�dulo y m�todo **********************************************/
//Comprobar si no expir� la sesion
if($_SESSION['expire'] == 0)
{
	$modules=new modules();
	//2 opciones:
	//- El usuario no est� logeado pero el m�dulo es p�blico, en cuyo caso no habr�a problema
	//- El usuario est� logeado pero intenta entrar en un m�udlo donde no tiene permisos
	if(!isset($_SESSION['user']) && isset($_GET['module'])&&($_GET['module']!='user_corps'))
	{
		//Se comprueba si el modulo es p�blico, sino es as� se indica el error
		if($modules->is_public_module($_GET['module']) == 0)
			$module_name = 'error';
		else
			$module_name=$_GET['module'];
	}

	//Se comprueba que el usuario tenga permisos sobre el m�dulo que aparece en la barra de direccion
	if(isset($_SESSION['user']) && isset($_GET['module']))
	{
		if((!$_SESSION['super']) && (!$_SESSION['admin']))
		{
			//Se comprueba si el modulo es p�blico si es as� se deja no hay problema, pero sino se tendr� que saber si tiene o no acceso a �l
			if($modules->is_public_module($_GET['module']) == 0)
			{
				$permiso = new permissions_modules();
	
				//Se prepara para poder investigar los permisos en el modulo
				if (!isset($_GET['method']))
				{
					$method=null;
				}
				else
				{
					$method=$_GET['method'];
				}
		
				if(($_GET['module'] != 'user_corps') &&($method != 'select'))
				{
					if($permiso->validate_per($_SESSION['user'], $_GET['module'], $method) == 0)
					{
						$module_name = 'error';	
					}
				}
			}
		}	
		else
		if($_SESSION['admin'] && (!$_SESSION['super']) && ($_GET['module'] == 'modules' || $_GET['module'] == 'methods'))
		{
			$module_name = 'error';	
		}
	}
}
else
{
	//Expir� la sesi�n
	$module_name = 'expire';	
	$_SESSION['expire'] = 0;
}
		
/*************************** Preparaci�n de la plantilla a mostrar ***************************************************/

//inicializar el objeto que corresponda
//en el caso de que no haya modulo definido se deja la plantilla por defecto
//en el caso de que no se haya pasado metodo se presenta el listado con la
//busqueda del modulo
$objeto= initialize_object($module_name);
	

//coge las sesiones abiertas y los usuarios registrados
$users= new users();
$users->get_list_users();
$tpl->assign('num_users',$users->registrados);
$session= new sessions();
$num_sessions=$session->conectados();
$tpl->assign('num_sessions',$num_sessions);

//calcula la barra de navegaci�n y titulo de la pagina
if ($objeto===null)
{
	$nav_bar='Gesti&oacute;n';
	$title='Gesti&oacute;n';
	$plantilla='wellcome.tpl';
	$tpl->assign('plantilla',$plantilla);
}
else
{	
	///*************************************
	
	//En este orden
	if (!isset($_GET['method']))
	{
		$method=null;
	}
	else
	{
		$method=$_GET['method'];
	}
	$tpl=$objeto->calculate_tpl($method,$tpl);
	
	
	//Se obtiene el nombre de la empresa en la que se est� trabajando
	if($_SESSION['ident_corp']==0)
	{
		$corp = "";
	}
	else
	{
		$my_corp = new corps();
		$my_corp->read($_SESSION['ident_corp']);
		$corp = $my_corp->name;
	}	
	
	$nav_bar=$objeto->bar($method,$corp);
	$title=$objeto->title($method,$corp);
	
 
	//elige la plantilla a presentar
	
}

//pasa las variables de la presentaci�n a la plantilla dependiente del objeto
$tpl->assign('title',$title);
$tpl->assign('nav_bar',$nav_bar);
//Antes de ir a la plantilla se registra la hora m�xima a la que puede estar el usuario en esa p�gina
$_SESSION['max_page_time'] = time()+1200;

//Guardar en bbdd fecha de expiracion
$session=new sessions();
$session->expire = $_SESSION['max_page_time'];
$session->modify();

$tpl->display($index_template);
//print_r($post_user);
?>