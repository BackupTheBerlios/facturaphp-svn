<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");

class emps{
//internal vars
	var $id_emp;
	var $id_corp;
	var $id_user;
	var $name;
	var $last_name;
	var $last_name2;
	var $birthday="00-00-0000";
	var $license="00-00-0000";
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
	var $table_name='emps';
	var $ddbb_id_emp = 'id_emp';
	var $ddbb_id_corp ='id_corp';
	var $ddbb_id_user='id_user';
	var $ddbb_name= 'name';
	var $ddbb_last_name='last_name';
	var $ddbb_last_name2='last_name2';
	var $ddbb_birthday='birthday';
	var $ddbb_license='license';
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
  	var $emps_list;
  	var $num;
  	var $fields_list;
  	var $error;
	var $corps_list;
	var $num_corps;
	var $emps_users_list;
	var $emps_corp_list;
	var $method;
	var $obj_user;
	var $cat_emps;
	var $come="00-00-0000";
	var $category;
	var $table_names_modify=array();
	var $table_names_delete=array("holydays","rel_emps_cats",);
	var $holydays_list;
	var $user_added;
	var $radiobutton;
  	//constructor
	function emps(){
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
		$this->fields_list->add($this->ddbb_id_emp, $this->id_emp, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_id_corp, $this->id_corp, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_id_user, $this->id_user, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_name, $this->name, 'varchar', 20,0,1);
		$this->fields_list->add($this->ddbb_last_name, $this->last_name, 'varchar', 20,0);
		$this->fields_list->add($this->ddbb_last_name2, $this->last_name2, 'varchar', 20,0 );
		$this->fields_list->add($this->ddbb_birthday, $this->birthday, 'date', 0,0);
		$this->fields_list->add($this->ddbb_license, $this->license, 'date', 0,0);
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
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
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
		
		return $this/*->get_list_emps($_SESSION['ident_corp'])*/;	 
		
	}
	
