<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($INSTALL_DIR.'inc/permissions_methods.class.php');

require_once ($ADODB_DIR."adodb.inc.php");

class permissions_modules{

//internal vars	
	var $num_methods; //Numero de metodos que contiene el modulo
	var $methods;	//Lista de metodos del modulo en cuesti�n
	var $id_module;   //Id del modulo
	var $module_name; //Nombre del modulo
	var $web_name;
	var $per;
	var $publico;
	var $parent;
	var $active;
	//var $list_methods; No hace falta porque la lista de metodos por m�dulo la encontraremos con el numero de metodos listando los nombres que aparecen en cada campo de per_module_methods
	
//
	var $per_modules;
	var $per_methods; //lista de permisos en metodos del modulo (objeto de clase permissions_methods)
	
//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $db;
	var $sql;
	var $result;  	 	
  	
	//constructor
	function permissions_modules()
	{
		$this->inicializar_base_datos();
		return $this;
	}
	
	function inicializar_base_datos(){
		//coge las variables globales del fichero config.inc.php
		global $DDBB_TYPE, $DDBB_NAME, $IP_DDBB, $DDBB_USER, $DDBB_PASS, $DDBB_PORT, $TABLE_PREFIX;
		$this->db_type=$DDBB_TYPE;
		$this->db_name=$DDBB_NAME;
		$this->db_ip=$IP_DDBB;
		$this->db_user=$DDBB_USER;
		$this->db_passwd=$DDBB_PASS;
		$this->db_port=$DDBB_PORT;
		$this->table_prefix=$TABLE_PREFIX;
		
	}
	
	
	
	function validate_per_group_module ($id_group, $id_module)
	{		
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
	
		//mete la consulta
		$this->sql='SELECT `per`FROM `per_group_modules` WHERE `id_module`='.$id_module.' AND `id_group`='.$id_group;
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();
			
			return false;
		}  
		
