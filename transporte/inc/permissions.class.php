<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');


require_once ($ADODB_DIR."adodb.inc.php");

class permissions{
//internal vars
	var $method_name;
	var $id_method;
	var $per;
	var $permissions_module;
	var $per_group_methods;
	var $per_group_modules;
	var $per_user_methods;
	var $per_user_modules;
	var $per_mod_del;
	var $add;
//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $result;  	
	var $ddbb_id_group = 'id_group';
	var $ddbb_id_user = 'id_user';
	var $ddbb_id_method = 'id_method';
	var $ddbb_id_module = 'id_module';
	var $ddbb_per = 'per';
	
	//constructor
	function permissions()
	{
		$this->inicializar_base_datos();
		return $this;
	}
	
	function add_permissions($name, $id, $valor)
	{
		$this->method_name = $name;
		$this->id_method = $id;
		$this->per = $valor;
	}
	
	function add_module ($module_n, $id_mo)
	{
		$this->module_name = $module_n;
		$this->id_module = $id_mo;
	}
	
	function add_method ($method_n, $id_me)
	{
		$this->method_name = $method_n;
		$this->id_method = $id_me;
	}
	
	function add_per ($valor_per)
	{
		$this->per = $valor_per;
	}
	
	function get_permissions_list($module)
	{
		
		if($_SESSION['super'] || $_SESSION['admin'])
		{
			$this->permissions_module = array('view', 'modify', 'delete');
			$this->add = true;
			return 3;
		}
		else
		{
			$user = new users();
			$id_user = $_SESSION['ident_user'];
			$user->validate_per_user($id_user);
		
			$this->permissions_module = array();
		
			for($i = 0; $i < $user->num_modules; $i++)
			{
				//Si coincide el modulo a buscar con el que estamos estudiando
				if($user->per_modules[$i]->module_name == $module)
				{
					$j = 0;
					for($k = 0; $k < $user->per_modules[$i]->num_methods; $k++)
					{
						//Si tiene permiso sobre el metodo se añade al array
						if($user->per_modules[$i]->per_methods[$k]->per == 1)
						{
							$this->per_add = false; 
						
							if(($user->per_modules[$i]->per_methods[$k]->method_name == 'view') || ($user->per_modules[$i]->per_methods[$k]->method_name == 'modify') || ($user->per_modules[$i]->per_methods[$k]->method_name == 'delete'))
							{
								$this->permissions_module[$j] = $user->per_modules[$i]->per_methods[$k]->method_name;
								$j++;
							}
						
							if($user->per_modules[$i]->per_methods[$k]->method_name == 'add')
							{
								$this->add = true;
							}
						}
					}
					
					return $j-1;	
				}
			}
		
		}
	
	}
	
	function get_permissions_modify_delete($module)
	{
		if(!$_SESSION['super'] && !$_SESSION['admin'])
		{
			$user= new users(); 
			$id_user = $user->get_id($_SESSION['user']);
			$user->validate_per_user_module($id_user, $module);
			
			
			$k=0;
			for($i=0; $i<$user->permission->num_methods;$i++)
			{
				if($user->permission->per_methods[$i]->method_name == 'modify')
				{
					if($user->permission->per_methods[$i]->per == 1)
					{
						$this->per_mod_del[$k] = 'modify';
						$k++;
					}
				}
				else
				if($user->permission->per_methods[$i]->method_name == 'delete')
				{
					if($user->permission->per_methods[$i]->per == 1)
					{
						$this->per_mod_del[$k] = 'delete';
						$k++;
					}
				}
			}
		}
		else
		{
			$this->per_mod_del[0] = 'modify';
			$this->per_mod_del[1] = 'delete';
		}

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
	
	function get_per_group_methods()
	{
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		
		//mete la consulta
		$this->sql='SELECT * FROM `per_group_methods`';
		
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();
					
			return false;
		} 

		while (!$this->result->EOF) {
			
			//cogemos los datos 
			$this->per_group_methods[$this->result->fields[$this->ddbb_id_group]][$this->result->fields[$this->ddbb_id_method]]=$this->result->fields[$this->ddbb_per];
			
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();

		}
		$this->db->close();
		
		return $this->per_group_methods;
	}
	
	function get_per_group_modules()
	{
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		
		//mete la consulta
		$this->sql='SELECT * FROM `per_group_modules`';
		
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();
					
			return false;
		} 

		while (!$this->result->EOF) {
			
			//cogemos los datos 
			$this->per_group_modules[$this->result->fields[$this->ddbb_id_group]][$this->result->fields[$this->ddbb_id_module]]=$this->result->fields[$this->ddbb_per];
			
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();

		}
		$this->db->close();
		
		return $this->per_group_modules;
	}
	
	function get_per_user_modules()
	{
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		
		//mete la consulta
		$this->sql='SELECT * FROM `per_user_modules`';
		
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();
					
			return false;
		} 

		while (!$this->result->EOF) {
			
			//cogemos los datos 
			$this->per_user_modules[$this->result->fields[$this->ddbb_id_user]][$this->result->fields[$this->ddbb_id_module]]=$this->result->fields[$this->ddbb_per];
			
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();

		}
		$this->db->close();
		
		return $this->per_user_modules;
	}
	
	function get_per_user_methods()
	{
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		
		//mete la consulta
		$this->sql='SELECT * FROM `per_user_methods`';
		
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();
					
			return false;
		} 

		while (!$this->result->EOF) {
			
			//cogemos los datos 
			$this->per_user_methods[$this->result->fields[$this->ddbb_id_user]][$this->result->fields[$this->ddbb_id_method]]=$this->result->fields[$this->ddbb_per];
			
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();

		}
		$this->db->close();
		
		return $this->per_user_methods;
	}
}
?>