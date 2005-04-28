<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($INSTALL_DIR.'inc/permissions_modules.class.php');
require_once ($ADODB_DIR."adodb.inc.php");

class users{
//internal vars
	var $id_user;
	var $login;
	var $passwd;
	var $name;
	var $last_name;
	var $last_name2;
	var $full_name;
	var $internal;
	var $active;
	var $theme;
	var $registrados;
	var $retype;
	var $search;
	var $search_query;
	
//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $table_name='users';
	var $ddbb_id_user='id_user';
  	var $ddbb_login='login';
  	var $ddbb_passwd='passwd';
  	var $ddbb_name='name';
  	var $ddbb_last_name='last_name';
  	var $ddbb_last_name2='last_name2';
  	var $ddbb_full_name='full_name';
	var $ddbb_internal='internal';
	var $ddbb_active='active';
	var $ddbb_search='search';
	var $db;
	var $result;  	
//variables complementarias	
  	var $users_list;
  	var $num;
  	var $fields_list;
  	var $error;
	var $method;
//variables del listado de grupos al que pertenece el usuario	
	var $groups_list;
	var $checkbox;
	var $checkbox_groups;
	var $num_groups;
	var $num_users;
	var $id_group;
	var $group_name;
	var $users_per_module;
//variables del listado de modulos al que pertenece el usuario	
		
//Modulos a los que tiene acceso el usuario
	var $per_modules;
	var $modules;
	var $num_modules;
//Estas variables corresponde a las tablas donde hay un "id_user" y dependiendo de las variables se modificara o borrara el valor.
	var $var_name = "id_user";	
	var $table_names_modify = array ("emps");
	var $table_names_delete = array ("group_users","per_user_modules","per_user_methods");
	var $empleados;
	var $is_emps=false;
	var $return_validate_emps=true;
	//log_methods �donde tiene que ir? a delete o a modify?
	
  	//constructor
	function users(){
		//coge las variables globales del fichero config.inc.php
		global $DDBB_TYPE, $DDBB_NAME, $IP_DDBB, $DDBB_USER, $DDBB_PASS, $DDBB_PORT, $TABLE_PREFIX;
		$this->db_type=$DDBB_TYPE;
		$this->db_name=$DDBB_NAME;
		$this->db_ip=$IP_DDBB;
		$this->db_user=$DDBB_USER;
		$this->db_passwd=$DDBB_PASS;
		$this->db_port=$DDBB_PORT;
		$this->table_prefix=$TABLE_PREFIX;
		//define el array asociativo de los tipos de datos de los campos de la tabla
		/*****************
		//Importante
		//aqui hay que mirar las funciones meta de adodb para ver si podemos rellenar
		//este array de alguna manera aumatizada
		************************/
		$this->fields_list= new fields();
		$this->fields_list->add($this->ddbb_id_user, $this->id_user, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_login, $this->login, 'varchar', 20,0,1);
		$this->fields_list->add($this->ddbb_passwd, $this->passwd, 'varchar', 20,0,1);
		$this->fields_list->add($this->ddbb_name, $this->name, 'varchar', 20,0,1);
		$this->fields_list->add($this->ddbb_last_name, $this->last_name, 'varchar', 20,0);
		$this->fields_list->add($this->ddbb_last_name2, $this->last_name2, 'varchar', 20,0 );
		$this->fields_list->add($this->ddbb_full_name, $this->full_name, 'varchar', 100,0);		
		$this->fields_list->add($this->ddbb_internal, $this->internal, 'tinyint', 3,0 );
		$this->fields_list->add($this->ddbb_active, $this->active, 'tinyint', 3,0 );
		
		
		$this->search[0]= 'name';
		$this->search[1]= 'login';
		$this->search[2]= 'last_name';
		$this->search[3]= 'last_name2';
		
		return $this;	 
		
	}
	
