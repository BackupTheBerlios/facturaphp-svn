<?php
//clase que da soporte a los grupos del programa
//enlaza con la bbdd 
//Variables para el listado de grupos en el formulario de alta de "usuarios": groups_list

global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($ADODB_DIR."adodb.inc.php");
require_once ($INSTALL_DIR.'inc/table.class.php');
class groups{
//internal vars
	var $id_group;
	var $name;
	var $descrip;
	var $name_web;
	var $theme;
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
	var $table_name='groups';
	var $ddbb_id_group='id_group';
	var $ddbb_name='name';
	var $ddbb_name_web='name_web';
  	var $ddbb_descrip='descrip';
	var $ddbb_search='search';
  	var $db;
	var $result;
//variables complementarias	
  	var $groups_list;
  	var $num;
  	var $fields_list;
  	var $error;
	var $belong; //<- Esta variable se usara desde users.class.php la cual nos dira si el checkbox de los modelos modify o add estan a 1 o a 0 para grupos. Por defecto estar� a 0.
	var $per_modules;
	var $num_modules;
	var $users_list;
	var $checkbox;
	var $method;
	//Estas variables corresponde a las tablas donde hay un "id_group" y dependiendo de las variables se modificara o borrara el valor.
	var $var_name = "id_group";	
	var $table_names_modify;
	var $table_names_delete = array ("group_users","per_group_modules","per_group_methods");
  	//constructor
	function groups(){
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
		$this->fields_list->add($this->ddbb_id_group, $this->id_group, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_name, $this->name, 'varchar', 20,0,1);
		$this->fields_list->add($this->ddbb_name_web, $this->name_web, 'varchar', 100,0,1);
		$this->fields_list->add($this->ddbb_descrip, $this->descrip, 'text', 255,0);		
		
		$this->search[0]= 'name';
		$this->search[1]= 'name_web';
				
		return $this;	 
		
	}
	