	function get_list_emps ($id_corp)
	{
		if (isset($_POST['submit_emps_search']))
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
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE (".$query.") AND id_corp = ".$id_corp;
		else
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE id_corp = ".$id_corp;
			
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
			//cogemos los datos del empleado
			$this->emps_list[$this->num][$this->ddbb_id_emp]=$this->result->fields[$this->ddbb_id_emp];
			$this->emps_list[$this->num][$this->ddbb_id_corp]=$this->result->fields[$this->ddbb_id_corp];
			$this->emps_list[$this->num][$this->ddbb_id_user]=$this->result->fields[$this->ddbb_id_user];
			$this->emps_list[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
			$this->emps_list[$this->num][$this->ddbb_last_name]=$this->result->fields[$this->ddbb_last_name];
			$this->emps_list[$this->num][$this->ddbb_last_name2]=$this->result->fields[$this->ddbb_last_name2];
			$this->emps_list[$this->num][$this->ddbb_birthday]=$this->result->fields[$this->ddbb_birthday];
			$this->emps_list[$this->num][$this->ddbb_license]=$this->result->fields[$this->ddbb_license];
			$this->emps_list[$this->num][$this->ddbb_phone]=$this->result->fields[$this->ddbb_phone];
			$this->emps_list[$this->num][$this->ddbb_mobile_phone]=$this->result->fields[$this->ddbb_mobile_phone];
			$this->emps_list[$this->num][$this->ddbb_fax]=$this->result->fields[$this->ddbb_fax];
			$this->emps_list[$this->num][$this->ddbb_mail]=$this->result->fields[$this->ddbb_mail];
			$this->emps_list[$this->num][$this->ddbb_address]=$this->result->fields[$this->ddbb_address];
			$this->emps_list[$this->num][$this->ddbb_city]=$this->result->fields[$this->ddbb_city];
			$this->emps_list[$this->num][$this->ddbb_state]=$this->result->fields[$this->ddbb_state];
			$this->emps_list[$this->num][$this->ddbb_postal_code]=$this->result->fields[$this->ddbb_postal_code];
			$this->emps_list[$this->num][$this->ddbb_country]=$this->result->fields[$this->ddbb_country];

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
	

	
	function add(){
		
		//Miramos a ver si esta definida el "submit_add" y si no lo esta, pasamos directamente a mostrar la plantilla
		if (!isset($_POST['submit_add'])){
			//Mostrar plantilla vac�a	
			if((!isset($_POST['existUser']))||($_POST['existUser']=="new")){
				$this->obj_user=new users();
				$this->obj_user->get_list_users();
				$this->obj_user->is_emps=true;
				$this->obj_user->return_validate_emps=$return;
				$this->user_added=$this->obj_user->add();
			}
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
			$this->id_emp=0;
			$this->fields_list->modify_value($this->ddbb_id_emp,$this->id_emp);
			$this->fields_list->modify_value($this->ddbb_id_user,$this->id_user);			
			$this->fields_list->modify_value($this->ddbb_id_corp,$this->id_corp);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_last_name,$this->last_name);
			$this->fields_list->modify_value($this->ddbb_last_name2,$this->last_name2);
			$this->fields_list->modify_value($this->ddbb_birthday,$this->birthday);
			$this->fields_list->modify_value($this->ddbb_license,$this->license);
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
			$cadena=$this->fields_list->validate_date($this->come,1);
			if(!is_int($cadena)){
				array_push($this->fields_list->array_error,'come',$cadena);
				$return=false;
			}
			
			if((!isset($_POST['existUser']))||($_POST['existUser']=="new")){
				$this->obj_user=new users();
				$this->obj_user->get_list_users();
				$this->obj_user->is_emps=true;
				$this->obj_user->return_validate_emps=$return;
				$this->user_added=$this->obj_user->add();
				$this->radiobutton="new";
			}
			else{
				$this->obj_user=new users();
				$this->obj_user->get_list_users();
				$this->obj_user->is_emps=true;
				$this->obj_user->get_checkbox_modules_from_bbdd();
				$this->obj_user->get_checkbox_groups_from_bbdd();
				$this->radiobutton="exist";
			}
			
			//Validacion
			//$return=validate_fields();
			
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			
			
			if (!$return || $this->user_added==-1){
				//Mostrar plantilla con datos erroneos
				return -1;
			}
		    else{
			//	$this->come=$this->fields_list->change_date($this->come,"en");
				$this->birthday=$this->fields_list->change_date($this->birthday,"en");
				$this->license=$this->fields_list->change_date($this->license,"en");
				//Si todo es correcto si meten los datos
				
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexin con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexin de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexin permanente con la bbdd
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
				$record[$this->ddbb_name]=$this->name;
				$record[$this->ddbb_last_name]=$this->last_name;
				$record[$this->ddbb_last_name2]=$this->last_name2;
				$record[$this->ddbb_birthday]=$this->birthday;
				$record[$this->ddbb_license]=$this->license;
				$record[$this->ddbb_address]=$this->address;
				$record[$this->ddbb_id_corp]=$this->id_corp;
				$record[$this->ddbb_city]=$this->city;
				$record[$this->ddbb_state]=$this->state;
				$record[$this->ddbb_country]=$this->country;
				$record[$this->ddbb_postal_code]=$this->postal_code;
				$record[$this->ddbb_phone]=$this->phone;
				$record[$this->ddbb_mobile_phone]=$this->mobile_phone;
				$record[$this->ddbb_fax]=$this->fax;
				$record[$this->ddbb_mail]=$this->mail;				
				
				//Insertamus el usuario.
				if ($_POST["user"]=="new"){
					$this->id_user=$this->obj_user->id_user;
				}	
				$record[$this->ddbb_id_user]=$this->id_user;		
				
				//calculamos la sql de insercin respecto a los atributos
				$this->sql = $this->db->GetInsertSQL($this->result, $record);
				//print($this->sql);
				//insertamos el registro
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				if($this->db->Insert_ID()>=0){
					//Cogemos el id del empleado insertado.
					
					$this->id_emp=$this->db->Insert_ID();					
					//capturammos el id de la linea insertada
					//Introducimos categorias;
					$this->add_category($this->id_emp);
					//Introducimos fecha de alta.
					$this->add_holyday($this->id_emp);

					
					//print("<pre>::".$this->id_user."::</pre>");
					//devolvemos el id de la tabla ya que todo ha ido bien
					$this->db->close();
					
					//Se hace nueva imagen de las tablas de permiso para usuarios
					$permisos = new permissions();
					$_SESSION['permisos_user_modules'] = $permisos->get_per_user_modules();
					$_SESSION['permisos_user_methods'] = $permisos->get_per_user_methods();
					
					return $this->id_emp;
				}else {
					
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}
			}
		}
	}
	
	function add_category($id){
		$category=new rel_emps_cats();
		$category->id_emp=$id;
		$category->id_cat_emp=$this->category;
		return $category->add();
	}
	
	function add_holyday($id){
		$holyday=new holydays();
		$holyday->id_emp=$id;
		$holyday->is_emps=true;
		$holyday->ill=2;
		$holyday->come=$this->come;
		$holyday->emps_modify = true;
		return $holyday->add();
	}
	
	function modify(){
		$this->user_changed=0;
		
		if (!isset($_POST['submit_modify'])){
			if((!isset($_POST['existUser']))||($_POST['existUser']=="new")||($_POST['existUser']=="modify")){
			
				if(($_POST['existUser']=="new")||($this->id_user==0)||($this->id_user=="")){
					$this->obj_user=new users();
					$this->obj_user->get_list_users();
					$this->obj_user->is_emps=true;
					$user_changed=$this->obj_user->add();
					}
				if(($_POST['existUser']=="modify")||($this->id_user!=0)){
					$this->obj_user=new users();
					$this->obj_user->get_list_users();
					$this->obj_user->is_emps=true;
					$this->obj_user->read_fields($this->id_user);
					$user_changed=$this->obj_user->modify();
					}
		}
			
			return 0;
		}
		else{
			//Introducir los datos de post.
			$this->get_fields_from_post();	
						
			//Validacion
			//$return=validate_fields();
			$this->fields_list->modify_value($this->ddbb_id_emp,$this->id_emp);
			$this->fields_list->modify_value($this->ddbb_id_user,$this->id_user);			
			$this->fields_list->modify_value($this->ddbb_id_corp,$this->id_corp);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_last_name,$this->last_name);
			$this->fields_list->modify_value($this->ddbb_last_name2,$this->last_name2);
			$this->fields_list->modify_value($this->ddbb_birthday,$this->birthday);
			$this->fields_list->modify_value($this->ddbb_license,$this->license);
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
			$cadena=$this->fields_list->validate_date($this->come,1);
			if(!is_int($cadena)){
				array_push($this->fields_list->array_error,'come',$cadena);
				$return=false;
			}
			if((!isset($_POST['user']))||($_POST['user']=="new")){
				$this->obj_user=new users();
				$this->obj_user->get_list_users();
				$this->obj_user->is_emps=true;
				$this->obj_user->return_validate_emps=$return;
				$this->user_changed=$this->obj_user->add();
				$this->radiobutton="new";
			}
			elseif(($_POST['user']=="modify")||($this->id_user!=0)){
					$this->obj_user=new users();
					$this->obj_user->get_list_users();
					$this->obj_user->is_emps=true;
					$this->obj_user->read_fields($this->id_user);
					$this->user_changed=$this->obj_user->modify();
					$this->radiobutton="modify";
				}			
				else
				{
					$this->obj_user=new users();
					$this->obj_user->get_list_users();
					$this->obj_user->is_emps=true;
					$this->obj_user->get_checkbox_modules_from_bbdd();
					$this->obj_user->get_checkbox_groups_from_bbdd();
					$this->radiobutton="exist";
				}
			
			
			
			
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			
			
			if (!$return || $this->user_changed==-1){
				//Mostrar plantilla con datos erroneos
				return -1;
			}
			else{
				//$this->come=$this->fields_list->change_date($this->come,"en");
				$this->birthday=$this->fields_list->change_date($this->birthday,"en");
				$this->license=$this->fields_list->change_date($this->license,"en");
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexin con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexin de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexin permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_emp." = \"".$this->id_emp."\"" ;
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
				$record[$this->ddbb_id_emp]=$this->id_emp;
				$record[$this->ddbb_name]=$this->name;
				$record[$this->ddbb_last_name]=$this->last_name;
				$record[$this->ddbb_last_name2]=$this->last_name2;
				$record[$this->ddbb_birthday]=$this->birthday;
				$record[$this->ddbb_license]=$this->license;
				$record[$this->ddbb_address]=$this->address;
				$record[$this->ddbb_id_corp]=$this->id_corp;
				$record[$this->ddbb_city]=$this->city;
				$record[$this->ddbb_state]=$this->state;
				$record[$this->ddbb_country]=$this->country;
				$record[$this->ddbb_postal_code]=$this->postal_code;
				$record[$this->ddbb_phone]=$this->phone;
				$record[$this->ddbb_mobile_phone]=$this->mobile_phone;
				$record[$this->ddbb_fax]=$this->fax;
				$record[$this->ddbb_mail]=$this->mail;		

				if ($_POST["user"]=="new"){
					$this->id_user=$this->obj_user->id_user;
				}	
				$record[$this->ddbb_id_user]=$this->id_user;	
				//calculamos la sql de insercin respecto a los atributos
				$this->sql = $this->db->GetUpdateSQL($this->result, $record);
				//insertamos el registro
				
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				$Affected_Rows=$this->db->Affected_Rows();
				/*Al hacer la modificacion de categorias y vacaciones antes del siguiente "if"
				 se debe de guardar en una variable el contenido de las filas afectadas y hacer
				 la condicion del if con esa variable ya que al hacer las modificaciones ese valor var�a.
				*/
				
				$return_category=$this->modify_category($this->id_emp);
				$return_holyday=$this->modify_holyday($this->id_emp);
			
			
				if(($Affected_Rows==1)||($this->user_changed!=0)||($this->sql=="")||($return_category!=0)||($return_holyday!=0)){
					//capturammos el id de la linea insertada
					$this->db->close();
					
					//Modificar variable de sesi�n con tabla de permisos
					$permisos = new permissions();
					$_SESSION['permisos_user_modules'] = $permisos->get_per_user_modules();
					$_SESSION['permisos_user_methods'] = $permisos->get_per_user_methods();
		
					//devolvemos el id de la tabla ya que todo ha ido bien
					return $this->id_emp;
				}else {
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}
			}
		}	
	}
	