	function get_list_users (){
		
		if (isset($_POST['submit_users_search']))
		{
			//Obtener datos del formulario de b�squeda
			$this->get_fields_from_search_post();
						
			//Generar consulta
			if($this->search_query[0]=='\\')
			{	
				//Guardar consulta para no modificar la variable 
				//que se mande denuevo al formulario
				$query =  $this->search_query;
				
				//Se va creando la nueva query que se mandar� mas tarde 
				//al formulario (se busca la siquiente ocurrencia de comillas)
				$query = substr ($this->search_query, 2);
				
				switch($this->search_query[1])
				{
					case '"':
								$cadena = substr ($this->search_query, 2, stripos($query, '"'));	
								//Preparar la cadena para volver a mostrarla sin caracteres de PHP
								$this->search_query = stripslashes($cadena);
								
								break;
					case '\'':	
								$cadena = substr ($this->search_query, 2, stripos($query, '\''));
								//Preparar la cadena para volver a mostrarla sin caracteres de PHP
								$this->search_query = stripslashes($cadena);
													
								break;
					default: break;
				}
			}
			
			//Crear query
			$my_search = new search();
			$query = $my_search->get_query($this->search_query, FALSE, $this->search, $this->fields_list);
		}	
		//Buscar los empleados de la empresa en la que se est� y coincidencia en id con los id de emps en drivers
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		if($query != "")
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$query;
		else
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name;
					//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		//cogemos los datos del usuario
		if(!$_SESSION['super'] && !$_SESSION['admin'])
		{
			$this->num=0;
			while (!$this->result->EOF) 
			{
				$users[$this->num][$this->ddbb_id_user]=$this->result->fields[$this->ddbb_id_user];
				$users[$this->num][$this->ddbb_login]=$this->result->fields[$this->ddbb_login];
				$users[$this->num][$this->ddbb_passwd]=$this->result->fields[$this->ddbb_passwd];
				$users[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
				$users[$this->num][$this->ddbb_last_name]=$this->result->fields[$this->ddbb_last_name];
				$users[$this->num][$this->ddbb_last_name2]=$this->result->fields[$this->ddbb_last_name2];
				$users[$this->num][$this->ddbb_full_name]=$this->result->fields[$this->ddbb_full_name];
				$users[$this->num][$this->ddbb_internal]=$this->result->fields[$this->ddbb_internal];
				$users[$this->num][$this->ddbb_active]=$this->result->fields[$this->ddbb_active];
				
				//nos movemos hasta el siguiente registro de resultado de la consulta
				$this->result->MoveNext();
				$this->num++;	
			}
			$this->registrados = $this->num;
			$num_usuarios = $this->num;
			$k=0;	
			for($i = 0; $i < $num_usuarios; $i++)
			{
				$num_groups = $this->get_groups($users[$i][$this->ddbb_id_user]);
				$per = true;
				for($j = 0; $j < $num_groups; $j++)
				{	
					if($this->groups_list[$j]['id_group'] == 2) 
					{
						$per = false;
					}
					else
					if($this->groups_list[$j]['id_group'] == 1)
					{
						$per = false;
					}
				}
				
				if($per)
				{
					$this->users_list[$k][$this->ddbb_id_user]=$users[$i][$this->ddbb_id_user];
					$this->users_list[$k][$this->ddbb_login]=$users[$i][$this->ddbb_login];
					$this->users_list[$k][$this->ddbb_passwd]=$users[$i][$this->ddbb_passwd];
					$this->users_list[$k][$this->ddbb_name]=$users[$i][$this->ddbb_name];
					$this->users_list[$k][$this->ddbb_last_name]=$users[$i][$this->ddbb_last_name];
					$this->users_list[$k][$this->ddbb_last_name2]=$users[$i][$this->ddbb_last_name2];
					$this->users_list[$k][$this->ddbb_full_name]=$users[$i][$this->ddbb_full_name];
					$this->users_list[$k][$this->ddbb_internal]=$users[$i][$this->ddbb_internal];
					$this->users_list[$k][$this->ddbb_active]=$users[$i][$this->ddbb_active];
					//nos movemos hasta el siguiente registro de resultado de la consulta
					$k++;
				}
			}//fin for
			$this->num = $k;	
		}
		else
		{
			$this->num=0;
			while (!$this->result->EOF) 
			{
				$this->users_list[$this->num][$this->ddbb_id_user]=$this->result->fields[$this->ddbb_id_user];
				$this->users_list[$this->num][$this->ddbb_login]=$this->result->fields[$this->ddbb_login];
				$this->users_list[$this->num][$this->ddbb_passwd]=$this->result->fields[$this->ddbb_passwd];
				$this->users_list[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
				$this->users_list[$this->num][$this->ddbb_last_name]=$this->result->fields[$this->ddbb_last_name];
				$this->users_list[$this->num][$this->ddbb_last_name2]=$this->result->fields[$this->ddbb_last_name2];
				$this->users_list[$this->num][$this->ddbb_full_name]=$this->result->fields[$this->ddbb_full_name];
				$this->users_list[$this->num][$this->ddbb_internal]=$this->result->fields[$this->ddbb_internal];
				$this->users_list[$this->num][$this->ddbb_active]=$this->result->fields[$this->ddbb_active];
			
				//nos movemos hasta el siguiente registro de resultado de la consulta
				$this->result->MoveNext();
				$this->num++;
			}
			$this->registrados = $this->num;	
		}
		
		$this->db->close();
		return $this->num;
	
	}
	
	function get_fields_from_search_post(){
		//Cogemos los campos principales de b�squeda
		$this->search_query=$_POST[$this->ddbb_search];
		return 0;
	}
	
	function get_id($login)
	{
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		//$this->sql="SELECT 'id_user' FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_name."=".$name_user;
		$this->sql="SELECT `id_user` FROM `users` WHERE `login` = \"".$login."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		$this->db->close();
		return $this->result->fields['id_user'];
	}
	
	function is_client($id)
	{
		$groups = new groups();
		$id_group = $groups->get_id('clients');
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		//$this->sql="SELECT 'id_user' FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_name."=".$name_user;
		$this->sql="SELECT * FROM `group_users` WHERE `id_user` = ".$id." AND id_group = ".$id_group;
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		$this->db->close();
		return 1;
	}
	
	function get_add_form(){
	
		
	
	}
	
	function print_add_form(){
	
	}
	
	function validate_add_form(){
	
	}
	
	function get_modify_form(){
	
	}
	
	function print_modify_form(){
	
	}
	
	function validate_modify_form(){
	
	}
	
	function read($id){
	
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_user."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_user=$id;
			$this->login=$this->result->fields[$this->ddbb_login];
			$this->passwd=$this->result->fields[$this->ddbb_passwd];
			$this->name=$this->result->fields[$this->ddbb_name];
			$this->last_name=$this->result->fields[$this->ddbb_last_name];
			$this->last_name2=$this->result->fields[$this->ddbb_last_name2];
			$this->full_name=$this->result->fields[$this->ddbb_full_name];
			$this->internal=$this->result->fields[$this->ddbb_internal];
			$this->active=$this->result->fields[$this->ddbb_active];
			
			$this->db->close();
			
			//Una vez sab�do el identificador de usuario, se puede pedir que realice su lista de permisos
			$this->validate_per_user($this->id_user);

			return 1;
		}
	}
	
	function read_fields($id)
	{
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_user."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			
			$this->id_user=$id;
			$this->login=$this->result->fields[$this->ddbb_login];
			$this->passwd=$this->result->fields[$this->ddbb_passwd];
			$this->name=$this->result->fields[$this->ddbb_name];
			$this->last_name=$this->result->fields[$this->ddbb_last_name];
			$this->last_name2=$this->result->fields[$this->ddbb_last_name2];
			$this->full_name=$this->result->fields[$this->ddbb_full_name];
			$this->internal=$this->result->fields[$this->ddbb_internal];
			$this->active=$this->result->fields[$this->ddbb_active];
			
			$this->db->close();
			
			return 1;
		}
	}
	
	function get_checkbox_modules_from_bbdd(){
			$this->checkbox=new permissions_modules;
			$modules=new modules();
			$num_modules = $modules->get_list_modules();
			$k=0;
			for($i=0;$i<$num_modules;$i++)
			{
				if($_SESSION['super'])
				{
					$this->checkbox->per_modules[$i]=new permissions_modules;
					$this->checkbox->per_modules[$i]->id_module=$modules->modules_list[$i]['id_module'];
					$this->checkbox->per_modules[$i]->module_name=$modules->modules_list[$i]['name_web'];
					$this->checkbox->per_modules[$i]->validate_per_module_without_groups($this->id_user);
				}
				else
				{
					if(($modules->modules_list[$i]['name']!='modules')&&($modules->modules_list[$i]['name']!='methods'))
					{
						$this->checkbox->per_modules[$k]=new permissions_modules;
						$this->checkbox->per_modules[$k]->id_module=$modules->modules_list[$i]['id_module'];
						$this->checkbox->per_modules[$k]->module_name=$modules->modules_list[$i]['name_web'];
						$this->checkbox->per_modules[$k]->validate_per_module_without_groups($this->id_user);
						
						if($modules->modules_list[$i]['name']=='corps')
						{
							//Si es admin y el modulo es empresas s�lo puede otorgar permisos en el m�todo Ver, 
							//por lo que todos los dem�s m�todos no le ser�n accesibles
							$j=0;
							$salir = false;
							while(($j<$this->checkbox->per_modules[$k]->num_methods)&&($salir==false))
							{
								if($this->checkbox->per_modules[$k]->per_methods[$j]->method_name == 'view')
								{
									$name = $this->checkbox->per_modules[$k]->per_methods[$j]->method_name; 
									$id_method = $this->checkbox->per_modules[$k]->per_methods[$j]->id_method;
									$name_web = $this->checkbox->per_modules[$k]->per_methods[$j]->method_name_web;
									$permiso = $this->checkbox->per_modules[$k]->per_methods[$j]->per;
									
									$this->checkbox->per_modules[$k]->per_methods = null;
									
									$this->checkbox->per_modules[$k]->per_methods[0] = new permissions_methods();
									$this->checkbox->per_modules[$k]->per_methods[0]->id_method = $id_method;
									$this->checkbox->per_modules[$k]->per_methods[0]->method_name_web = $name_web;
									$this->checkbox->per_modules[$k]->per_methods[0]->method_name == $name; 
									$this->checkbox->per_modules[$k]->per_methods[0]->per = $permiso;

									$this->checkbox->per_modules[$k]->num_methods = 1;
									$salir = true;
								}
								$j++;
							}
						}
						
						$k++;
					}
				}
			}
		return 0;
	}
	
