<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');


require_once ($ADODB_DIR."adodb.inc.php");

class permissions_methods{
//internal vars
	var $method_name;
	var $method_name_web;
	var $id_method;
	var $name_web;
	var $per;
//
	var $per_methods;
	
//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $result;  	


	//constructor
	function permissions_methods()
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
	
	function add_id ($id)
	{
		$this->id_method = $id;
	}
	
	function add_name ($method_n)
	{
		$this->method_name = $method_n;
	}
	
	function add_per ($valor_per)
	{
		$this->per = $valor_per;
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
	
	
	function validate_per_user_method ($id_user, $method)
	{	
			
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		
		//mete la consulta
		$this->sql='SELECT `per`FROM `per_user_methods` WHERE `id_method`='.$method.' AND `id_user`='.$id_user;
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
	
	function validate_per_group_method ($id_group, $method)
	{		
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		
		//mete la consulta
		$this->sql='SELECT `per`FROM `per_group_methods` WHERE `id_method`='.$method.' AND `id_group`='.$id_group;
		
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
	
	
	function validate_per_method($id_user, $id_method, $groups_list)
	{
		//print "USUARIO -> ".$id_user.".....";
		//$this->inicializar_base_datos();
		
		//$users_list = new users();
	
		//Se toma la lista de grupos a los que pertenece el usuario
	//	$num_groups = $users_list->get_groups($id_user); 

		$num = 0;		
		$per = false;
	
		//$result = $this->validate_per_user_method($id_user,$id_method);
		$result = $_SESSION['permisos_user_methods'][$id_user][$id_method];
		
		if($result == true)
		{
			$this->add_per(1);
			//print "USUARIO-T: metodo ".$this->method_name." permisos ".$this->per."............";
		}
		else
		{

			$num = 0;
			
			//comprobar si en alguno de los grupos se tiene permiso
			while((!$per) && ($num < $num_groups))
			{
				$id_grupo = $users_list->groups_list[$num]['id_group'];
				
			//	$result = $this->validate_per_group_method($id_grupo, $id_method);
				$result = $_SESSION['permisos_group_methods'][$id_grupo][$id_method];
			
				if($result == true)//$this->validate_per_group_method($this->groups_list[$this->num]['id_group'], $id_method)==true)
				{
					$per=true;
				}
				$num++;
			}
			
			if(!$per)
			{
				$this->add_per(0);
				//print "GRUPO-F: metodo ".$this->method_name." permisos ".$this->per."............";
				
			}
			else
			{	
				$this->add_per(1);
				//print "GRUPO-T: metodo ".$this->method_name." permisos ".$this->per."............";
			}			
		}
	}
		
	function validate_per_method_without_groups($id_user, $id_method)
	{
		//print "USUARIO -> ".$id_user.".....";
		//$this->inicializar_base_datos();
	
		//$users_list = new users();
			
		$num = 0;		
		$per = false;
	
		//$result = $this->validate_per_user_method($id_user,$id_method);
		$result = $_SESSION['permisos_user_methods'][$id_user][$id_method];
		
		if($result == true)
		{
			$this->add_per(1);
			//print "USUARIO-T: metodo ".$this->method_name." permisos ".$this->per."............";
		}
		else
		{
			$this->add_per(0);
			$num = 0;
		}
			
	}
	
	//Esta función hace lo mismo que validate_per_method pero para grupos
	
	function validate_per_method_for_group($id_group, $id_method)
	{
		//print "USUARIO -> ".$id_user.".....";
		//$this->inicializar_base_datos();
	
				//$result = $this->validate_per_group_method($id_group, $id_method);
				$result = $_SESSION['permisos_group_methods'][$id_grupo][$id_method];
			
				if($result == true)//$this->validate_per_group_method($this->groups_list[$this->num]['id_group'], $id_method)==true)
				{
					$per=true;
				}
			
			if(!$per)
			{
				$this->add_per(0);
				//print "GRUPO-F: metodo ".$this->method_name." permisos ".$this->per."............";
				
			}
			else
			{	
				$this->add_per(1);
				//print "GRUPO-T: metodo ".$this->method_name." permisos ".$this->per."............";
			}			
	}
}


?>