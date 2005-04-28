<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd Emp
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");

class contacts{
//internal vars
	var $id_contact;
	var $id_client;
	var $name;
	var $last_name;
	var $last_name2;
	var $birthday="00-00-0000";
	var $phone;
	var $mobile_phone;
	var $fax;
	var $mail;
	var $address;
	var $city;
	var $state;
	var $postal_code;
	var $country;
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
	var $table_name='contacts';
	var $ddbb_id_contact = 'id_contact';
	var $ddbb_id_client ='id_client';
	var $ddbb_name= 'name';
	var $ddbb_last_name='last_name';
	var $ddbb_last_name2='last_name2';
	var $ddbb_birthday='birthday';
	var $ddbb_phone='phone';
	var $ddbb_mobile_phone='mobile_phone';
	var $ddbb_fax='fax';
	var $ddbb_mail='mail';
	var $ddbb_address='address';
	var $ddbb_city='city';
	var $ddbb_state='state';
	var $ddbb_postal_code='postal_code';
	var $ddbb_country='country';
	var $ddbb_search='search';
	var $db;
	var $result; 
	var $result1; 
	var $sql;
		
//variables complementarias	
  	var $contacts_list;
  	var $num;
  	var $fields_list;
  	var $error;
	var $clients_list;
	var $num_corps;
	var $contacts_client_list;
	var $method;
	var $category;
	var $table_names_modify=array();
	var $table_names_delete=array();
  	//constructor
	function contacts(){
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
		$this->fields_list->add($this->ddbb_id_contact, $this->id_contact, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_id_client, $this->id_client, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_name, $this->name, 'varchar', 20,0,1);
		$this->fields_list->add($this->ddbb_last_name, $this->last_name, 'varchar', 20,0);
		$this->fields_list->add($this->ddbb_last_name2, $this->last_name2, 'varchar', 20,0 );
		$this->fields_list->add($this->ddbb_birthday, $this->birthday, 'date', 0,0);
		$this->fields_list->add($this->ddbb_phone, $this->phone, 'varchar', 15,0);		
		$this->fields_list->add($this->ddbb_mobile_phone, $this->mobile_phone, 'varchar', 15,0 );
		$this->fields_list->add($this->ddbb_fax, $this->fax, 'varchar', 15,0 );
		$this->fields_list->add($this->ddbb_mail, $this->mail, 'varchar', 50,0 );
		$this->fields_list->add($this->ddbb_address, $this->address, 'varchar', 255,0 );
		$this->fields_list->add($this->ddbb_city, $this->city, 'varchar', 50,0 );
		$this->fields_list->add($this->ddbb_state, $this->state, 'varchar', 50,0 );
		$this->fields_list->add($this->ddbb_postal_code, $this->postal_code, 'varchar', 50,0 );
		$this->fields_list->add($this->ddbb_country, $this->country, 'varchar', 50,0 );
		
		
		$this->search[0]= 'name';
		$this->search[1]= 'last_name';
		$this->search[2]= 'last_name2';
		
		//print_r($this);
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
/*		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name;
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
		}  
		$this->db->close();
*/		
		/*******************************/
		
		return $this/*->get_list_contacts($_SESSION['ident_corp'])*/;	 
		
	}
	