	function get_checkbox_groups_from_bbdd(){
		$groups=new groups();
			$groups->get_list_groups();
			$this->get_groups($this->id_user);
			$k=0;
			for($i=0;$i<$groups->num;$i++)
			{
				if($_SESSION['super'])
				{
					$this->checkbox_groups[$i]= new groups();
					$this->checkbox_groups[$i]->read($groups->groups_list[$i][$groups->ddbb_id_group]);				
					if ($this->checkbox_groups[$i]->verify_user($this->id_user)!=0)
					{
						$this->checkbox_groups[$i]->belong=1;
					}
				}
				else
				{
					if(($groups->groups_list[$i][$groups->ddbb_name] != 'superadmin')||((!$_SESSION['admin']) && $groups->groups_list[$i][$groups->ddbb_name] != 'admin'))
					{
						$this->checkbox_groups[$k]= new groups();
						$this->checkbox_groups[$k]->read($groups->groups_list[$i][$groups->ddbb_id_group]);				
						if ($this->checkbox_groups[$k]->verify_user($this->id_user)!=0)
						{
							$this->checkbox_groups[$k]->belong=1;
						}
						$k++;
					}
				}
			}
		return 0;
	}
	
	function add(){
		//Miramos a ver si esta definida el "submit_add" y si no lo esta, pasamos directamente a mostrar la plantilla
		if (!isset($_POST['submit_add'])){
			//Mostrar plantilla vac�a	
			
			//Modulos
			$this->get_checkbox_modules_from_bbdd();
			//Grupos
			$this->get_checkbox_groups_from_bbdd();			
			return 0;
		}
		//en el caso de que SI este definido submit_add
		else{
						
			//Introducir los datos de post.
			$this->get_fields_from_post();	
						
			//Validacion
			//$return=validate_fields();
			$this->id_user=0;
			$this->fields_list->modify_value($this->ddbb_id_user,$this->id_user);
			$this->fields_list->modify_value($this->ddbb_login,$this->login);
			$this->fields_list->modify_value($this->ddbb_passwd,$this->passwd);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_last_name,$this->last_name);
			$this->fields_list->modify_value($this->ddbb_last_name2,$this->last_name2);
			//validamos
			$return=$this->fields_list->validate();	
			$return=$return && $this->fields_list->compare_passwd($this->passwd,$this->retype);
			$array=$this->take_logins();
			$return_login=$this->fields_list->validate_login($this->login,$array);
			$return=$return && $return_login;		
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			
			
			if (!$return || !$this->return_validate_emps){
				//Se utiliza $return_validate_emps para el formulario de empleados, ya que si se han introducido bien los datos del usuario, pero no los del empleado, no se deberia de a�adir.
				//Mostrar plantilla con datos erroneos
				
				return -1;
			}
			else{
				//Si todo es correcto si meten los datos
				
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexi�n con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexi�n permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_user." = -1" ;
				//la ejecuta y guarda los resultados
				$this->result = $this->db->Execute($this->sql);
				//si falla 
				if ($this->result === false){
					$this->error=1;
					$this->db->close();
					return 0;
				}
				//rellenamos el array con los datos de los atributos de la clase
				$record = array();
				$record[$this->ddbb_login] = $this->login;
				$record[$this->ddbb_passwd]=$this->passwd;
				$record[$this->ddbb_name]=$this->name;
				$record[$this->ddbb_last_name]=$this->last_name;
				$record[$this->ddbb_last_name2]=$this->last_name2;
				$record[$this->ddbb_full_name]=$this->full_name;
				$record[$this->ddbb_internal]=$this->internal;
				$record[$this->ddbb_active]=$this->active;
				//calculamos la sql de inserci�n respecto a los atributos
				$this->sql = $this->db->GetInsertSQL($this->result, $record);
				//print($this->sql);
				//insertamos el registro
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				if($this->db->Insert_ID()>=0){
					//SE INSERTAN LOS PERMISOS.
					//Insertamos los permisos por modulo					
					//Insertamos los grupos
					//$this->insert_per_groups();
					//capturammos el id de la linea insertada
					$this->id_user=$this->db->Insert_ID();
					$this->add_group_users();
					$this->add_per_modules_methods();
					//print("<pre>::".$this->id_user."::</pre>");
					//devolvemos el id de la tabla ya que todo ha ido bien
					$this->db->close();
					
					//Se hace nueva imagen de las tablas de permiso para usuarios
					$permisos = new permissions();
					$_SESSION['permisos_user_modules'] = $permisos->get_per_user_modules();
					$_SESSION['permisos_user_methods'] = $permisos->get_per_user_methods();
					
					return $this->id_user;
				}else {
					
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}			
				
				
				
			}
		}
	}
	
			
		function remove($id){
			if (!isset($_POST["submit_delete"])){
				//Miramos a ver si hay algun empleado que tenga este usuario						
				$this->view_emps($id);					
				return 0;
			}
			else{
			//HAY QUE VERIFICAR EN LAS COMPROBACIONES QUE NO SE ELIMINE EL MISMO USUARIO
			//QUE ESTA CONECTADO EN ESTE MOMENTO.
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_user." = ".$id;
			//la ejecuta y guarda los resultados		

			$this->result = $this->db->Execute($this->sql);
			//si falla 

			if ($this->db->Affected_Rows() == 0){				
				$this->error=1;
				$this->db->close();
				return 0;
			}else{
				$this->make_remove($id);
				$this->error=0;
				$this->db->close();
				return 1;
				
			}
		}
	}
	
	function modify(){
		if (!isset($_POST['submit_modify'])){
			//Mostrar plantilla vac�a	
			//pasarle a la plantilla los modulos y grupos con sus respectivos checkbox a checked false
			/*$this->checkbox=new permissions_modules();
			$modules=new modules();
			$num_modules = $modules->get_list_modules();
		
			$k=0;
			for($i=0;$i<$num_modules;$i++)
			{
				if($_SESSION['super'])
				{
					$this->checkbox->per_modules[$i]=new permissions_modules;
					$this->checkbox->per_modules[$i]->id_module=$modules->modules_list[$i]['id_module'];
					$this->checkbox->per_modules[$i]->module_name=$modules->modules_list[$i]['name_web'];
					$this->checkbox->per_modules[$i]->validate_per_module_without_groups($this->id_user);
				}
				else
				{
					if(($modules->modules_list[$i]['name']!='modules')&&($modules->modules_list[$i]['name']!='methods'))
					{
						$this->checkbox->per_modules[$k]=new permissions_modules;
						$this->checkbox->per_modules[$k]->id_module=$modules->modules_list[$i]['id_module'];
						$this->checkbox->per_modules[$k]->module_name=$modules->modules_list[$i]['name_web'];
						$this->checkbox->per_modules[$k]->validate_per_module_without_groups($this->id_user);
						
						if($modules->modules_list[$i]['name']=='corps')
						{
							//Si es admin y el modulo es empresas s�lo puede otorgar permisos en el m�todo Ver, 
							//por lo que todos los dem�s m�todos no le ser�n accesibles
							$j=0;
							$salir = false;
							while(($j<$this->checkbox->per_modules[$k]->num_methods)&&($salir==false))
							{
								if($this->checkbox->per_modules[$k]->per_methods[$j]->method_name == 'view')
								{
									$name = $this->checkbox->per_modules[$k]->per_methods[$j]->method_name; 
									$id_method = $this->checkbox->per_modules[$k]->per_methods[$j]->id_method;
									$name_web = $this->checkbox->per_modules[$k]->per_methods[$j]->method_name_web;
									$permiso = $this->checkbox->per_modules[$k]->per_methods[$j]->per;
									
									$this->checkbox->per_modules[$k]->per_methods = null;								
									$this->checkbox->per_modules[$k]->per_methods[0] = new permissions_methods();
									$this->checkbox->per_modules[$k]->per_methods[0]->id_method = $id_method;
									$this->checkbox->per_modules[$k]->per_methods[0]->method_name_web = $name_web;
									$this->checkbox->per_modules[$k]->per_methods[0]->method_name == $name; 
									$this->checkbox->per_modules[$k]->per_methods[0]->per = $permiso;

									$this->checkbox->per_modules[$k]->num_methods = 1;
									$salir = true;
								}
								$j++;
							}
						}
						
						$k++;
					}
				}
			}
			
			$groups=new groups();
			$groups->get_list_groups();
	
			$this->get_groups($this->id_user);
			
			$k=0;
			for($i=0;$i<$groups->num;$i++)
			{
				if($_SESSION['super'])
				{
					$this->checkbox_groups[$i]= new groups();
					$this->checkbox_groups[$i]->read($groups->groups_list[$i][$groups->ddbb_id_group]);	
					
					if ($this->checkbox_groups[$i]->verify_user($this->id_user)!=0)
					{
						$this->checkbox_groups[$i]->belong=1;
					}
				}
				else
				{
					if(($groups->groups_list[$i][$groups->ddbb_name] != 'superadmin')&&($groups->groups_list[$i][$groups->ddbb_name] != 'admin'))
					{
						$this->checkbox_groups[$k]= new groups();
						$this->checkbox_groups[$k]->read($groups->groups_list[$i][$groups->ddbb_id_group]);				
						if ($this->checkbox_groups[$k]->verify_user($this->id_user)!=0)
						{
							$this->checkbox_groups[$k]->belong=1;
						}
						$k++;
					}
				}
			}
			//$tpl->assign('usuarios',$this->per_module_methods);
			*/
			//Modulos
			$this->get_checkbox_modules_from_bbdd();
			//Grupos
			$this->get_checkbox_groups_from_bbdd();	
			return 0;
		}
		else{
			/*************
			 * 
			 *OJO!!! ANTES DE COGER LOS DATOS DEL FORMULARIO ASIGNAR EL LOGIN
			 *
			 */
			$login=$this->login;
			$passwd=$this->passwd;//Introducir los datos de post.
			$this->get_fields_from_post();
			
			//Validacion
			$this->fields_list->modify_value($this->ddbb_id_user,$this->id_user);
			$this->fields_list->modify_value($this->ddbb_login,$this->login);
			$this->fields_list->modify_value($this->ddbb_passwd,$this->passwd);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_last_name,$this->last_name);
			$this->fields_list->modify_value($this->ddbb_last_name2,$this->last_name2);
			//validamos
			$return=$this->fields_list->validate();	
			//Si la contrase�a es igual a la introducida entonces no ha habido cambios y no hace falta reescribirla y por tanto no hace falta una comprobacion.
			if ($passwd!=$this->passwd)
				$return=$return && $this->fields_list->compare_passwd($this->passwd,$this->retype);
			//Se cogen los logins para comprobar que no se introduzca un login igual
			$array=$this->take_logins();
			$return_login=$this->fields_list->validate_login($this->login,$array,$login);
			$return=$return && $return_login;
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *					
			if (!$return){
				//Mostrar plantilla con datos erroneos
				return -1;
			}
			else{
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexi�n con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexi�n permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_user." = \"".$this->id_user."\"" ;
				//la ejecuta y guarda los resultados
				$this->result = $this->db->Execute($this->sql);
				//si falla 
				if ($this->result === false){
					$this->error=1;
					$this->db->close();
					return 0;
				}
				//rellenamos el array con los datos de los atributos de la clase
				$record = array();
				$record[$this->ddbb_id_user]=$this->id_user;
				$record[$this->ddbb_login] = $this->login;
				$record[$this->ddbb_passwd]=$this->passwd;
				$record[$this->ddbb_name]=$this->name;
				$record[$this->ddbb_last_name]=$this->last_name;
				$record[$this->ddbb_last_name2]=$this->last_name2;
				$record[$this->ddbb_full_name]=$this->full_name;
				$record[$this->ddbb_internal]=$this->internal;
				$record[$this->ddbb_active]=$this->active;
				//calculamos la sql de inserci�n respecto a los atributos
				$this->sql = $this->db->GetUpdateSQL($this->result, $record);
				//insertamos el registro				
				$this->db->Execute($this->sql);
				//si se ha insertado una fila

				if(($this->db->Affected_Rows()==1)||($this->sql=="")){
					//capturammos el id de la linea insertada
				
					$this->modify_group_users();
					$this->modify_module_methods();

					$this->db->close();
					
					//Se hace nueva imagen de las tablas de permiso para usuarios
					$permisos = new permissions();
					$_SESSION['permisos_user_modules'] = $permisos->get_per_user_modules();
					$_SESSION['permisos_user_methods'] = $permisos->get_per_user_methods();
					
					//devolvemos el id de la tabla ya que todo ha ido bien
					return $this->id_user;
				}else {
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}
			}
		}	
	}
	  
	function validate_user($user, $passwd){
		if($user=='') return 0;
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_login."=\"".$user."\"";
		//printf($this->sql);
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla
		//print_r($this->result); 
		if ($this->result === false){
			//printf('no existe usuario o contrase�a');
			$error=1;
			$this->db->close();
			return 0;
		}else{  
		//la contrase�a es correcta
			if($passwd==$this->result->fields[$this->ddbb_passwd]&&$user==$this->result->fields[$this->ddbb_login]){
			//printf('existe usuario o contrase�a');
			$this->db->close();
			return 1;
			}
		}
		$this->db->close();
		return 0;
		
		
	
	}
	
	function view ($id,$tpl){
	/*
		Cosas que faltan por hacer:
			De forma general, mirar los permisos del usuario que vaya a acceder aqui, para saber si tiene permisos de borrar editar ver etc...
			Averiguar como pasar el numero de registros, si va a ser a grupos a grupos, si va a ser a modulos, a modulos
			Order By (y mantener la b�squeda en el caso de que hubiera hecha una y averiguar la "pesta�a" a la que hace referencia)
			Busquedas
	*/
			$cadena='';			
			// Leemos el usuario y se lo pasamos a la plantilla
			$this->read($id);
			$tpl->assign('objeto',$this);
		
			
			
			if(!$_SESSION['super'] || !$_SESSION['admin'])
			{	
				$groups = false;
				$modules = false;
			
				$i=0;
				while($i!=$this->num_modules)
				{
			
					if(($this->per_modules[$i]->per == 1)&&($this->per_modules[$i]->module_name=='modules'))
					{
					//Se comprueba si se tiene permiso para ver
						$j=0;
						while(($j<$this->per_modules[$i]->num_methods))
						{
							if(($this->per_modules[$i]->per_methods[$j]->per == 1)&&($this->per_modules[$i]->per_methods[$j]->method_name == 'view'))
							{
								$modules = true;
							}
							$j++;
						}
					}
					else 
					if(($this->per_modules[$i]->per == 1)&&($this->per_modules[$i]->module_name=='groups'))
					{
						//Se comprueba si se tiene permiso para ver
						$j=0;
						while(($j<$this->per_modules[$i]->num_methods))
						{
							if(($this->per_modules[$i]->per_methods[$j]->per == 1)&&($this->per_modules[$i]->per_methods[$j]->method_name == 'view'))
							{
								$groups = true;
							}
							$j++;
						}
					}
					
					$i++;
					
				}

			}
			else
			{
				$modules = true;
				$groups = true;
			}
			
		
			$mensaje = null;
			$mensaje[0]['id_mensaje'] = 1;
			$mensaje[0]['mes'] = "Sentimos informarle de que no tiene permiso para acceder a esta informaci�n";
			
			//listado de modulos
			$tabla_modulos = new table(false);
			if($modules)
			{
				if ($this->num_modules==0)
				{
	
					$cadena=$cadena.$tabla_modulos->tabla_vacia('modules', false);
					$variables_modulos=$tabla_modulos->nombres_variables;
				}
				else{	
					//Se prepara el array de permisos
					$k=0;
					for($i = 0;$i<$this->num_modules;$i++)
					{
						if(($this->per_modules[$i]->per == 1)&&($this->per_modules[$i]->module_name != 'error'))
						{
							$permissions[$k]['id_module']=$this->per_modules[$i]->id_module;
							$permissions[$k]['name']=$this->per_modules[$i]->web_name;
							$permissions[$k]['methods'] = "";
							for($j=0;$j<$this->per_modules[$i]->num_methods;$j++)
								if($this->per_modules[$i]->per_methods[$j]->per ==1)
								{
									$permissions[$k]['methods'] = $permissions[$k]['methods'].' '.$this->per_modules[$i]->per_methods[$j]->method_name_web;
								}
								$k++;
						}
					}
					
						
					$cadena=$cadena.$tabla_modulos->make_tables('modules',$permissions,array('Nombre del modulo',20,'M�todos en los que se tiene permiso',120),array('id_module','name', 'methods'),$_SESSION['num_regs'],null,false);
					$variables_modulos=$tabla_modulos->nombres_variables;
				}
			}
			else
			{
				$cadena=$cadena.$tabla_modulos->make_tables('modules',$mensaje,array('ACCION NO PERMITIDA',50),array('id_mensaje','mes'),10,null,false);
				$variables_modulos=$tabla_modulos->nombres_variables;
			}
			
			
			//listado de permisos por modulos
			$tabla_grupos = new table(false);
			if($groups)
			{
				
				//listado de grupos
				if ($this->get_groups($id)==0)
				{
					$cadena=$cadena.$tabla_grupos->tabla_vacia('group_users',false);
					$variables_grupos=$tabla_grupos->nombres_variables;
				}
				else
				{		
					$per = new permissions();
					$num = $per->get_permissions_list('users');
					
					$per_delete = null;
					for($i=0; $i<$num;$i++)
					if($per->permissions_module[$i] == 'delete')
						$per_delete = array('delete');
								
					$cadena=$cadena.$tabla_grupos->make_tables('group_users',$this->groups_list,array('Nombre de grupo',75),array('id_group','name_web'),$_SESSION['num_regs'],array(),false);
					$variables_grupos=$tabla_grupos->nombres_variables;
				}
			}
			else
			{
				$cadena=$cadena.$tabla_grupos->make_tables('groups_users',$mensaje,array('ACCION NO PERMITIDA',50),array('id_mensaje','mes'),10,null,false);
				$variables_grupos=$tabla_grupos->nombres_variables;
			}
			
			$i=0;
			while($i<(count($variables_grupos)+count($variables_modulos))){
				for($j=0;$j<count($variables_grupos);$j++){
					$variables[$i]=$variables_grupos[$j];
					$i++;
				}
				for($k=0;$k<count($variables_modulos);$k++){
					$variables[$i]=$variables_modulos[$k];
					$i++;
				}
			}
			
			//Se comprueba si hay permiso para borrar o modificar
			$permisos_mod_del = new permissions();
			$permisos_mod_del->get_permissions_modify_delete('users');

			
			$tpl->assign('acciones',$permisos_mod_del->per_mod_del);

			$tpl->assign('variables',$variables);
			$tpl->assign('cadena',$cadena);
			//			
			return $tpl;
				
	}
	
	function listar($tpl){
		if (isset($_POST['submit_users_search']))
		{
			//Se toma el n�mero de registros y se guarda en varable de sesi�n
			//que se cumpla en todos los accesos del usuario
			$_SESSION['num_regs']= $_POST['regs'];
			
		}
		$num = $this->get_list_users();
		$tabla_listado = new table(true);
		$per = new permissions();
		$per->get_permissions_list('users');
		if ($num==0)
		{
			$cadena=''.$cadena.$tabla_listado->tabla_vacia('users', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{	
			$cadena=''.$tabla_listado->make_tables('users',$this->users_list,array('Login',20,'Nombre',20,'Primer Apellido',20,'Segundo Apellido',20),array($this->ddbb_id_user,$this->ddbb_login,$this->ddbb_name,$this->ddbb_last_name,$this->ddbb_last_name2),$_SESSION['num_regs'],$per->permissions_module,$per->add);
			$variables=$tabla_listado->nombres_variables;
		}		
		$tpl->assign('variables',$variables);
		$tpl->assign('cadena',$cadena);		
		return $tpl;
	}
	
	
	function calculate_tpl($method, $tpl){
		$this->method=$method;
		if ($this->is_emps)
			$prefix="user_";
		else
			$prefix="";
				switch($method){
						case 'add':									
									/*if ($this->add() !=0){
										$this->method="list";
										$tpl=$this->listar($tpl);										
										$tpl->assign("message","&nbsp;<br>Usuario a&ntilde;adido correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
									$tpl->assign("modulos",$this->checkbox);
									$tpl->assign("grupos",$this->checkbox_groups);
									break;*/
									$return=$this->add();
									switch ($return){										
										case 0: //por defecto												
												break;
										case -1: //Errores al intentar a�adir datos
												
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign($prefix."error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
													//echo $prefix."error_".$this->fields_list->array_error[$i];
												}												
												break;
										default: //Si se ha a�adido
												$this->method="list";
												$tpl=$this->listar($tpl);										
												$tpl->assign("message","&nbsp;<br>Usuario a&ntilde;adido correctamente<br>&nbsp;");
												break;
									}
									
									
									$tpl->assign("modulos",$this->checkbox);
									$tpl->assign("grupos",$this->checkbox_groups);
									$tpl->assign("objeto",$this);
									break;
									
						case 'list':
									$tpl=$this->listar($tpl);
									$tpl->assign("objeto",$this);
									$tpl->assign("registro",$_SESSION['num_regs']);
									break;
						case 'modify':
									/*$this->read($_GET['id']);
									if ($this->modify() !=0){
										$this->method="list";
										$tpl=$this->listar($tpl);										
										$tpl->assign("message","&nbsp;<br>Usuario modificado correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
									$tpl->assign("modulos",$this->checkbox);
									$tpl->assign("grupos",$this->checkbox_groups);
									break;*/
									$this->read($_GET['id']);				
									$return=$this->modify();
									switch ($return){										
										case 0: //por defecto
												break;
										case -1: //Errores al intentar a�adir datos
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
												}
												break;
										default: //Si se ha a�adido
												$this->method="list";
										$tpl=$this->listar($tpl);										
										$tpl->assign("message","&nbsp;<br>Usuario modificado correctamente<br>&nbsp;");
												break;
									}
									$tpl->assign("objeto",$this);
									$tpl->assign("modulos",$this->checkbox);
									$tpl->assign("grupos",$this->checkbox_groups);
									break;
						case 'delete':
									$this->read($_GET['id']);
									if ($this->remove($_GET['id'])==0){
										$tpl->assign("message",$this->empleados);
									}
									else{
										$this->users_list="";
										$this->method="list";
										$tpl=$this->listar($tpl);
										$tpl->assign("message","&nbsp;<br>Usuario borrado correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
									break;
						case 'view':									
									$tpl=$this->view($_GET['id'],$tpl);
									break;
						default:
									$this->method='list';
									$tpl=$this->listar($tpl);
									$tpl->assign("objeto",$this);
									$tpl->assign("registro",$_SESSION['num_regs']);
									break;
					}
				$tpl->assign('plantilla','users_'.$this->method.'.tpl');					
		
		return $tpl;
	}
	
	function get_fields_from_post(){
		
		//Cogemos los campos principales
		$prefix="";
		if ($this->is_emps){
			$prefix="user_";
		}
		$this->login=htmlentities($_POST[$prefix.$this->ddbb_login]);
		$this->passwd=htmlentities($_POST[$prefix.$this->ddbb_passwd]);
		$this->retype=htmlentities($_POST[$prefix.$this->ddbb_retype]);
		$this->name=htmlentities($_POST[$prefix.$this->ddbb_name]);
		$this->last_name=htmlentities($_POST[$prefix.$this->ddbb_last_name]);
		$this->last_name2=htmlentities($_POST[$prefix.$this->ddbb_last_name2]);			
		

		//Cogemos los checkbox de grupos
		$this->get_groups_from_post();
		//Cogemos los checkboxn de modulos-grupos
		$this->get_modules_methods_from_post();

		return 0;
	}	
	
	function get_groups_from_post(){		
		$groups=new groups();
		$groups->get_list_groups();
		$group_users = new group_users();
		$num_groups = $group_users->get_list_group_users();
			for($i=0;$i<$num_groups;$i++){
				$this->checkbox_groups[$i]= new groups();
				$this->checkbox_groups[$i]->read($groups->groups_list[$i][$groups->ddbb_id_group]);
				
			}
			for($i=0;$i<$groups->num;$i++){
				
				$this->checkbox_groups[$i]->belong=$_POST["grupo_".$this->checkbox_groups[$i]->id_group];
				if($this->checkbox_groups[$i]->belong!=1){
					$this->checkbox_groups[$i]->belong=0;
				}
			}			
	}
	function get_modules_methods_from_post(){		
		
		$this->checkbox=new permissions_modules();
		$modules=new modules();
		$num_modules = $modules->get_list_modules();
			for($i=0;$i<$num_modules;$i++){
				$this->checkbox->per_modules[$i]=new permissions_modules();	
				$this->checkbox->per_modules[$i]->id_module=$modules->modules_list[$i]['id_module'];
				$this->checkbox->per_modules[$i]->module_name=$modules->modules_list[$i]['name_web'];
				$this->checkbox->per_modules[$i]->validate_per_module(0);
			}			
			for($i=0;$i<$modules->num;$i++){			
					$this->checkbox->per_modules[$i]->per=$_POST["modulo_".$this->checkbox->per_modules[$i]->id_module];
					if ($this->checkbox->per_modules[$i]->per!=1){
						$this->checkbox->per_modules[$i]->per=0;
					}
					//aqui hacemos lo mismo pero con los metodos.

					for($j=0;$j<count($this->checkbox->per_modules[$i]->per_methods);$j++){
								$this->checkbox->per_modules[$i]->per_methods[$j]->per=$_POST['modulo_'.$this->checkbox->per_modules[$i]->id_module.'_metodo_'.$this->checkbox->per_modules[$i]->per_methods[$j]->id_method];
								if ($this->checkbox->per_modules[$i]->per_methods[$j]->per!=1){									
									$this->checkbox->per_modules[$i]->per_methods[$j]->per=0;
								}								
					}
			}		
		return 0;			 			
	}
	
	
	function get_groups($id){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT `groups`.`id_group` , `groups`.`name_web` FROM `groups` INNER JOIN `group_users` ON `groups`.`id_group` = `group_users`.`id_group` WHERE `group_users`.`id_user` = \''.$id.'\'';
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		if ($this->result === false){
			$this->error=1;
			$this->db->close();
			return 0;
		}  
		
		$this->num=0;
		while (!$this->result->EOF) {
			//cogemos los datos del usuario
			$this->groups_list[$this->num]['id_group']=$this->result->fields['id_group'];
			$this->groups_list[$this->num]['name_web']=$this->result->fields['name_web'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	}
	
	
	function get_modules($id){	
		return 0;
	}

	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}		
	if ($corp != ""){
			$corp='<a href="index.php?module=corps&method=view&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = '<a href="index.php?module=user_corps">Zona privada</a> :: '.$corp.' <a href="index.php?module=users">Usuarios</a>';
		$nav_bar=$nav_bar.$this->localice($method);
		return $nav_bar;
	}	

	function title($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}
		if ($corp != ""){
			$corp=$corp." ::";
		}
		$title = "Zona Privada :: $corp Usuarios";
		$title=$title.$this->localice($method);		
		return $title;
	}		
	
	
	//Funci�n que indicar� para qu� tiene permisos un usuario (ya sea por los grupos a los que pertenece o por �l m�smo)
	//Para ello se har� un listado de modulos_metodos_permiso en cada metodo de cada modulo
	//Se usar� una lista de permissions que contendr� por cada id_modulo (indice de la lista) el metodo (nombre e id de este) y permiso
	//El nombre del modulo se puede obtener gracias al id_modulo desde la lista de modulos a los que se tiene permiso
	//
	function validate_per_user($id_user)
	{			
		$this->modules = new modules();	
		$this->num_modules = $this->modules->get_list_modules();
		for ($modulo_num = 0; $modulo_num < $this->num_modules; $modulo_num++) 
		{
			//Como se tiene el numero de modulos entonces se puede ver nombre e identificador en $this->modules->modules_list
			//As� ser� mas f�cil recorrer la matriz, y no hay problemas de pasar un hash a smarty ya que no los acepta
			$this->per_modules[$modulo_num] = new permissions_modules();
			$this->per_modules[$modulo_num]->id_module = $this->modules->modules_list[$modulo_num]['id_module'];
			$this->per_modules[$modulo_num]->module_name = $this->modules->modules_list[$modulo_num]['name'];
			$this->per_modules[$modulo_num]->web_name = $this->modules->modules_list[$modulo_num]['name_web'];
			$this->per_modules[$modulo_num]->publico = $this->modules->modules_list[$modulo_num]['public'];
			$this->per_modules[$modulo_num]->parent = $this->modules->modules_list[$modulo_num]['parent'];
			$this->per_modules[$modulo_num]->active = $this->modules->modules_list[$modulo_num]['active'];

			$this->per_modules[$modulo_num]->validate_per_module($id_user);
		
		}
	}
	
	function validate_per_user_module($id_user, $module)
	{	

		$this->modules = new modules();
		$id_module = $this->modules->get_id($module);

		$this->modules->read($id_module);
		
		$this->permission = new permissions_modules();
		$this->permission->id_module = $this->modules->id_module;
		$this->permission->module_name = $this->modules->name;
		$this->permission->web_name = $this->modules->name_web;
		$this->permission->publico = $this->modules->publico;
		$this->permission->parent = $this->modules->parent;
		$this->permission->validate_per_module($id_user);
	
	}
	
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Usuarios";
									break;
						case 'list':
									$localice=" :: Buscar Usuarios";
									break;
						case 'modify':
									$localice=" :: Modificar Usuarios";
									break;
						case 'delete':
									$localice=" :: Borrar Usuarios";
									break;
						case 'view':
									$localice=" :: Ver Usuario";									
									break;
						default:
									$localice=" :: Buscar Usuarios";
									break;
		}
		return $localice;
	}
	
	
	function add_group_users(){
		//$groups=new groups();
		$group_users= new group_users();
		$num_groups = $group_users->get_list_group_users();
		for($i=0;$i<$num_groups;$i++){
		
			if($this->checkbox_groups[$i]->belong==1){
				$group_users->id_group=$this->checkbox_groups[$i]->id_group;
				$group_users->id_user=$this->id_user;
				$group_users->add();
			}
		}
		return;
	}
	
	function modify_group_users(){
		//$groups=new groups();
		$group_users=new group_users();
		$num_groups = $group_users->get_list_group_users();
		for($i=0;$i<$num_groups;$i++){

			if($this->checkbox_groups[$i]->belong==0){
				//$result es el id del group_users de la tabla que se ve a continuacion.
				$result=$group_users->verify_group_user($this->checkbox_groups[$i]->id_group,$this->id_user);

				if($result!=0){
					$group_users->remove($result);					
				}
			}
			else{
				$result=$group_users->verify_group_user($this->checkbox_groups[$i]->id_group,$this->id_user);

				if($result==0){
					$group_users->id_group=$this->checkbox_groups[$i]->id_group;
					$group_users->id_user=$this->id_user;
					$group_users->add();
				}
			}
		}
	}
	
	function add_per_modules_methods(){
		$per_user_modules=new per_user_modules();
		$per_user_methods=new per_user_methods();					
			for($i=0;$i<count($this->checkbox->per_modules);$i++){																					
					if ($this->checkbox->per_modules[$i]->per==1){			
								
						$per_user_modules->id_module=$this->checkbox->per_modules[$i]->id_module;
						$per_user_modules->id_user=$this->id_user;
						$per_user_modules->per=1;						
						$per_user_modules->add();
						}

					for($j=0;$j<count($this->checkbox->per_modules[$i]->per_methods);$j++){
								if ($this->checkbox->per_modules[$i]->per_methods[$j]->per==1){
									$per_user_methods->id_method=$this->checkbox->per_modules[$i]->per_methods[$j]->id_method;
									$per_user_methods->id_user=$this->id_user;
									$per_user_methods->per=1;
									$per_user_methods->add();
								}								
					}
			}		
		return 0;
	}
	
	function modify_module_methods(){
		$per_user_modules=new per_user_modules();
		$per_user_methods=new per_user_methods();					
			for($i=0;$i<count($this->checkbox->per_modules);$i++){																									
				if ($this->checkbox->per_modules[$i]->per==1){		
				/***********
				En caso de que el valor del checkbox sea 1 si existe en la tabla se modifica	,
				y si no existe, se crea*/
					$result=$per_user_modules->verify_user_module($this->id_user,$this->checkbox->per_modules[$i]->id_module);
					if ($result!=0){
						$per_user_modules->read($result);
						$per_user_modules->per=1;						
						$per_user_modules->modify();							
					}									
					else{
						$per_user_modules->id_module=$this->checkbox->per_modules[$i]->id_module;
						$per_user_modules->id_user=$this->id_user;
						$per_user_modules->per=1;						
						$per_user_modules->add();
					}
					for($j=0;$j<count($this->checkbox->per_modules[$i]->per_methods);$j++){
						
						if ($this->checkbox->per_modules[$i]->per_methods[$j]->per==1){
							/***********
							En caso de que el valor del checkbox sea 1 si existe en la tabla se modifica	,
							y si no existe, se crea*/
							$result=$per_user_methods->verify_user_method($this->id_user,$this->checkbox->per_modules[$i]->per_methods[$j]->id_method);
							if ($result!=0){
								$per_user_methods->read($result);
								$per_user_methods->per=1;
								$per_user_methods->modify();
							}
							else{
								$per_user_methods->id_method=$this->checkbox->per_modules[$i]->per_methods[$j]->id_method;
								$per_user_methods->id_user=$this->id_user;
								$per_user_methods->per=1;
								$per_user_methods->add();
							}
						}								
						else{
							/*****************
							En caso de que el valor sea 0, si existe en la tabla se cambia su valor, si no no se hace
							nada
							*/
							
							$result=$per_user_methods->verify_user_method($this->id_user,$this->checkbox->per_modules[$i]->per_methods[$j]->id_method);
							if ($result!=0){
								$per_user_methods->read($result);
								$per_user_methods->per=0;
								$per_user_methods->modify();
							}
						}
					}
				}
				else{//En caso de que el permiso sea 0 si existe en la tabla, se modificara el valor, y si no existe no har� nada

					$result=$per_user_modules->verify_user_module($this->id_user,$this->checkbox->per_modules[$i]->id_module);

					if ($result!=0){

						$per_user_modules->read($result);
						
						$per_user_modules->per=0;	
						
						$per_user_modules->modify();							
					}	
					//Aqui los checkbox de metodos al no tener permiso en un modulo, no pueden ser valores iguales a 1, ya qu eno puede tener permiso.
					for($j=0;$j<count($this->checkbox->per_modules[$i]->per_methods);$j++){
						$result=$per_user_methods->verify_user_method($this->id_user,$this->checkbox->per_modules[$i]->per_methods[$j]->id_method);
						//En caso de que exista el valor se modifica y si no, no se hace nada.
						if ($result!=0){
							$per_user_methods->read($result);
							$per_user_methods->per=0;
							$per_user_methods->modify();
						}									
					}								
				}					
		}		
		return 0;
	}
	
	
	function view_emps($id){
		
			$emp = new emps();				
			$result=$emp->verify_emps($id);
			$this->empleados="";
			if ($result!=0){
				$this->empleados="<p>Atenci�n este usuario tiene asignados los siguientes empleados:";
				$this->empleados.="<br><br>";
				for($i=0;$i<$result;$i++){
					$this->empleados.="&nbsp;&nbsp;&nbsp;";
					$this->empleados.=$emp->emps_users_list[$i]["name"]."&nbsp;";
					$this->empleados.=$emp->emps_users_list[$i]["last_name"]."&nbsp;";
					$this->empleados.=$emp->emps_users_list[$i]["last_name2"]."<br>";
				}
				$this->empleados.="<br>";
				$this->empleados.="Si borra este usuario, se borrar&aacute; la relaci&oacute;n con estos empleados";
				$this->empleados.="</p>";
			}			
	}
	
	function make_remove($id){
		//modificamos todos aquellos registros en los que hay un id_user;
		for ($i=0;$i<count($this->table_names_modify);$i++){
			$this->modify_all_id_user($id,$this->table_names_modify[$i]);
		}
		//borramos todos aquellos registros en los que hay un id_user;		
		for ($i=0;$i<count($this->table_names_delete);$i++){
			$this->delete_all_id_user($id,$this->table_names_delete[$i]);
		}
	}
	
	function modify_all_id_user($id,$table){
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="UPDATE ".$table. " SET id_user = 0 WHERE id_user = ".$id;
			//la ejecuta y guarda los resultados
			$this->result = $this->db->Execute($this->sql);
			//si falla 
			if ($this->db->Affected_Rows() == 0){
				$this->error=1;
				$this->db->close();
				return 0;
			}else{
			
				$this->error=0;
				$this->db->close();
				return 1;
				
			}
	}
	
	function delete_all_id_user($id,$table){
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.

			$this->sql="DELETE FROM ".$table. " WHERE id_user = ".$id;
			//la ejecuta y guarda los resultados
			$this->result = $this->db->Execute($this->sql);
			//si falla 
			if ($this->db->Affected_Rows() == 0){
				$this->error=1;
				$this->db->close();
				return 0;
			}else{
			
				$this->error=0;
				$this->db->close();
				return 1;
				
			}
	}
	
	function take_logins(){
		if(!is_array($this->users_list))
			$this->get_list_users();
		$array=array();
		for($i=0;$i<count($this->users_list);$i++){
			$array[$i]=$this->users_list[$i]['login'];
		}
		return $array;
	}	
	
	
	function admin ($id){
	
	
	}
	
}
?>