	function get_list_groups (){
		if (isset($_POST['submit_groups_search']))
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
		
		$this->num=0;
		while (!$this->result->EOF) 
		{
			//cogemos los datos del usuario
			$this->groups_list[$this->num][$this->ddbb_id_group]=$this->result->fields[$this->ddbb_id_group];
			$this->groups_list[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
			$this->groups_list[$this->num][$this->ddbb_name_web]=$this->result->fields[$this->ddbb_name_web];
			$this->groups_list[$this->num][$this->ddbb_descrip]=$this->result->fields[$this->ddbb_descrip];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
	
		$this->db->close();
		return $this->num;
	
	}
	
	function get_fields_from_search_post(){
		//Cogemos los campos principales de b�squeda
		$this->search_query=$_POST[$this->ddbb_search];
		return 0;
	}	
	
	function get_id ($name)
	{
		//Buscar los empleados de la empresa en la que se est� y coincidencia en id con los id de emps en drivers
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT id_group FROM '.$this->table_prefix.$this->table_name.' WHERE name = "\"'.$name.'"\"';
		
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		
		$this->db->close();
		return $this->result->fields['id_group'];
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
	
	function verify_user($id){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT `id_user` FROM `group_users` WHERE `id_group` = \''.$this->id_group.'\' AND `id_user` = \''.$id.'\'';
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
			$this->users_list[$this->num]['id_user']=$this->result->fields['id_user'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	}
	
	function get_permissions($id_group)
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
			
			$this->per_modules[$modulo_num]->per =  0;
			
			
		
		//	$this->per_modules[$modulo_num]->inicializar_base_datos();
		//	$result = $this->per_modules[$modulo_num]->validate_per_group_module($id_group,$this->modules->modules_list[$modulo_num]['id_module'] );
			$result = $_SESSION['permisos_group_modules'][$id_group][$this->modules->modules_list[$modulo_num]['id_module']];
		
			if($result == true)
				$this->per_modules[$modulo_num]->per =  1;
			
			$this->per_modules[$modulo_num]->num_methods = $this->modules->get_list_module_methods($this->per_modules[$modulo_num]->id_module);
			for ($metodo_num = 0; $metodo_num < $this->per_modules[$modulo_num]->num_methods; $metodo_num++) 
			{
				$this->per_modules[$modulo_num]->per_methods[$metodo_num] = new permissions_methods();
				$this->per_modules[$modulo_num]->per_methods[$metodo_num]->id_method = $this->modules->module_methods[$metodo_num]['id_method'];
				$this->per_modules[$modulo_num]->per_methods[$metodo_num]->method_name = $this->modules->module_methods[$metodo_num]['name'];	
				$this->per_modules[$modulo_num]->per_methods[$metodo_num]->method_name_web = $this->modules->module_methods[$metodo_num]['name_web'];
				
					
				if($this->per_modules[$modulo_num]->per == true)
				{	
					//$this->per_modules[$modulo_num]->per_methods[$metodo_num]->inicializar_base_datos();
					$this->per_modules[$modulo_num]->per_methods[$metodo_num]->per = 0;
	//				$result = $this->per_modules[$modulo_num]->per_methods[$metodo_num]->validate_per_group_method($id_group, $this->per_modules[$modulo_num]->per_methods[$metodo_num]->id_method);
					$result = $$_SESSION['permisos_group_methods'][$id_grupo][$this->per_modules[$modulo_num]->per_methods[$metodo_num]->id_method];
					
					
					if($result == true)
						$this->per_modules[$modulo_num]->per_methods[$metodo_num]->per =  1;
				}
				else
				{
					$this->per_modules[$modulo_num]->per_methods[$metodo_num]->per = 0;
					//print "NO MOdulo: metodo ".$this->method_name." permisos ".$this->per."............";
				}
				
			}
		}
	}
	
	function read($id){
	
		//se puede acceder a los gruposs por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_group."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_group=$id;
			$this->name=$this->result->fields[$this->ddbb_name];
			$this->name_web=$this->result->fields[$this->ddbb_name_web];
			$this->descrip=$this->result->fields[$this->ddbb_descrip];
			$this->belong=0;//Variable para los checkbox, por defecto a 0.	
			//Una vez sab�do el identificador de grupo, se puede pedir que realice su lista de permisos
			$this->get_permissions($this->id_group);
			
			$this->db->close();
			return 1;
		}
		
	
	}
	
	function add(){
		//Miramos a ver si esta definida el "submit_add" y si no lo esta, pasamos directamente a mostrar la plantilla
		if (!isset($_POST['submit_add'])){
			//Mostrar plantilla vac�a	
			//pasarle a la plantilla los modulos y grupos con sus respectivos checkbox a checked false
			//Modulos
			
			$this->checkbox=new permissions_modules;
			$modules=new modules();
			$num_modules = $modules->get_list_modules();
			for($i=0;$i<$num_modules;$i++){
				$this->checkbox->per_modules[$i]=new permissions_modules;
				$this->checkbox->per_modules[$i]->id_module=$modules->modules_list[$i]['id_module'];
				$this->checkbox->per_modules[$i]->module_name=$modules->modules_list[$i]['name_web'];
				$this->checkbox->per_modules[$i]->validate_per_module_for_group(0);
			}						
			return 0;
		}
		//en el caso de que SI este definido submit_add
		else{
						
			//Introducir los datos de post.
			$this->get_fields_from_post();
			
			$this->id_group=0;
			$this->fields_list->modify_value($this->ddbb_id_group,$this->id_group);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_name_web,$this->name_web);
			$this->fields_list->modify_value($this->ddbb_descrip,$this->descrip);

			//validamos
			$return=$this->fields_list->validate();	
			//Validacion
			//$return=validate_fields();
			
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			
			
			if (!$return){
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
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_group." = -1" ;
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
				$record[$this->ddbb_name] = $this->name;
				$record[$this->ddbb_name_web]=$this->name_web;
				$record[$this->ddbb_descrip]=$this->descrip;
				//calculamos la sql de inserci�n respecto a los atributos
				$this->sql = $this->db->GetInsertSQL($this->result, $record);
				
				//print($this->sql);
				//insertamos el registro
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				if($this->db->Insert_ID()>=0){
					//capturammos el id de la linea insertada
					$this->id_group=$this->db->Insert_ID();
					$this->add_per_modules_methods();
					//print("<pre>::".$this->id_user."::</pre>");
					//devolvemos el id de la tabla ya que todo ha ido bien
					$this->db->close();
					return $this->id_group;
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
				
				return 0;
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
			//calcula la consulta de borrado.
			$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_group." = ".$id." LIMIT 1";
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
			$this->checkbox=new permissions_modules;
			
			$modules=new modules();
			$num_modules = $modules->get_list_modules();
			
			for($i=0;$i<$num_modules;$i++){
				$this->checkbox->per_modules[$i]=new permissions_modules;
				$this->checkbox->per_modules[$i]->id_module=$modules->modules_list[$i]['id_module'];
				$this->checkbox->per_modules[$i]->module_name=$modules->modules_list[$i]['name_web'];
				$this->checkbox->per_modules[$i]->validate_per_module_for_group($this->id_group);
			}			

			//$tpl->assign('usuarios',$this->per_module_methods);
			return 0;
		}
		else{
			//Introducir los datos de post.
			$this->get_fields_from_post();
			//$this->insert_post();
			
			//Validacion
			$this->fields_list->modify_value($this->ddbb_id_group,$this->id_group);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_name_web,$this->name_web);
			$this->fields_list->modify_value($this->ddbb_descrip,$this->descrip);

			//validamos
			$return=$this->fields_list->validate();	 //Para pruebas dejar esta linea sin comentar
			
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
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_group." = \"".$this->id_group."\"" ;
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
				$record[$this->ddbb_id_group]=$this->id_group;
				$record[$this->ddbb_name]=$this->name;
				$record[$this->ddbb_name_web]=$this->name_web;
				$record[$this->ddbb_descrip]=$this->descrip;		
				//calculamos la sql de inserci�n respecto a los atributos
				$this->sql = $this->db->GetUpdateSQL($this->result, $record);
				//insertamos el registro
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				if(($this->db->Affected_Rows()==1)||($this->sql=="")){
					//capturammos el id de la linea insertada
					$this->modify_module_methods();
					$this->db->close();
					//devolvemos el id de la tabla ya que todo ha ido bien
					return $this->id_group;
				}else {
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}
			}
		}	
	}
	  
	
	