	function modify_category($id){
		$category=new rel_emps_cats();
		$return=$category->read($category->get_rel_emp_cat($this->id_emp));
		if ($return==0){
			return $this->add_category($id);
		}
		$category->id_emp=$id;
		$category->id_cat_emp=$this->category;
		return $category->modify();
	}
	
	function modify_holyday($id){
		$holyday=new holydays();
		$return=$holyday->get_come($id);
		$holyday->is_emps=true;
		
		if ($return==0){
			return $this->add_holyday($id);
		}
		$holyday->read($_POST["id_holy"]);
		$holyday->id_emp=$id;
		$holyday->ill=2;
		$holyday->come=$this->come;
		return $holyday->modify();
	}
	
	function remove($id){
			if (!isset($_POST["submit_delete"])){
				
									
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
			$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_emp." = ".$id;
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
			$this->modify_all_id_emp($id,$this->table_names_modify[$i]);
		}
		//borramos todos aquellos registros en los que hay un id_user;		
		for ($i=0;$i<count($this->table_names_delete);$i++){
			$this->delete_all_id_emp($id,$this->table_names_delete[$i]);
		}
	}
	
	function modify_all_id_emp($id,$table){
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="UPDATE ".$table. " SET id_user = 0 WHERE id_emp = ".$id;
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
	
	function delete_all_id_emp($id,$table){
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.

			$this->sql="DELETE FROM ".$table. " WHERE id_emp = ".$id;
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
	
	function belong_corp($id_corp){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM `emps` WHERE `id_corp` = \''.$id_corp.'\'';
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
			
			$this->emps_corp_list[$this->num]['id_emp']=$this->result->fields['id_emp'];
			$this->emps_corp_list[$this->num]['name']=$this->result->fields['name'];
			$this->emps_corp_list[$this->num]['last_name']=$this->result->fields['last_name'];
			$this->emps_corp_list[$this->num]['last_name2']=$this->result->fields['last_name2'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->emps_corp_list;
		
	}
	function get_user_corps($id_user)
	{
	
		//Se pasa como par�metro el login del usuario que se conect� a la sesi�n, esto se hace desde index.php
		

		//coge las variables globales del fichero config.inc.php
		global $DDBB_TYPE, $DDBB_NAME, $IP_DDBB, $DDBB_USER, $DDBB_PASS, $DDBB_PORT, $TABLE_PREFIX;
		$this->db_type=$DDBB_TYPE;
		$this->db_name=$DDBB_NAME;
		$this->db_ip=$IP_DDBB;
		$this->db_user=$DDBB_USER;
		$this->db_passwd=$DDBB_PASS;
		$this->db_port=$DDBB_PORT;
		$this->table_prefix=$TABLE_PREFIX;
		//A partir de este id, se busca dentro de emps todos los empleados que contenga el id_user y sus correspondientes id_corp
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT `id_corp` FROM `emps` WHERE `id_user` =".$id_user;
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		//$this->corps_list[0][$this->ddbb_id_user] = $id_user;
		
		//Con el id_corp se podr� obtener el nombre de cada empresa en la trabaja id_user
		$this->num_corps=0;
		$i = 0;
		while (!$this->result->EOF) 
		{
			$id_corp = $this->result->fields['id_corp'];

			$this->sql="SELECT `name` FROM `corps` WHERE `id_corp` =".$id_corp;
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
			//Si hay m�s de un empleado con mismo login en la empresa evitamos que salga m�s de una vez, 
			//para ello por cada empresa nueva se incrementa en uno su contador
			$temp[$this->num_corps][$this->ddbb_id_corp] = $id_corp;
			$temp[$this->num_corps]['name'] = $this->result1->fields['name'];
		
			$empresas[$id_corp]['cont']++;

			
			if(($empresas[$id_corp]['cont'] == 1))
			{
				//Si aparece y cont es 1 entonces es la primera vez que aparece
				$this->corps_list[$i][$this->ddbb_id_corp] = $temp[$this->num_corps][$this->ddbb_id_corp];
				$this->corps_list[$i]['name'] = $temp[$this->num_corps]['name'];
				$i++;
				
			}
*/
				
			$this->corps_list[$this->num_corps][$this->ddbb_id_corp] = $id_corp;
			$this->corps_list[$this->num_corps]['name'] = $this->result1->fields['name'];

			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num_corps++;
		}
	
		$this->db->close();
		//$this->num_corps = $i;
		
		return $this->num_corps;
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
		$this->sql="SELECT * FROM `emps` WHERE `id_emp`= \"".$id."\"";
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
			$this->id_emp = $id;
			$this->id_corp = $this->result->fields[$this->ddbb_id_corp];
			$this->id_user = $this->result->fields[$this->ddbb_id_user];
			$this->name = $this->result->fields[$this->ddbb_name];
			$this->last_name = $this->result->fields[$this->ddbb_last_name];
			$this->last_name2 = $this->result->fields[$this->ddbb_last_name2];
			$this->birthday = $this->result->fields[$this->ddbb_birthday];
			$this->license = $this->result->fields[$this->ddbb_license];
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
			Order By (y mantener la b�squeda en el caso de que hubiera hecha una y averiguar la "pesta�a" a la que hace referencia)
			Busquedas
	*/
			$cadena='';			
			// Leemos el empleado y se lo pasamos a la plantilla
			$this->read($id);
			$tpl->assign('objeto',$this);

			if(($this->id_user==0)||($this->id_user=='')){
				$tpl->assign("user_emp","Sin Usuario");
			}
			else{
				$usuario = new users();
				$usuario->read_fields($this->id_user);
				$tpl->assign("user_emp",$usuario->login);
			}
			
			if ($this->birthday!="0000-00-00"){
				list($anno,$mes,$dia)=sscanf($this->birthday,"%d-%d-%d");
				$tpl->assign("cumplecambiado","$dia-$mes-$anno");
			}
			else{
				$tpl->assign("cumplecambiado","00-00-0000");
			}	
			
			//Se comprueba si hay permiso para borrar o modificar
			$permisos_mod_del = new permissions();
			$permisos_mod_del->get_permissions_modify_delete('emps');
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
			else
			{
				$holydays = true;
			}
			
		
			$mensaje = null;
			$mensaje[0]['id_mensaje'] = 1;
			$mensaje[0]['mes'] = "Sentimos informarle de que no tiene permiso para acceder a esta informaci�n";
			
			$cadena="";
			$tabla_vacaciones = new table(false);
			$tabla_vacaciones->parameter_add="&id_emp=".$this->id_emp;
			if($holydays)
			{
				
				//listado de holydays
				if ($this->get_holydays($this->id_emp)==0)
				{
									$per = new permissions();
					$num = $per->get_permissions_list('holydays');
					$cadena=$cadena.$tabla_vacaciones->tabla_vacia('holydays',$per->add);
					$variables_vacaciones=$tabla_vacaciones->nombres_variables;
				}
				else
				{
				$per = new permissions();
					$num = $per->get_permissions_list('holydays');
					
					$permisos  ;	
					$j=0;
					for ($i=0;$i<count($per->permissions_module);$i++){
						if(($per->permissions_module[$i]=="modify")||($per->permissions_module[$i]=="delete")){
							$permisos[$j]=$per->permissions_module[$i];
							$j++;
						} 
					}
								
					$cadena=$cadena.$tabla_vacaciones->make_tables('holydays',$this->holydays_list,array('Fecha de baja',25,'Fecha de alta',25,'Motivo',25),array('id_holy','gone','come','ill'),$_SESSION['num_regs'],$permisos,$per->add);
					$variables_vacaciones=$tabla_vacaciones->nombres_variables;
				}
			}
			else
			{
				$cadena=$cadena.$tabla_vacaciones->make_tables('holydays',$mensaje,array('ACCION NO PERMITIDA',50),array('id_mensaje','mes'),10,null,false);
				$variables_vacaciones=$tabla_vacaciones->nombres_variables;
			}
			
			$i=0;
			while($i<(count($variables_vacaciones))){
				for($j=0;$j<count($variables_vacaciones);$j++){
					$variables[$i]=$variables_vacaciones[$j];
					
					$i++;
				}
			}

			
			$tpl->assign('variables',$variables);
			$tpl->assign('cadena',$cadena);
						
			return $tpl;
				
	}
	
	function get_holydays($id){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM `holydays` WHERE `id_emp` = \''.$id.'\'';
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
			$this->holydays_list[$this->num]['id_holy']=$this->result->fields['id_holy'];
			$this->holydays_list[$this->num]['gone']=$this->result->fields['gone'];
			$this->holydays_list[$this->num]['come']=$this->result->fields['come'];
			switch($this->result->fields['ill']){
				case 0: $this->holydays_list[$this->num]['ill']="Enfermedad";
						break;
				case 1: $this->holydays_list[$this->num]['ill']="Vacaciones";
						break;
						
				case 2: $this->holydays_list[$this->num]['ill']="Otros";
						break;
				default: $this->holydays_list[$this->num]['ill']="Otros";
					break;
			}
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	}

	function listar($tpl)
	{
		if (isset($_POST['submit_corps_search']))
		{
			//Se toma el n�mero de registros y se guarda en varable de sesi�n
			//que se cumpla en todos los accesos del usuario
			$_SESSION['num_regs']= $_POST['regs'];
			
		}
		$num = $this->get_list_emps($_SESSION['ident_corp']);
	
		$tabla_listado = new table(true);
		$per = new permissions();
		$per->get_permissions_list('emps');
		if ($num==0)
		{
			$cadena=''.$cadena.$tabla_listado->tabla_vacia('emps', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{	
			$cadena=''.$tabla_listado->make_tables('emps',$this->emps_list,array('Nombre',20,'Primer Apellido',20,'Segundo Apellido',20),array($this->ddbb_id_emp, $this->ddbb_name,$this->ddbb_last_name,$this->ddbb_last_name2),$_SESSION['num_regs'],$per->permissions_module,$per->add);
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
							$vacaciones= new holydays();	
							$this->cat_emps=new cat_emps();
							$return=$this->add();
							switch ($return){										
								case 0: //por defecto												
									break;
								case -1: //Errores al intentar a�adir datos
										for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
											$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
										}		
										if ($this->user_added==-1){											
											for ($i=0;$i<count($this->obj_user->fields_list->array_error);$i+=2){
												
													$tpl->assign("user_error_".$this->obj_user->fields_list->array_error[$i],$this->obj_user->fields_list->array_error[$i+1]);
													//echo $prefix."error_".$this->fields_list->array_error[$i];
												}
										}
										$tpl->assign("radio",$this->radiobutton);
										break;
								default: //Si se ha a�adido
										$this->method="list";
										$tpl=$this->listar($tpl);										
										$tpl->assign("message","&nbsp;<br>Empleado a&ntilde;adido correctamente<br>&nbsp;");
										break;
							}
							
							
							
							$tpl->assign("holyday",$vacaciones);
							$tpl->assign("categorias",$this->cat_emps->cat_emps_list);
							$tpl->assign("objeto",$this);									
							$tpl->assign("usuarios",$this->obj_user);
							$tpl->assign("listado_usuarios",$this->obj_user->users_list);
							$tpl->assign("modulos",$this->obj_user->checkbox);
							$tpl->assign("grupos",$this->obj_user->checkbox_groups);
							break;
							
				case 'list':
							$tpl=$this->listar($tpl);
							$tpl->assign("objeto",$this);	
							$tpl->assign("registro",$_SESSION['num_regs']);
							break;
				case 'modify':
							/*
							$this->read($_GET['id']);
							if ($this->modify() !=0){
								$this->method="list";
								$tpl=$this->listar($tpl);										
								$tpl->assign("message","&nbsp;<br>Empleado modificado correctamente<br>&nbsp;");
							}
							$vacaciones=new holydays();
							$return=$vacaciones->get_come($this->id_emp);
							if ($return==0){
								$vacaciones->come="0000-00-00";
								$tpl->assign("holycambiado","00-00-0000");
							}
							else{
								if ($vacaciones->come!="0000-00-00"){
									list($anno,$mes,$dia)=sscanf($vacaciones->come,"%d-%d-%d");
									$tpl->assign("holycambiado","$dia-$mes-$anno");
								}
								else{
									$tpl->assign("holycambiado","00-00-0000");
								}
								
							}
							
							if ($this->birthday!="0000-00-00"){
								list($anno,$mes,$dia)=sscanf($this->birthday,"%d-%d-%d");
								$tpl->assign("cumplecambiado","$dia-$mes-$anno");
							}
							else{
								$tpl->assign("cumplecambiado","00-00-0000");
							}*/
							
							$this->read($_GET['id']);
							
							$vacaciones= new holydays();	
							$vacaciones->get_come($this->id_emp);
							$this->cat_emps=new cat_emps();
							$return=$this->modify();
							switch ($return){										
								case 0: //por defecto												
									$this->come=$vacaciones->come;
									$this->come=$this->fields_list->change_date($this->come,"es");
									$this->birthday=$this->fields_list->change_date($this->birthday,"es");
									$this->license=$this->fields_list->change_date($this->license,"es");
									break;
								case -1: //Errores al intentar a�adir datos
										for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
											$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
										}		
										if ($this->user_changed==-1){											
											for ($i=0;$i<count($this->obj_user->fields_list->array_error);$i+=2){
												
													$tpl->assign("user_error_".$this->obj_user->fields_list->array_error[$i],$this->obj_user->fields_list->array_error[$i+1]);
													//echo $prefix."error_".$this->fields_list->array_error[$i];
												}
										}
										$tpl->assign("radio",$this->radiobutton);
										break;
								default: //Si se ha a�adido
										$this->method="list";
										$tpl=$this->listar($tpl);										
										$tpl->assign("message","&nbsp;<br>Empleado modificado correctamente<br>&nbsp;");
										break;
							}
							$tpl->assign("holyday",$vacaciones);
							$tpl->assign("categorias",$this->cat_emps->cat_emps_list);
							$tpl->assign("objeto",$this);									
							$tpl->assign("usuarios",$this->obj_user);
							$tpl->assign("listado_usuarios",$this->obj_user->users_list);
							$tpl->assign("modulos",$this->obj_user->checkbox);
							$tpl->assign("grupos",$this->obj_user->checkbox_groups);
							break;
				case 'delete':
							$this->read($_GET['id']);
							if ($this->remove($_GET['id'])==0){
								$tpl->assign("message",$this->empleados);
							}
							else{
								$this->emps_list="";
								$this->method="list";
								$tpl=$this->listar($tpl);
								$tpl->assign("message","&nbsp;<br>Empleado borrado correctamente<br>&nbsp;");
							}
							$tpl->assign("objeto",$this);
							break;
				case 'view':							
							$tpl=$this->view($_GET['id'],$tpl);
							$_SESSION['id_emp']=$this->id_emp;
							break;
				default:
							if($_SESSION['ident_corp'] != 0)
							{
								$this->method='list';
								$tpl=$this->listar($tpl);
								$tpl->assign("objeto",$this);
								$tpl->assign("registro",$_SESSION['num_regs']);	
							}
							else
							{
								$tpl->assign('plantilla','error_corp.tpl');	
								return $tpl;
							}	
							break;
			}
		$tpl->assign('plantilla','emps_'.$this->method.'.tpl');					
		
		return $tpl;
	}
	
	function get_fields_from_post(){		
		$this->name=htmlentities($_POST[$this->ddbb_name]);
		$this->last_name=htmlentities($_POST[$this->ddbb_last_name]);
		$this->last_name2=htmlentities($_POST[$this->ddbb_last_name2]);
		$this->birthday=$_POST[$this->ddbb_birthday];
		$this->license=$_POST[$this->ddbb_license];
		$this->address=htmlentities($_POST[$this->ddbb_address]);
		$this->id_corp=$_SESSION['ident_corp'];
		$this->city=htmlentities($_POST[$this->ddbb_city]);
		$this->state=htmlentities($_POST[$this->ddbb_state]);
		$this->country=htmlentities($_POST[$this->ddbb_country]);
		$this->postal_code=$_POST[$this->ddbb_postal_code];
		$this->phone=$_POST[$this->ddbb_phone];
		$this->mobile_phone=$_POST[$this->ddbb_mobile_phone];
		$this->fax=$_POST[$this->ddbb_fax];
		$this->mail=htmlentities($_POST[$this->ddbb_mail]);
		
		//Cogemos la fecha de alta
		$this->come=$_POST["come"];
		
		//Si el usuario ya estaba creado, se lo asignamos		
		if ($_POST["user"]=="exist"){
			$this->id_user=$_POST["existUser"];
		}		
		
		//Cogemos la categoria
		$this->category=$_POST["category"];
	}

	function bar($method,$corp){	
		if ($method!=$this->method){
			$method=$this->method;
		}	
		if ($corp != ""){
			$corp='<a href="index.php?module=corps&method=view&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = '<a href="index.php?module=user_corps">Zona privada</a> :: '.$corp.' <a href="index.php?module=emps">Empleados</a>';
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
		$title = "Zona Privada :: $corp Empleados";
		$title=$title.$this->localice($method);		
		return $title;
	}		
	
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Empleados";
									break;
						case 'list':
									$localice=" :: Buscar Empleados";
									break;
						case 'modify':
									$localice=" :: Modificar Empleados";
									break;
						case 'delete':
									$localice=" :: Borrar Empleados";
									break;
						case 'view':
									$localice=" :: Ver Empleado";									
									break;
						default:
									$localice=" :: Buscar Empleados";
									break;
		}
		return $localice;
	}
	
	function verify_emps($id){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM `emps` WHERE `id_user` = \''.$id.'\'';
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
			$this->emps_users_list[$this->num]['id_emp']=$this->result->fields['id_emp'];
			$this->emps_users_list[$this->num]['name']=$this->result->fields['name'];
			$this->emps_users_list[$this->num]['last_name']=$this->result->fields['last_name'];
			$this->emps_users_list[$this->num]['last_name2']=$this->result->fields['last_name2'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	}
	
	function admin ($id){
	
	
	}
	
}
?>