	function get_list_contacts ($id_client)
	{
		if (isset($_POST['submit_contacts_search']))
		{
			//Obtener datos del formulario de búsqueda
			$this->get_fields_from_search_post();
						
			//Crear query
			$my_search = new search();
			$query = $my_search->get_query($this->search_query, FALSE, $this->search, $this->fields_list);
		}	
		//Buscar los contactleados de la contactresa en la que se está y coincidencia en id con los id de contacts en drivers
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		if($query != "")
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE (".$query.") AND id_client = ".$id_client;
		else
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE id_client = ".$id_client;
			
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		$this->num=0;
		while (!$this->result->EOF) {
			//cogemos los datos del contactleado
			$this->contacts_list[$this->num][$this->ddbb_id_contact]=$this->result->fields[$this->ddbb_id_contact];
			$this->contacts_list[$this->num][$this->ddbb_id_client]=$this->result->fields[$this->ddbb_id_client];
			$this->contacts_list[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
			$this->contacts_list[$this->num][$this->ddbb_last_name]=$this->result->fields[$this->ddbb_last_name];
			$this->contacts_list[$this->num][$this->ddbb_last_name2]=$this->result->fields[$this->ddbb_last_name2];
			$this->contacts_list[$this->num][$this->ddbb_birthday]=$this->result->fields[$this->ddbb_birthday];
			$this->contacts_list[$this->num][$this->ddbb_phone]=$this->result->fields[$this->ddbb_phone];
			$this->contacts_list[$this->num][$this->ddbb_mobile_phone]=$this->result->fields[$this->ddbb_mobile_phone];
			$this->contacts_list[$this->num][$this->ddbb_fax]=$this->result->fields[$this->ddbb_fax];
			$this->contacts_list[$this->num][$this->ddbb_mail]=$this->result->fields[$this->ddbb_mail];
			$this->contacts_list[$this->num][$this->ddbb_address]=$this->result->fields[$this->ddbb_address];
			$this->contacts_list[$this->num][$this->ddbb_city]=$this->result->fields[$this->ddbb_city];
			$this->contacts_list[$this->num][$this->ddbb_state]=$this->result->fields[$this->ddbb_state];
			$this->contacts_list[$this->num][$this->ddbb_postal_code]=$this->result->fields[$this->ddbb_postal_code];
			$this->contacts_list[$this->num][$this->ddbb_country]=$this->result->fields[$this->ddbb_country];

			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
	
		$this->db->close();
		return $this->num;	
	}
	
	function get_fields_from_search_post(){
		//Cogemos los campos principales de búsqueda
		$this->client=$_POST['client'];		
		$_SESSION['id_client']=$this->client;
		$this->search_query=$_POST[$this->ddbb_search];
		return 0;
	}	
	

	
	function add(){
		
		//Miramos a ver si esta definida el "submit_add" y si no lo esta, pasamos directamente a mostrar la plantilla
		if (!isset($_POST['submit_add'])){
			//Mostrar plantilla vacía	
			
			//pasarle a la plantilla los modulos y grupos con sus respectivos checkbox a checked false
			//Modulos
			
			return 0;
		}
		//en el caso de que SI este definido submit_add
		else{
						
			//Introducir los datos de post.
			$this->get_fields_from_post();	
						
			//Validacion
			//$return=validate_fields();
			$this->id_contact=0;
			$this->fields_list->modify_value($this->ddbb_id_contact,$this->id_contact);			
			$this->fields_list->modify_value($this->ddbb_id_client,$this->id_client);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_last_name,$this->last_name);
			$this->fields_list->modify_value($this->ddbb_last_name2,$this->last_name2);
			$this->fields_list->modify_value($this->ddbb_birthday,$this->birthday);
			$this->fields_list->modify_value($this->ddbb_phone,$this->phone);
			$this->fields_list->modify_value($this->ddbb_mobile_phone,$this->mobile_phone);
			$this->fields_list->modify_value($this->ddbb_fax,$this->fax);
			$this->fields_list->modify_value($this->ddbb_mail,$this->mail);
			$this->fields_list->modify_value($this->ddbb_address,$this->address);
			$this->fields_list->modify_value($this->ddbb_city,$this->city);
			$this->fields_list->modify_value($this->ddbb_state,$this->state);
			$this->fields_list->modify_value($this->ddbb_country,$this->country);
			$this->fields_list->modify_value($this->ddbb_postal_code,$this->postal_code);
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
				$this->birthday=$this->fields_list->change_date($this->birthday,"en");
				//Si todo es correcto si meten los datos
				
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexin con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexin de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexin permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_contact." = -1" ;
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
				$record[$this->ddbb_name]=$this->name;
				$record[$this->ddbb_last_name]=$this->last_name;
				$record[$this->ddbb_last_name2]=$this->last_name2;
				$record[$this->ddbb_birthday]=$this->birthday;
				$record[$this->ddbb_address]=$this->address;
				$record[$this->ddbb_id_client]=$this->id_client;
				$record[$this->ddbb_city]=$this->city;
				$record[$this->ddbb_state]=$this->state;
				$record[$this->ddbb_country]=$this->country;
				$record[$this->ddbb_postal_code]=$this->postal_code;
				$record[$this->ddbb_phone]=$this->phone;
				$record[$this->ddbb_mobile_phone]=$this->mobile_phone;
				$record[$this->ddbb_fax]=$this->fax;
				$record[$this->ddbb_mail]=$this->mail;				
				
				
				
				//calculamos la sql de insercin respecto a los atributos
				$this->sql = $this->db->GetInsertSQL($this->result, $record);
				//print($this->sql);
				//insertamos el registro
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				if($this->db->Insert_ID()>=0){
					//Cogemos el id del contactleado insertado.
					
					$this->id_contact=$this->db->Insert_ID();					
					//capturammos el id de la linea insertada
					//Introducimos categorias;
				
					//print("<pre>::".$this->id_user."::</pre>");
					//devolvemos el id de la tabla ya que todo ha ido bien
					$this->db->close();
					
					//Se hace nueva imagen de las tablas de permiso para usuarios
				/*	$permisos = new permissions();
					$_SESSION['permisos_user_modules'] = $permisos->get_per_user_modules();
					$_SESSION['permisos_user_methods'] = $permisos->get_per_user_methods();
					*/
					return $this->id_contact;
				}else {
					
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}
			}
		}
	}
	/*
	function add_category($id){
		$category=new rel_contacts_cats();
		$category->id_contact=$id;
		$category->id_cat_contact=$this->category;
		return $category->add();
	}
	
	function add_holyday($id){
		$holyday=new holydays();
		$holyday->id_contact=$id;
		$holyday->ill=2;
		$holyday->come=$this->come;
		$holyday->contacts_modify = true;
		return $holyday->add();
	}*/
	