	function view ($id,$tpl)
	{
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
			
			$user = new users();
			$user->validate_per_user($_SESSION['user']);
	
			if(!$_SESSION['super'] || !$_SESSION['admin'])
			{	
				$modules = false;
			
				$i=0;
				while($i!=$user->num_modules)
				{
			
					if(($user->per_modules[$i]->per == 1)&&($user->per_modules[$i]->module_name=='modules'))
					{
					//Se comprueba si se tiene permiso para ver
						$j=0;
						while(($j<$user->per_modules[$i]->num_methods))
						{
							if(($user->per_modules[$i]->per_methods[$j]->per == 1)&&($user->per_modules[$i]->per_methods[$j]->method_name == 'view'))
							{
								$modules = true;
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
	
					$cadena=$cadena.$tabla_modulos->tabla_vacia('modules');
					$variables_modulos=$tabla_modulos->nombres_variables;
				}
				else{	
					//Se prepara el array de permisos
					$k=0;
					$permissions = null;
					
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
			
			$i=0;
			$variables = null;
			
			while($i<count($variables_modulos)){
				
				for($k=0;$k<count($variables_modulos);$k++){
					$variables[$i]=$variables_modulos[$k];
					$i++;
				}
			}

			//Se comprueba si hay permiso para borrar o modificar
			$permisos_mod_del = new permissions();
			$permisos_mod_del->get_permissions_modify_delete('groups');
			
			$tpl->assign('acciones',$permisos_mod_del->per_mod_del);
			
			$tpl->assign('variables',$variables);
			$tpl->assign('cadena',$cadena);
			
			return $tpl;
				
	}
	
	function listar($tpl){
		if (isset($_POST['submit_groups_search']))
		{
			//Se toma el n�mero de registros y se guarda en varable de sesi�n
			//que se cumpla en todos los accesos del usuario
			$_SESSION['num_regs']= $_POST['regs'];
			
		}
		$num = $this->get_list_groups();
		
		$per = new permissions();
		$per->get_permissions_list('groups');				
		$tabla_listado = new table(true);
		if ($num==0)
		{
			$cadena=''.$cadena.$tabla_listado->tabla_vacia('groups', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{	
			$cadena=''.$tabla_listado->make_tables('groups',$this->groups_list,array('Nombre',40,'Nombre Web',40),array($this->ddbb_id_group,$this->ddbb_name,$this->ddbb_name_web),$_SESSION['num_regs'],$per->permissions_module,$per->add);
			$variables=$tabla_listado->nombres_variables;
		}		
		$tpl->assign('variables',$variables);
		$tpl->assign('cadena',$cadena);		
		return $tpl;
		
		
		
	}

		function calculate_tpl($method, $tpl){
				$this->method = $method;
				switch($method){
						case 'add':	/*								
									if ($this->add() !=0){
										$this->method="list";
										$tpl=$this->listar($tpl);										
										$tpl->assign("message","&nbsp;<br>Grupo a&ntilde;adido correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
									$tpl->assign("modulos",$this->checkbox);
									break;*/
									$return=$this->add();
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
												$tpl->assign("message","&nbsp;<br>Grupo a&ntilde;adido correctamente<br>&nbsp;");
												break;
									}
									
									
									$tpl->assign("modulos",$this->checkbox);
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
										$tpl->assign("message","&nbsp;<br>Grupo modificado correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
									$tpl->assign("modulos",$this->checkbox);
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
												$tpl->assign("message","&nbsp;<br>Grupo modificado correctamente<br>&nbsp;");
												break;
									}
									$tpl->assign("objeto",$this);
									$tpl->assign("modulos",$this->checkbox);
									break;
						case 'delete':
									$this->read($_GET['id']);
									if ($this->remove($_GET['id'])==0){
										$tpl->assign("message",$this->empleados);
									}
									else{
										$this->groups_list="";
										$this->method="list";
										$tpl=$this->listar($tpl);
										$tpl->assign("message","&nbsp;<br>Grupo borrado correctamente<br>&nbsp;");
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
				$tpl->assign('plantilla','groups_'.$this->method.'.tpl');					
		
		return $tpl;
	}
	
	
	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}		
		if ($corp != ""){
			$corp='<a href="index.php?module=user_corps&method=select&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = '<a href="index.php?module=user_corps">Zona privada</a> :: '.$corp.' <a href="index.php?module=groups">Grupos</a>';
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
		$title = "Zona Privada :: $corp Grupos";
		$title=$title.$this->localice($method);		
		return $title;
	}
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Grupo";
									break;
						case 'list':
									$localice=" :: Buscar Grupos";
									break;
						case 'modify':
									$localice=" :: Modificar Grupo";
									break;
						case 'delete':
									$localice=" :: Borrar Grupo";
									break;
						case 'view':
									$localice=" :: Ver Grupo";									
									break;
						default:
									$localice=" :: Buscar Grupos";
									break;
		}
		return $localice;
	}
	
	function get_fields_from_post(){
		
		//Cogemos los campos principales
		$this->name=htmlentities($_POST[$this->ddbb_name]);
		$this->name_web=htmlentities($_POST[$this->ddbb_name_web]);
		$this->descrip=htmlentities($_POST[$this->ddbb_descrip]);
		//Cogemos los checkboxn de modulos-grupos
		$this->get_modules_methods_from_post();

		return 0;
	}	
	
	function get_modules_methods_from_post(){		
		
		$this->checkbox=new permissions_modules();
		$modules=new modules();
		$num_modules = $modules->get_list_modules();
			for($i=0;$i<$num_modules;$i++){
				$this->checkbox->per_modules[$i]=new permissions_modules;				
				$this->checkbox->per_modules[$i]->id_module=$modules->modules_list[$i]['id_module'];
				$this->checkbox->per_modules[$i]->module_name=$modules->modules_list[$i]['name_web'];
				$this->checkbox->per_modules[$i]->validate_per_module_for_group(0);
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
	
	function add_per_modules_methods(){
		$per_group_modules=new per_group_modules();
		$per_group_methods=new per_group_methods();					
			for($i=0;$i<count($this->checkbox->per_modules);$i++){																					
					if ($this->checkbox->per_modules[$i]->per==1){	
						$per_group_modules->id_module=$this->checkbox->per_modules[$i]->id_module;
						$per_group_modules->id_group=$this->id_group;
						$per_group_modules->per=1;						
						$per_group_modules->add();
						}

					for($j=0;$j<count($this->checkbox->per_modules[$i]->per_methods);$j++){
								if ($this->checkbox->per_modules[$i]->per_methods[$j]->per==1){
									$per_group_methods->id_method=$this->checkbox->per_modules[$i]->per_methods[$j]->id_method;
									$per_group_methods->id_group=$this->id_group;
									$per_group_methods->per=1;
									$per_group_methods->add();
								}								
					}
			}		
		return 0;
	}
	
	function modify_module_methods(){
		$per_group_modules=new per_group_modules();
		$per_group_methods=new per_group_methods();					
			for($i=0;$i<count($this->checkbox->per_modules);$i++){																									
				if ($this->checkbox->per_modules[$i]->per==1){		
				/***********
				En caso de que el valor del checkbox sea 1 si existe en la tabla se modifica	,
				y si no existe, se crea*/
					$result=$per_group_modules->verify_group_module($this->id_group,$this->checkbox->per_modules[$i]->id_module);
					if ($result!=0){
						$per_group_modules->read($result);
						$per_group_modules->per=1;						
						$per_group_modules->modify();							
					}									
					else{
						$per_group_modules->id_module=$this->checkbox->per_modules[$i]->id_module;
						$per_group_modules->id_group=$this->id_group;
						$per_group_modules->per=1;						
						$per_group_modules->add();
					}
					for($j=0;$j<count($this->checkbox->per_modules[$i]->per_methods);$j++){
						
						if ($this->checkbox->per_modules[$i]->per_methods[$j]->per==1){
							/***********
							En caso de que el valor del checkbox sea 1 si existe en la tabla se modifica	,
							y si no existe, se crea*/
							$result=$per_group_methods->verify_group_method($this->id_group,$this->checkbox->per_modules[$i]->per_methods[$j]->id_method);
							if ($result!=0){
								$per_group_methods->read($result);
								$per_group_methods->per=1;
								$per_group_methods->modify();
							}
							else{
								$per_group_methods->id_method=$this->checkbox->per_modules[$i]->per_methods[$j]->id_method;
								$per_group_methods->id_group=$this->id_group;
								$per_group_methods->per=1;
								$per_group_methods->add();
							}
						}								
						else{
							/*****************
							En caso de que el valor sea 0, si existe en la tabla se cambia su valor, si no no se hace
							nada
							*/
							
							$result=$per_group_methods->verify_group_method($this->id_group,$this->checkbox->per_modules[$i]->per_methods[$j]->id_method);
							if ($result!=0){
								$per_group_methods->read($result);
								$per_group_methods->per=0;
								$per_group_methods->modify();
							}
						}
					}
				}
				else{//En caso de que el permiso sea 0 si existe en la tabla, se modificara el valor, y si no existe no har� nada

					$result=$per_group_modules->verify_group_module($this->id_group,$this->checkbox->per_modules[$i]->id_module);

					if ($result!=0){

						$per_group_modules->read($result);
						
						$per_group_modules->per=0;	
						
						$per_group_modules->modify();							
					}	
					//Aqui los checkbox de metodos al no tener permiso en un modulo, no pueden ser valores iguales a 1, ya qu eno puede tener permiso.
					for($j=0;$j<count($this->checkbox->per_modules[$i]->per_methods);$j++){
						$result=$per_group_methods->verify_group_method($this->id_group,$this->checkbox->per_modules[$i]->per_methods[$j]->id_method);
						//En caso de que exista el valor se modifica y si no, no se hace nada.
						if ($result!=0){
							$per_group_methods->read($result);
							$per_group_methods->per=0;
							$per_group_methods->modify();
						}									
					}								
				}					
		}		
		return 0;
	}
	
	function make_remove($id){
		//modificamos todos aquellos registros en los que hay un id_user;
		for ($i=0;$i<count($this->table_names_modify);$i++){
			$this->modify_all_id_group($id,$this->table_names_modify[$i]);
		}
		//borramos todos aquellos registros en los que hay un id_user;		
		for ($i=0;$i<count($this->table_names_delete);$i++){
			$this->delete_all_id_group($id,$this->table_names_delete[$i]);
		}
	}
	
	function modify_all_id_group($id,$table){
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="UPDATE ".$table. " SET ".$this->var_name." = 0 WHERE ".$this->var_name." = ".$id;
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
	
	function delete_all_id_group($id,$table){
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.

			$this->sql="DELETE FROM ".$table. " WHERE ".$this->var_name." = ".$id;
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
	
	function admin ($id){
	
	}
}
?>