<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");

class cat_clients{
//internal vars
	var $id_cat_client;
	var $name;
	var $descrip;
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
	var $table_name='cat_clients';
	var $ddbb_id_cat_client='id_cat_client';
  	var $ddbb_name='name';
  	var $ddbb_descrip='descrip';
	var $ddbb_search='search';
	var $db;
	var $result;  	
//variables complementarias	
  	var $cat_clients_list;
  	var $num;
  	var $fields_list;
	var $table_names_modify = array("clients");
	var $table_names_delete;
	//var $mensaje;


  	//constructor
	function cat_clients(){
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
		$this->fields_list->add($this->ddbb_id_cat_client, $this->id_cat_client, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_name, $this->name, 'varchar', 50,0,1);
		$this->fields_list->add($this->ddbb_descrip, $this->descrip, 'varchar', 255,0);
		
		$this->search[0]= 'name';
		$this->search[1]= 'descrip';

		
		return $this->get_list_cat_clients();	 
		
	}
	
	function get_list_cat_clients (){
		if (isset($_POST['submit_cat_clients_search']))
		{
			//Obtener datos del formulario de búsqueda
			$this->get_fields_from_search_post();
			
			//Generar consulta
			if($this->search_query[0]=='\\')
			{	
				//Guardar consulta para no modificar la variable 
				//que se mande denuevo al formulario
				$query =  $this->search_query;
				
				//Se va creando la nueva query que se mandará mas tarde 
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
		//Buscar los empleados de la empresa en la que se está y coincidencia en id con los id de emps en drivers
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
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		
		//cogemos los datos del usuario
		$this->num=0;
		while (!$this->result->EOF) 
		{
			$this->cat_clients_list[$this->num][$this->ddbb_id_cat_client]=$this->result->fields[$this->ddbb_id_cat_client];
			$this->cat_clients_list[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
			$this->cat_clients_list[$this->num][$this->ddbb_descrip]=$this->result->fields[$this->ddbb_descrip];
					
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
	
	
		
		$this->db->close();
		
		return $this->num;
	}
	
	function get_fields_from_search_post(){
		//Cogemos los campos principales de búsqueda
		$this->search_query=$_POST[$this->ddbb_search];
		return 0;
	}
	
	function read($id){
	
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_cat_client."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_cat_client=$id;
			$this->name=$this->result->fields[$this->ddbb_name];
			$this->descrip=$this->result->fields[$this->ddbb_descrip];
			
			$this->db->close();

			return 1;
		}
		
	
	}
	
	function add()
	{
		
		
		//Miramos a ver si esta definida el "submit_add" y si no lo esta, pasamos directamente a mostrar la plantilla
		if (!isset($_POST['submit_add']))
		{
			//Mostrar plantilla vacía	
			return 0;
		}
		//en el caso de que SI este definido submit_add
		else
		{
				//Entramos porque hemos introducido datos y aún no hemos preguntado por la foto
				//Introducir los datos de post.
				$this->get_fields_from_post();	
				$this->id_cat_client=0;
				$this->fields_list->modify_value($this->ddbb_id_cat_client,$this->id_cat_client);
				$this->fields_list->modify_value($this->ddbb_name,$this->name);
				$this->fields_list->modify_value($this->ddbb_descrip,$this->descrip);
				//validamos
				$return=$this->fields_list->validate();	
				//Validacion
				//$return=validate_fields();
				
				//En caso de que la validacion haya sido fallida se muestra la plantilla
				//con los campos erroneos marcados con un *
			
				
				if (!$return)
				{
					//Mostrar plantilla con datos erroneos
					return -1;
				}
				else
				{
					//Si todo es correcto si meten los datos
					
					//Se copia el fichero de la foto elegida por el usuario en el servidor
					
					
					//Se añaden los campos a la base de datos
					$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
					//crea una nueva conexin con una bbdd (mysql)
					$this->db = NewADOConnection($this->db_type);
					//le dice que no salgan los errores de conexin de la ddbb por pantalla
					$this->db->debug=false;
					//realiza una conexin permanente con la bbdd
					$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
					//mete la consulta para coger los campos de la bbdd
					$this->sql = "SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_cat_client." = -1" ;
					//la ejecuta y guarda los resultados
					$this->result = $this->db->Execute($this->sql);
					//si falla 
					if ($this->result === false)
					{
						$this->error=1;
						$this->db->close();
						return 0;
					}
					//rellenamos el array con los datos de los atributos de la clase
					$record = array();
					$record[$this->ddbb_name] = $this->name;
					$record[$this->ddbb_descrip]=$this->descrip;
					
					//calculamos la sql de insercin respecto a los atributos
					$this->sql = $this->db->GetInsertSQL($this->result, $record);
					//print($this->sql);
					//insertamos el registro
					$this->db->Execute($this->sql);
					//si se ha insertado una fila
					if($this->db->Insert_ID()>=0)
					{
						//capturammos el id de la linea insertada
						$this->id_cat_client=$this->db->Insert_ID();
						//devolvemos el id de la tabla ya que todo ha ido bien
						$this->db->close();
					}
					return $this->id_cat_client;
			
				}
		}
	}
	
	function get_fields_from_post(){
		//Cogemos los campos principales	
		$this->name=htmlentities($_POST[$this->ddbb_name]);
		$this->descrip=htmlentities($_POST[$this->ddbb_descrip]);
		return 0;
	}
	
			
	function remove($id){
		if (!isset($_POST["submit_delete"]))
		{				
				return 0;
		}
		else
		{
			//Se borra el vehiculo de la bbdd
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexión con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexión de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexión permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_cat_client." = ".$id." LIMIT 1";
			//la ejecuta y guarda los resultados		
			$this->result = $this->db->Execute($this->sql);
			//si falla 
			if ($this->db->Affected_Rows() == 0)
			{				
				$this->error=1;
				$this->db->close();
				return 0;
			}
			else
			{
				$this->make_remove($id);
				$this->error=0;
				$this->db->close();
				return 1;	
			}
		}		
	}
	
	function make_remove($id){
		//modificamos todos aquellos registros en los que hay un id_user;
		for ($i=0;$i<count($this->table_names_modify);$i++){
			$this->modify_all_id_cat_client($id,$this->table_names_modify[$i]);
		}
		//borramos todos aquellos registros en los que hay un id_user;		
		for ($i=0;$i<count($this->table_names_delete);$i++){
			$this->delete_all_id_cat_client($id,$this->table_names_delete[$i]);
		}
	
	}
	
	function modify_all_id_cat_client($id,$table){
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexión con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexión de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexión permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="UPDATE ".$table. " SET id_vehicle = 0 WHERE id_cat_client = ".$id;
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
	
	function modify(){
		if (!isset($_POST['submit_modify'])){
		
			
			return 0;
		}
		else{
			//Introducir los datos de post.
			$this->get_fields_from_post();
			//$this->insert_post();
			$this->fields_list->modify_value($this->ddbb_id_cat_client,$this->id_cat_client);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
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
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexin con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexin de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexin permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_cat_client." = \"".$this->id_cat_client."\"" ;
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
				$record[$this->ddbb_id_cat_client]=$this->id_cat_client;
				$record[$this->ddbb_name]=$this->name;
				$record[$this->ddbb_descrip]=$this->descrip;
				//calculamos la sql de insercin respecto a los atributos
				$this->sql = $this->db->GetUpdateSQL($this->result, $record);
				//insertamos el registro				
				$this->db->Execute($this->sql);
				//si se ha insertado una fila

				if(($this->db->Affected_Rows()==1)||($this->sql=="")){
					//capturammos el id de la linea insertada
				
				//	$this->modify_group_users();
				//	$this->modify_module_methods();

					$this->db->close();
					//devolvemos el id de la tabla ya que todo ha ido bien
					return $this->id_cat_client;
				}else {
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}
			}
		}	
	}
	
	function view ($id,$tpl){
	/*
		Cosas que faltan por hacer:
			De forma general, mirar los permisos del usuario que vaya a acceder aqui, para saber si tiene permisos de borrar editar ver etc...
			Averiguar como pasar el numero de registros, si va a ser a grupos a grupos, si va a ser a modulos, a modulos
			Order By (y mantener la búsqueda en el caso de que hubiera hecha una y averiguar la "pestaña" a la que hace referencia)
			Busquedas
	*/
			$cadena='';			
			// Leemos el usuario y se lo pasamos a la plantilla
			$this->read($id);
			$tpl->assign('objeto',$this);
				
			
			
			
			
			//Se comprueba si hay permiso para borrar o modificar
			$permisos_mod_del = new permissions();
			$permisos_mod_del->get_permissions_modify_delete('cat_clients');
			
			$tpl->assign('acciones',$permisos_mod_del->per_mod_del);

			$tpl->assign('variables',$variables);
			$tpl->assign('cadena',$cadena);
			//			
			return $tpl;
				
	}
	
	function listar($tpl){
		$num = $this->get_list_cat_clients();
		$tabla_listado = new table(true);			
		$per = new permissions();
		$per->get_permissions_list('cat_clients');
		if ($num==0)
		{
			$cadena=''.$cadena.$tabla_listado->tabla_vacia('cat_clients', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{
			$cadena=''.$tabla_listado->make_tables('cat_clients',$this->cat_clients_list,array('Nombre',80),array($this->ddbb_id_cat_client,$this->ddbb_name),10,$per->permissions_module,$per->add);
			$variables=$tabla_listado->nombres_variables;
		}		
		$tpl->assign('variables',$variables);
		$tpl->assign('cadena',$cadena);		
		return $tpl;
	}
	
	
	function calculate_tpl($method, $tpl){
		$this->method=$method;
				switch($method){
						case 'add':	
									$return=$this->add();
									switch ($return){										
										case 0: //por defecto												
												break;
										case -1: //Errores al intentar añadir datos
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
												}												
												break;
										default: //Si se ha añadido
												$this->method="list";
												$tpl=$this->listar($tpl);										
												$tpl->assign("message","&nbsp;<br>Categor&iacute;a de cliente a&ntilde;adida correctamente<br>&nbsp;");
												break;
									}
									$tpl->assign("objeto",$this);
									break;
						case 'list':
									$tpl=$this->listar($tpl);
									$tpl->assign("objeto",$this);
									break;
						case 'modify':
									/*
									$this->read($_GET['id']);
									if ($this->modify() !=0){
										$this->method="list";
										$tpl=$this->listar($tpl);										
										$tpl->assign("message","&nbsp;<br>Categor&iacute;a de cliente modificada correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);							
									break;*/
									$this->read($_GET['id']);									
									$return=$this->modify();
									switch ($return){										
										case 0: //por defecto												
												break;
										case -1: //Errores al intentar añadir datos
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
												}												
												break;
										default: //Si se ha añadido
												$this->method="list";
												$tpl=$this->listar($tpl);										
												$tpl->assign("message","&nbsp;<br>Categor&iacute;a de cliente modificada correctamente<br>&nbsp;");
												break;
									}
									$tpl->assign("objeto",$this);
									break;
						case 'delete':
									$this->read($_GET['id']);
									if ($this->remove($_GET['id'])==0){
										//$tpl->assign("message",$this->emps);
									}
									else{
										$this->cat_clients_list = "";
										$this->method="list";
										$tpl=$this->listar($tpl);
										$tpl->assign("message","&nbsp;<br>Categor&iacute;a de cliente borrada correctamente<br>&nbsp;");
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
									break;
					}
				$tpl->assign('plantilla','cat_clients_'.$this->method.'.tpl');					
		
		return $tpl;
	}

	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}		
	if ($corp != ""){
			$corp='<a href="index.php?module=user_corps&method=select&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = '<a>Zona privada</a> :: '.$corp.' <a href="index.php?module=cat_clients">Categor&iacute;as de clientes</a>';
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
		$title = "Zona Privada :: $corp Categor&iacute;as de clientes";
		$title=$title.$this->localice($method);		
		return $title;
	}		
	
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Categor&iacute;as de clientes";
									break;
						case 'list':
									$localice=" :: Buscar Categor&iacute;as de clientes";
									break;
						case 'modify':
									$localice=" :: Modificar Categor&iacute;as de clientes";
									break;
						case 'delete':
									$localice=" :: Borrar Categor&iacute;as de clientes";
									break;
						case 'view':
									$localice=" :: Ver Categor&iacute;as de clientes";	
									break;
						default:
									$localice=" :: Buscar Categor&iacute;as de clientes";
									break;
		}
		return $localice;
	}
	
	
}
?>