	function modify(){
		
		
		if (!isset($_POST['submit_modify'])){
			
			
			return 0;
		}
		else{
			//Introducir los datos de post.

			$this->get_fields_from_post();	
						
			//Validacion
			//$return=validate_fields();
			$this->fields_list->modify_value($this->ddbb_id_contact,$this->id_contact);
			$this->fields_list->modify_value($this->ddbb_id_client,$this->id_client);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_last_name,$this->last_name);
			$this->fields_list->modify_value($this->ddbb_last_name2,$this->last_name2);
			$this->fields_list->modify_value($this->ddbb_birthday,$this->birthday);
			$this->fields_list->modify_value($this->ddbb_phone,$this->phone);
			$this->fields_list->modify_value($this->ddbb_mobile_phone,$this->mobile_phone);
			$this->fields_list->modify_value($this->ddbb_fax,$this->fax);
			$this->fields_list->modify_value($this->ddbb_mail,$this->mail);
			$this->fields_list->modify_value($this->ddbb_address,$this->address);
			$this->fields_list->modify_value($this->ddbb_city,$this->city);
			$this->fields_list->modify_value($this->ddbb_state,$this->state);
			$this->fields_list->modify_value($this->ddbb_country,$this->country);
			$this->fields_list->modify_value($this->ddbb_postal_code,$this->postal_code);
			$return=$this->fields_list->validate();	
			
			//Validamos la fecha de alta.
			
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			
			
			if (!$return){
				//Mostrar plantilla con datos erroneos
				return -1;
			}
			else{
				$this->birthday=$this->fields_list->change_date($this->birthday,"en");
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexin con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexin de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexin permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_contact." = \"".$this->id_contact."\"" ;
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
				$record[$this->ddbb_id_contact]=$this->id_contact;
				$record[$this->ddbb_name]=$this->name;
				$record[$this->ddbb_last_name]=$this->last_name;
				$record[$this->ddbb_last_name2]=$this->last_name2;
				$record[$this->ddbb_birthday]=$this->birthday;
				$record[$this->ddbb_address]=$this->address;
				$record[$this->ddbb_id_client]=$this->id_client;
				$record[$this->ddbb_city]=$this->city;
				$record[$this->ddbb_state]=$this->state;
				$record[$this->ddbb_country]=$this->country;
				$record[$this->ddbb_postal_code]=$this->postal_code;
				$record[$this->ddbb_phone]=$this->phone;
				$record[$this->ddbb_mobile_phone]=$this->mobile_phone;
				$record[$this->ddbb_fax]=$this->fax;
				$record[$this->ddbb_mail]=$this->mail;							
				//calculamos la sql de insercin respecto a los atributos
				$this->sql = $this->db->GetUpdateSQL($this->result, $record);
				//insertamos el registro
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				$Affected_Rows=$this->db->Affected_Rows();
				/*Al hacer la modificacion de categorias y vacaciones antes del siguiente "if"
				 se debe de guardar en una variable el contenido de las filas afectadas y hacer
				 la condicion del if con esa variable ya que al hacer las modificaciones ese valor varía.
				*/
				
				
			
				if(($Affected_Rows==1)||($this->sql=="")){
					//capturammos el id de la linea insertada
					$this->db->close();
					
					//Modificar variable de sesión con tabla de permisos
/*					$permisos = new permissions();
					$_SESSION['permisos_user_modules'] = $permisos->get_per_user_modules();
					$_SESSION['permisos_user_methods'] = $permisos->get_per_user_methods();
		*/
					//devolvemos el id de la tabla ya que todo ha ido bien
					return $this->id_contact;
				}else {
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}
			}
		}	
	}