		$this->db->close();
		return $this->result->fields['per'];
		
	}
	

	function validate_per_user_module ($id_user, $module)
	{	

		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		
		//mete la consulta
		$this->sql='SELECT `per`FROM `per_user_modules` WHERE `id_module`='.$module.' AND `id_user`='.$id_user;
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();
			
			return false;
		}  
		
		$this->db->close();
		return $this->result->fields['per'];
		
	}
	
	function validate_per ($user, $module, $method_name)
	{

		//$this->inicializar_base_datos();
		//print "Pasados usuario: ".$user.", modulo: ".$module.", metodo: ".$method_name;
		
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);

		$this->sql='SELECT `id_user` FROM `users` WHERE `login`='."\"".$user."\"";

		$this->result = $this->db->Execute($this->sql);
		
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();

			return false;
		} 	
	
		$id_user=$this->result->fields['id_user'];

		
		$this->sql='SELECT `id_module` FROM `modules` WHERE `name`='."\"".$module."\"";
		$this->result = $this->db->Execute($this->sql);
		
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();

			return false;
		} 
		
		$id_module=$this->result->fields['id_module'];
	
		//Si el metodo no es una cadena vac�a se busca su id
		if($method_name != "")
		{

			$this->sql='SELECT `id_method` FROM `methods` WHERE `name`='."\"".$method_name."\"".' AND `id_module`= '.$id_module;
			$this->result = $this->db->Execute($this->sql);
		
			if ($this->result === false)
			{
				$this->error=1;
				$this->db->close();

				return false;
			} 
		
			$id_method=$this->result->fields['id_method'];

		}
		$this->db->close();
		$users = new users();
	
		//Se toma la lista de grupos a los que pertenece el usuario
		$num_groups = $users->get_groups($id_user); 
		
		
		//Se comprueba si el usuario tiene permisos en el m�dulo
		//$per = $this->validate_per_user_module($id_user, $id_module);
		$per = $_SESSION['permisos_user_modules'][$id_user][$id_module];

		
		if($per == true)//Si ya hay permiso no hace falta seguir
		{
			//Se busca si tambi�n tiene permisos en el metodo indicado
			if($method_name == "")//Si no se pas� ning�n metodo se devuelve el permiso en el modulo
			{
				//print "Usuario con permisos de usuario y no se ha indicado metodo";
				return 1;
			}
			//Si hay metodo se busca el permiso del usuario en �l
			$method = new permissions_methods();
			//$per = $method->validate_per_user_method($id_user, $id_method);
			$per = $_SESSION['permisos_user_methods'][$id_user][$id_method];
			
			if($per == true)
			{
				//print "Usuario con permisos de usuario y permiso en metodo por usuario";
				return 1;
			}
			
			//Se comprueba si en sus grupos tiene permiso
			$num = 0;
			
			while(($per == false) && ($num < $num_groups))
			{
				//$per = $method->validate_per_group_method ($users->groups_list[$num]['id_group'], $id_method);
				$result = $_SESSION['permisos_group_methods'][$users->groups_list[$num]['id_group']][$id_method];
				
				if($per == true)
				{
					//print "Usuario con permisos de usuario y en metodo de grupo";
					return 1;
				}
				
				$num++;
			}
			//print "Usuario con permisos de usuario y NO permiso en metodo";
			return 0;
		}
		else //Se comprueba que alguno de los grupos al que pertenece tenga permiso
		{	
			
			$num = 0;
			
			while(($per == false) && ($num < $num_groups))
			{

			//	$per = $this->validate_per_group_module ($users->groups_list[$num]['id_group'], $id_module);
				$per = $_SESSION['permisos_group_modules'][$users->groups_list[$num]['id_group']][$id_module];
			
				if($per == true)
				{
				
					//return 1;
					//Se busca si tambi�n tiene permisos en el metodo indicado
					if($method_name == "")//Si no se pas� ning�n metodo se devuelve el permiso en el modulo
					{
						//print "Usuario con permisos de grupo y no se ha indicado metodo";
						return 1;
					}
					//Si hay metodo se busca el permiso del usuario en �l
					$method = new permissions_methods();
				//	$per = $method->validate_per_user_method($id_user, $id_method);
					$per = $_SESSION['permisos_user_methods'][$id_user][$id_method];
					
					if($per == true)
					{
						//print "Usuario con permisos de grupo y permiso en metodo";
						return 1;
					}
					
					//Se comprueba si en sus grupos tiene permiso
					$num = 0;
					
					while(($per == false) && ($num < $num_groups))
					{
		
						//$per = $method->validate_per_group_method ($users->groups_list[$num]['id_group'], $id_method);
						$result = $_SESSION['permisos_group_methods'][$users->groups_list[$num]['id_group']][$id_method];
						
						if($per == true)
						{
							//print "Usuario con permisos de grupo y en metodo de grupo";
							return 1;
						}
						
						$num++;
					}
					
					//print "Usuario con permisos de grupo y NO permiso en metodo";
					return 0;
				}
			
				$num++;
			}
			
		}
		//print "NO hay permisos";
		return 0;
		
		
	}


	//Funci�n que indicar� para qu� tiene permisos un usuario (ya sea por los grupos a los que pertenece o por �l m�smo)
	//Para ello se har� un listado de modulos_metodos_permiso en cada metodo de cada modulo
	//Se usar� una lista de permissions que contendr� por cada id_modulo (indice de la lista) el metodo (nombre e id de este) y permiso
	//El nombre del modulo se puede obtener gracias al id_modulo desde la lista de modulos (modules->modules_list[$module_num]['name'])
	//
	function validate_per_module($id_user)
	{
	
		//$this->inicializar_base_datos();
	
		$user = new users();
	
		//Se toma la lista de grupos a los que pertenece el usuario
		$num_groups = $user->get_groups($id_user); 
			
		$per = false;
		$this->per = 0;
		$num = 0;

		
		//Se comprueba si el usuario tiene permisos en el m�dulo
		//$result = $this->validate_per_user_module($id_user, $this->id_module);
		$result = $_SESSION['permisos_user_modules'][$id_user][$this->id_module];
		
		if($result == true)
		{
			$per = true;
			$this->per = 1;
			//print "USER";
		}
		else //Se comprueba que alguno de los grupos al que pertenece tenga permiso
		{	
			while((!$per) && ($num < $num_groups))
			{
			//	$result = $this->validate_per_group_module ($user->groups_list[$num]['id_group'], $this->id_module);
				$result = $_SESSION['permisos_group_modules'][$users->groups_list[$num]['id_group']][$this->id_module];
				if($result == true)
				{
					$per=true;
					$this->per = 1;
				}
				
				$num++;
			}
		}
		
		$modules = new modules();
		$this->num_methods = $modules->get_list_module_methods($this->id_module);

		for ($metodo_num = 0; $metodo_num < $this->num_methods; $metodo_num++) 
		{
			//Como se tiene el numero de metodos de este modulo, entonces se puede ver nombre e identificador en $this->per_methods[$metodo_num]->name
			//As� ser� mas f�cil recorrer la matriz, y no hay problemas de pasar un hash a smarty ya que no los acepta

			$this->per_methods[$metodo_num] = new permissions_methods();
			$this->per_methods[$metodo_num]->id_method = $modules->module_methods[$metodo_num]['id_method'];
			$this->per_methods[$metodo_num]->method_name = $modules->module_methods[$metodo_num]['name'];				
			$this->per_methods[$metodo_num]->method_name_web = $modules->module_methods[$metodo_num]['name_web'];
			if($per == true)
			{
				$this->per_methods[$metodo_num]->validate_per_method($id_user, $this->per_methods[$metodo_num]->id_method, $user->groups_list);
			}
			else
			{
				$this->per_methods[$metodo_num]->per = 0;
				//print "NO MOdulo: metodo ".$this->method_name." permisos ".$this->per."............";
			}
		}
		
	}
	
	function validate_per_module_without_groups($id_user)
	{
		//$this->inicializar_base_datos();
	
		$user = new users();

		/*
		//Se toma la lista de grupos a los que pertenece el usuario
		$num_groups = $user->get_groups($id_user); 
		*/
		
		$per = false;
		$this->per = 0;
		$num = 0;
	
		
		//Se comprueba si el usuario tiene permisos en el m�dulo
			
		//$result = $this->validate_per_user_module($id_user, $this->id_module);
		$result = $_SESSION['permisos_user_modules'][$id_user][$this->id_module];

		if($result == true)
		{
			$per = true;
			$this->per = 1;
			//print "USER";
		}
		
		
		$modules = new modules();
	
		$this->num_methods = $modules->get_list_module_methods($this->id_module);

		for ($metodo_num = 0; $metodo_num < $this->num_methods; $metodo_num++) 
		{
			//Como se tiene el numero de metodos de este modulo, entonces se puede ver nombre e identificador en $this->per_methods[$metodo_num]->name
			//As� ser� mas f�cil recorrer la matriz, y no hay problemas de pasar un hash a smarty ya que no los acepta

			$this->per_methods[$metodo_num] = new permissions_methods();
			$this->per_methods[$metodo_num]->id_method = $modules->module_methods[$metodo_num]['id_method'];
			$this->per_methods[$metodo_num]->method_name = $modules->module_methods[$metodo_num]['name'];				
			$this->per_methods[$metodo_num]->method_name_web = $modules->module_methods[$metodo_num]['name_web'];
			if($per == true)
			{	
				$this->per_methods[$metodo_num]->validate_per_method_without_groups($id_user, $this->per_methods[$metodo_num]->id_method);
			}
			else
			{
				$this->per_methods[$metodo_num]->per = 0;
				//print "NO MOdulo: metodo ".$this->method_name." permisos ".$this->per."............";
			}
		}		
	}

	//Esta funcion hace lo mismo que validate_per_module pero su funci�n es para grupos.
	
	function validate_per_module_for_group($id_group)
	{
	
		$this->inicializar_base_datos();
	
		$per = false;
		$this->per = 0;
		$num = 0;
	
	//	$result = $this->validate_per_group_module ($id_group, $this->id_module);
		$result = $_SESSION['permisos_group_modules'][$id_group][$this->id_module];
		if($result == true){
			$per=true;
			$this->per = 1;
		}
	
		
		$modules = new modules();	
		$this->num_methods = $modules->get_list_module_methods($this->id_module);



		for ($metodo_num = 0; $metodo_num < $this->num_methods; $metodo_num++) 
		{
			//Como se tiene el numero de metodos de este modulo, entonces se puede ver nombre e identificador en $this->per_methods[$metodo_num]->name
			//As� ser� mas f�cil recorrer la matriz, y no hay problemas de pasar un hash a smarty ya que no los acepta

			$this->per_methods[$metodo_num] = new permissions_methods();
			$this->per_methods[$metodo_num]->id_method = $modules->module_methods[$metodo_num]['id_method'];
			$this->per_methods[$metodo_num]->method_name = $modules->module_methods[$metodo_num]['name'];				
			$this->per_methods[$metodo_num]->method_name_web = $modules->module_methods[$metodo_num]['name_web'];
			if($per == true)
			{	
				$this->per_methods[$metodo_num]->validate_per_method_for_group($id_group, $this->per_methods[$metodo_num]->id_method);
			}
			else
			{
				$this->per_methods[$metodo_num]->per = 0;
				//print "NO MOdulo: metodo ".$this->method_name." permisos ".$this->per."............";
			}
		}
		
	}
	
	function validate_per_module_menus($id_user, $id_module)
	{

		$this->inicializar_base_datos();
	
		$user = new users();
	
		//Se toma la lista de grupos a los que pertenece el usuario
		$num_groups = $user->get_groups($id_user); 
			
		$per = false;
		$this->per = 0;
		$num = 0;
	
		
		//Se comprueba si el usuario tiene permisos en el m�dulo
		//$result = $this->validate_per_user_module($id_user, $id_module);
		$result = $_SESSION['permisos_user_modules'][$id_user][$id_module];
	
		if($result == true)
		{
			$per = true;
			$this->per = 1;
			//print "USER";
		}
		else //Se comprueba que alguno de los grupos al que pertenece tenga permiso
		{	
			while((!$per) && ($num < $num_groups))
			{
				$result = $_SESSION['permisos_group_modules'][$user->groups_list[$num]['id_group']][$id_module];
				
				if($result == true)
				{
					$per=true;
					$this->per = 1;
				}
				
				$num++;
			}
		}
		return $this->per;
	}

	function validate_per_type_user($name)
	{
		if($_SESSION['client']==1)
		{
			//Comprobar si tipo coincide con el módulo
		}
		else
		{ 
			//Comprobar tipo con módulo
		}
	}
	
}
?>