/*	
	function modify_category($id){
		$category=new rel_contacts_cats();
		$return=$category->read($category->get_rel_contact_cat($this->id_contact));
		if ($return==0){
			return $this->add_category($id);
		}
		$category->id_contact=$id;
		$category->id_cat_contact=$this->category;
		return $category->modify();
	}
	
	function modify_holyday($id){
		$holyday=new holydays();
		$return=$holyday->get_come($id);
		
		if ($return==0){
			return $this->add_holyday($id);
		}
		$holyday->read($_POST["id_holy"]);
		$holyday->id_contact=$id;
		$holyday->ill=2;
		$holyday->come=$this->come;
		return $holyday->modify();
	}
	*/
	function remove($id){
			if (!isset($_POST["submit_delete"])){
				
									
				return 0;
			}
			else{
			//HAY QUE VERIFICAR EN LAS COMPROBACIONES QUE NO SE ELIMINE EL MISMO USUARIO
			//QUE ESTA CONECTADO EN ESTE MOMENTO.
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexión con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexión de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexión permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_contact." = ".$id;
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
	
	function make_remove($id){
		//modificamos todos aquellos registros en los que hay un id_user;
		for ($i=0;$i<count($this->table_names_modify);$i++){
			$this->modify_all_id_contact($id,$this->table_names_modify[$i]);
		}
		//borramos todos aquellos registros en los que hay un id_user;		
		for ($i=0;$i<count($this->table_names_delete);$i++){
			$this->delete_all_id_contact($id,$this->table_names_delete[$i]);
		}
	}
	
	function modify_all_id_contact($id,$table){
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexión con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexión de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexión permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="UPDATE ".$table. " SET id_contact = 0 WHERE id_contact = ".$id;
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
	
	function delete_all_id_contact($id,$table){
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexión con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexión de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexión permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.

			$this->sql="DELETE FROM ".$table. " WHERE id_contact = ".$id;
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
	
	function belong_client($id_client){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM `contacts` WHERE `id_client` = \''.$id_client.'\'';
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
			
			$this->contacts_corp_list[$this->num]['id_contact']=$this->result->fields['id_contact'];
			$this->contacts_corp_list[$this->num]['name']=$this->result->fields['name'];
			$this->contacts_corp_list[$this->num]['last_name']=$this->result->fields['last_name'];
			$this->contacts_corp_list[$this->num]['last_name2']=$this->result->fields['last_name2'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->contacts_client_list;
		
	}
	
	/*
	function get_user_corps($id_user)
	{
	
		//Se pasa como parámetro el login del usuario que se conectó a la sesión, esto se hace desde index.php
		

		//coge las variables globales del fichero config.inc.php
		global $DDBB_TYPE, $DDBB_NAME, $IP_DDBB, $DDBB_USER, $DDBB_PASS, $DDBB_PORT, $TABLE_PREFIX;
		$this->db_type=$DDBB_TYPE;
		$this->db_name=$DDBB_NAME;
		$this->db_ip=$IP_DDBB;
		$this->db_user=$DDBB_USER;
		$this->db_passwd=$DDBB_PASS;
		$this->db_port=$DDBB_PORT;
		$this->table_prefix=$TABLE_PREFIX;
		//A partir de este id, se busca dentro de contacts todos los contactleados que contenga el id_user y sus correspondientes id_client
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT `id_client` FROM `contacts` WHERE `id_user` =".$id_user;
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		//$this->corps_list[0][$this->ddbb_id_user] = $id_user;
		
		//Con el id_client se podrá obtener el nombre de cada contactresa en la trabaja id_user
		$this->num_corps=0;
		$i = 0;
		while (!$this->result->EOF) 
		{
			$id_client = $this->result->fields['id_client'];

			$this->sql="SELECT `name` FROM `corps` WHERE `id_client` =".$id_client;
			//la ejecuta y guarda los resultados
			$this->result1 = $this->db->Execute($this->sql);
			//si falla 
			if ($this->result1 === false)
			{
				$this->error=1;
				$this->db->close();
	
				return 0;
			}  
/*		
			//Si hay más de un contactleado con mismo login en la contactresa evitamos que salga más de una vez, 
			//para ello por cada contactresa nueva se incrementa en uno su contador
			$tcontact[$this->num_corps][$this->ddbb_id_client] = $id_client;
			$tcontact[$this->num_corps]['name'] = $this->result1->fields['name'];
		
			$contactresas[$id_client]['cont']++;

			
			if(($contactresas[$id_client]['cont'] == 1))
			{
				//Si aparece y cont es 1 entonces es la primera vez que aparece
				$this->corps_list[$i][$this->ddbb_id_client] = $tcontact[$this->num_corps][$this->ddbb_id_client];
				$this->corps_list[$i]['name'] = $tcontact[$this->num_corps]['name'];
				$i++;
				
			}
*/
				
	/*		$this->corps_list[$this->num_corps][$this->ddbb_id_client] = $id_client;
			$this->corps_list[$this->num_corps]['name'] = $this->result1->fields['name'];

			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num_corps++;
		}
	
		$this->db->close();
		//$this->num_corps = $i;
		
		return $this->num_corps;
	}*/
	/*
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
	*/
	function read($id){

		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM `contacts` WHERE `id_contact`= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false)
		{
			$error=1;
			return 0;
			$this->db->close();
		}
		else
		{
			$this->id_contact = $id;
			$this->id_client = $this->result->fields[$this->ddbb_id_client];
			$this->name = $this->result->fields[$this->ddbb_name];
			$this->last_name = $this->result->fields[$this->ddbb_last_name];
			$this->last_name2 = $this->result->fields[$this->ddbb_last_name2];
			$this->birthday = $this->result->fields[$this->ddbb_birthday];
			$this->phone = $this->result->fields[$this->ddbb_phone];
			$this->mobile_phone = $this->result->fields[$this->ddbb_mobile_phone];
			$this->fax = $this->result->fields[$this->ddbb_fax];
			$this->mail = $this->result->fields[$this->ddbb_mail];
			$this->address = $this->result->fields[$this->ddbb_address];
			$this->city = $this->result->fields[$this->ddbb_city];
			$this->state = $this->result->fields[$this->ddbb_state];
			$this->postal_code = $this->result->fields[$this->ddbb_postal_code];
			$this->country = $this->result->fields[$this->ddbb_country];
			
			$this->db->close();
				
			return 1;
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
			// Leemos el contactleado y se lo pasamos a la plantilla
			$this->read($id);
			$tpl->assign('objeto',$this);

		
			$this->birthday=$this->fields_list->change_date($this->birthday,"es");			
			
			//Se comprueba si hay permiso para borrar o modificar
			$permisos_mod_del = new permissions();
			$permisos_mod_del->get_permissions_modify_delete('contacts');
			$tpl->assign('acciones',$permisos_mod_del->per_mod_del);
					
			
			if(!$_SESSION['super'] || !$_SESSION['admin'])
			{	
				
				$holydays = false;
			
				$i=0;
				while($i!=$this->num_modules)
				{
			
					if(($this->per_modules[$i]->per == 1)&&($this->per_modules[$i]->module_name=='holydays'))
					{
					//Se comprueba si se tiene permiso para ver
						$j=0;
						while(($j<$this->per_modules[$i]->num_methods))
						{
							if(($this->per_modules[$i]->per_methods[$j]->per == 1)&&($this->per_modules[$i]->per_methods[$j]->method_name == 'view'))
							{
								$holydays = true;
							}
							$j++;
						}
					}
					
					
					$i++;
					
				}

			}
		
			
		
			$mensaje = null;
			$mensaje[0]['id_mensaje'] = 1;
			$mensaje[0]['mes'] = "Sentimos informarle de que no tiene permiso para acceder a esta información";
			
		

			
			$tpl->assign('variables',$variables);
			$tpl->assign('cadena',$cadena);
						
			return $tpl;
				
	}
	
	

	function listar($tpl)
	{
		if (isset($_POST['client'])){
			$this->client=$_POST['client'];		
			$_SESSION['id_client']=$this->client;
		}
		if(!isset($_SESSION['id_client'])){
			$this->client=0;
		}
		else{
			$this->client=$_SESSION['id_client'];
		}
		$num = $this->get_list_contacts($this->client);
	
		$tabla_listado = new table(true);
		$per = new permissions();
		$per->get_permissions_list('contacts');
		if ($num==0)
		{
			if ($this->client==0){
				$per->add=false;				
			}
			$cadena=''.$cadena.$tabla_listado->tabla_vacia('contacts', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{			
			$cadena=''.$tabla_listado->make_tables('contacts',$this->contacts_list,array('Nombre',30,'Primer Apellido',20,'Segundo Apellido',20),array($this->ddbb_id_contact, $this->ddbb_name,$this->ddbb_last_name,$this->ddbb_last_name2),10,$per->permissions_module,$per->add);
			$variables=$tabla_listado->nombres_variables;	
		}				
		$tpl->assign('variables',$variables);
		$tpl->assign('cadena',$cadena);		
		return $tpl;
	}
	
	
	function calculate_tpl($method, $tpl)
	{	
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
										$clients=new clients();
										$tpl=$this->listar($tpl);
										$clients->get_list_clients($_SESSION['ident_corp']);
										$tpl->assign("clients",$clients->clients_list);	;
										$tpl->assign("message","&nbsp;<br>Contacto a&ntilde;adido correctamente<br>&nbsp;");
										break;
							}							
							$tpl->assign("objeto",$this);									
							break;
							
				case 'list':
							$clients=new clients();
							$tpl=$this->listar($tpl);
							$clients->get_list_clients($_SESSION['ident_corp']);
							$tpl->assign("clients",$clients->clients_list);	
							$tpl->assign("objeto",$this);	
							break;
				case 'modify':
							
							
							$this->read($_GET['id']);
							$return=$this->modify();
							switch ($return){										
								case 0: //por defecto																					
										$this->birthday=$this->fields_list->change_date($this->birthday,"es");
										break;
								case -1: //Errores al intentar añadir datos
										for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
											$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
										}									
										break;
								default: //Si se ha añadido
										$this->method="list";
										$clients=new clients();
										$tpl=$this->listar($tpl);
										$clients->get_list_clients($_SESSION['ident_corp']);
										$tpl->assign("clients",$clients->clients_list);	
										$tpl->assign("objeto",$this);
										$tpl->assign("message","&nbsp;<br>Contacto modificado correctamente<br>&nbsp;");
										break;
							}
					
							$tpl->assign("objeto",$this);						
							break;
				case 'delete':
							$this->read($_GET['id']);
							if ($this->remove($_GET['id'])==0){
								$tpl->assign("message",$this->contactos);
							}
							else{
								$this->contacts_list="";
								$this->method="list";
								$clients=new clients();
								$tpl=$this->listar($tpl);
								$clients->get_list_clients($_SESSION['ident_corp']);
								$tpl->assign("clients",$clients->clients_list);	
								$tpl->assign("message","&nbsp;<br>Contacto borrado correctamente<br>&nbsp;");
							}
							$tpl->assign("objeto",$this);
							break;
				case 'view':							
							$tpl=$this->view($_GET['id'],$tpl);
							$_SESSION['id_contact']=$this->id_contact;
							break;
				default:
							if($_SESSION['ident_corp'] != 0)
							{
								$this->method='list';
								$clients=new clients();
								$tpl=$this->listar($tpl);
								$clients->get_list_clients($_SESSION['ident_corp']);
								$tpl->assign("clients",$clients->clients_list);	
								$tpl->assign("objeto",$this);	
							}
							else
							{
								$tpl->assign('plantilla','error_corp.tpl');	
								return $tpl;
							}	
							break;
			}
		$tpl->assign('plantilla','contacts_'.$this->method.'.tpl');					
		
		return $tpl;
	}
	
	function get_fields_from_post(){		
		$this->name=htmlentities($_POST[$this->ddbb_name]);
		$this->last_name=htmlentities($_POST[$this->ddbb_last_name]);
		$this->last_name2=htmlentities($_POST[$this->ddbb_last_name2]);
		$this->birthday=$_POST[$this->ddbb_birthday];
		$this->address=htmlentities($_POST[$this->ddbb_address]);
		$this->id_client=$_SESSION['id_client'];
		$this->city=htmlentities($_POST[$this->ddbb_city]);
		$this->state=htmlentities($_POST[$this->ddbb_state]);
		$this->country=htmlentities($_POST[$this->ddbb_country]);
		$this->postal_code=$_POST[$this->ddbb_postal_code];
		$this->phone=$_POST[$this->ddbb_phone];
		$this->mobile_phone=$_POST[$this->ddbb_mobile_phone];
		$this->fax=$_POST[$this->ddbb_fax];
		$this->mail=htmlentities($_POST[$this->ddbb_mail]);
		
	}

	function bar($method,$corp){	
		if ($method!=$this->method){
			$method=$this->method;
		}	
		if ($corp != ""){
			$corp='<a href="index.php?module=corps&method=view&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = '<a href="index.php?module=user_corps">Zona privada</a> :: '.$corp.' <a href="index.php?module=contacts">Contactos</a>';
		$nav_bar=$nav_bar.$this->localice($method);
		return $nav_bar;
	}	

	function title($method,$corp){
				if ($method!=$this->method){
			$method=$this->method;
		}	
		if ($corp != ""){
			$corp=$corp." ::";
		}
		$title = "Zona Privada :: $corp Contactos";
		$title=$title.$this->localice($method);		
		return $title;
	}		
	
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Contactos";
									break;
						case 'list':
									$localice=" :: Buscar Contactos";
									break;
						case 'modify':
									$localice=" :: Modificar Contactos";
									break;
						case 'delete':
									$localice=" :: Borrar Contactos";
									break;
						case 'view':
									$localice=" :: Ver Contacto";									
									break;
						default:
									$localice=" :: Buscar Contactos";
									break;
		}
		return $localice;
	}
	
	/*
	function verify_contacts($id){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM `contacts` WHERE `id_user` = \''.$id.'\'';
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
			$this->contacts_users_list[$this->num]['id_contact']=$this->result->fields['id_contact'];
			$this->contacts_users_list[$this->num]['name']=$this->result->fields['name'];
			$this->contacts_users_list[$this->num]['last_name']=$this->result->fields['last_name'];
			$this->contacts_users_list[$this->num]['last_name2']=$this->result->fields['last_name2'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	}
	
	function admin ($id){
	
	
	}
	*/
}
?>