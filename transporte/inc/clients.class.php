<?php
//clase que da soporte a las empresas del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");

class clients{
//internal vars
	var $id_client;
	var $id_corp;
	var $name;
	var $full_name;
	var $cif_nif;
	var $address;
	var $fiscal_address;
	var $postal_address;
	var $url;
	var $mail;
	var $city;
	var $state;
	var $postal_code;
	var $country;
	var $phone;
	var $mobile_phone;
	var $fax;
	var $notes;
	var $id_cat_client;
	var $id_pay_type;
	var $payday="00-00-0000";
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
	var $table_name='clients';
	var $ddbb_id_client='id_client';
	var $ddbb_id_corp='id_corp';
  	var $ddbb_name='name';
  	var $ddbb_full_name='full_name';
	var $ddbb_cif_nif='cif_nif';
  	var $ddbb_address='address';
	var $ddbb_fiscal_address='fiscal_address';
	var $ddbb_postal_address='postal_address';
	var $ddbb_url='url';
	var $ddbb_mail='mail';
	var $ddbb_city='city';
	var $ddbb_state='state';
	var $ddbb_postal_code='postal_code';
	var $ddbb_country='country';
	var $ddbb_phone='phone';
	var $ddbb_mobile_phone='mobile_phone';
	var $ddbb_fax='fax';
	var $ddbb_id_cat_client='id_cat_client';
	var $ddbb_id_pay_type='id_pay_type';
	var $ddbb_payday='payday';
	var $ddbb_notes='notes';
	var $ddbb_search='search';
	
	var $db;
	var $result;  	
//variables complementarias	
  	var $clients_list;
  	var $num;
  	var $fields_list;
  	var $error;
	var $method;
	var $table_names_modify=array();
	var $table_names_delete=array("contacts");

  	//constructor
	function clients(){
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
		$this->fields_list->add($this->ddbb_id_client, $this->id_client, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_id_corp, $this->id_corp, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_name, $this->name, 'varchar', 20,0,1);
		$this->fields_list->add($this->ddbb_full_name, $this->full_name, 'varchar', 50,0);
		$this->fields_list->add($this->ddbb_cif_nif, $this->cif_nif, 'varchar', 10,0,1);
		$this->fields_list->add($this->ddbb_address, $this->address, 'varchar', 255,0);	
		$this->fields_list->add($this->ddbb_postal_address, $this->postal_address, 'varchar', 255,0);		
		$this->fields_list->add($this->ddbb_fiscal_address, $this->fiscal_address, 'varchar', 255,0);				
		$this->fields_list->add($this->ddbb_url, $this->url, 'varchar', 255,0);
		$this->fields_list->add($this->ddbb_mail, $this->mail, 'varchar', 100,0);
		$this->fields_list->add($this->ddbb_city, $this->city, 'varchar', 50,0);
		$this->fields_list->add($this->ddbb_state, $this->state, 'varchar', 50,0);		
		$this->fields_list->add($this->ddbb_postal_code, $this->postal_code, 'varchar', 10,0);		
		$this->fields_list->add($this->ddbb_country, $this->country, 'varchar', 50,0);				
		$this->fields_list->add($this->ddbb_phone, $this->phone, 'varchar', 15,0);		
		$this->fields_list->add($this->ddbb_mobile_phone, $this->mobile_phone, 'varchar', 15,0);		
		$this->fields_list->add($this->ddbb_fax, $this->fax, 'varchar', 15,0);				
		$this->fields_list->add($this->ddbb_notes, $this->notes, 'varchar', 255,0);						
		$this->fields_list->add($this->ddbb_id_cat_client, $this->id_cat_client, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_pay_type, $this->id_pay_type, 'int', 11,0);
		$this->fields_list->add($this->ddbb_payday, $this->payday, 'date', 11,0);
	
		$this->search[0]= 'name';
		$this->search[1]= 'full_name';
		$this->search[2]= 'cif_nif';
		$this->search[3]= 'phone';
		
		return $this;	 
		
	}
	
	function get_list_clients ($id_corp){
		
		if (isset($_POST['submit_clients_search']))
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
			//cogemos los datos del usuario
			$this->clients_list[$this->num][$this->ddbb_id_client]=$this->result->fields[$this->ddbb_id_client];
			$this->clients_list[$this->num][$this->ddbb_id_corp]=$this->result->fields[$this->ddbb_id_corp];
			$this->clients_list[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
			$this->clients_list[$this->num][$this->ddbb_full_name]=$this->result->fields[$this->ddbb_full_name];
			$this->clients_list[$this->num][$this->ddbb_address]=$this->result->fields[$this->ddbb_address];
			$this->clients_list[$this->num][$this->ddbb_cif_nif]=$this->result->fields[$this->ddbb_cif_nif];
			$this->clients_list[$this->num][$this->ddbb_fiscal_address]=$this->result->fields[$this->ddbb_fiscal_address];
			$this->clients_list[$this->num][$this->ddbb_postal_address]=$this->result->fields[$this->ddbb_postal_address];
			$this->clients_list[$this->num][$this->ddbb_url]=$this->result->fields[$this->ddbb_url];
			$this->clients_list[$this->num][$this->ddbb_mail]=$this->result->fields[$this->ddbb_mail];
			$this->clients_list[$this->num][$this->ddbb_city]=$this->result->fields[$this->ddbb_city];
			$this->clients_list[$this->num][$this->ddbb_state]=$this->result->fields[$this->ddbb_state];
			$this->clients_list[$this->num][$this->ddbb_postal_code]=$this->result->fields[$this->ddbb_postal_code];
			$this->clients_list[$this->num][$this->ddbb_country]=$this->result->fields[$this->ddbb_country];
			$this->clients_list[$this->num][$this->ddbb_phone]=$this->result->fields[$this->ddbb_phone];
			$this->clients_list[$this->num][$this->ddbb_mobile_phone]=$this->result->fields[$this->ddbb_mobile_phone];
			$this->clients_list[$this->num][$this->ddbb_fax]=$this->result->fields[$this->ddbb_fax];
			$this->clients_list[$this->num][$this->ddbb_notes]=$this->result->fields[$this->ddbb_notes];
			$this->clients_list[$this->num][$this->ddbb_id_pay_type]=$this->result->fields[$this->ddbb_id_pay_type];
			$this->clients_list[$this->num][$this->ddbb_id_cat_client]=$this->result->fields[$this->ddbb_id_cat_client];
			$this->clients_list[$this->num][$this->ddbb_payday]=$this->result->fields[$this->ddbb_payday];
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
	
	}*/
	
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_client."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_client=$id;
			$this->id_corp=$this->result->fields[$this->ddbb_id_corp];
			$this->name=$this->result->fields[$this->ddbb_name];
			$this->full_name=$this->result->fields[$this->ddbb_full_name];
			$this->cif_nif=$this->result->fields[$this->ddbb_cif_nif];
			$this->address=$this->result->fields[$this->ddbb_address];
			$this->fiscal_address=$this->result->fields[$this->ddbb_fiscal_address];
			$this->postal_address=$this->result->fields[$this->ddbb_postal_address];
			$this->url=$this->result->fields[$this->ddbb_url];
			$this->mail=$this->result->fields[$this->ddbb_mail];
			$this->city=$this->result->fields[$this->ddbb_city];
			$this->state=$this->result->fields[$this->ddbb_state];
			$this->postal_code=$this->result->fields[$this->ddbb_postal_code];
			$this->country=$this->result->fields[$this->ddbb_country];
			$this->phone=$this->result->fields[$this->ddbb_phone];
			$this->mobile_phone=$this->result->fields[$this->ddbb_mobile_phone];
			$this->fax=$this->result->fields[$this->ddbb_fax];
			$this->notes=$this->result->fields[$this->ddbb_notes];
			$this->payday=$this->result->fields[$this->ddbb_payday];
			$this->id_cat_client=$this->result->fields[$this->ddbb_id_cat_client];
			$this->id_pay_type=$this->result->fields[$this->ddbb_id_pay_type];
			$this->db->close();
			return 1;
		}
			
	
	
	}
	
	function listar($tpl){
		if (isset($_POST['submit_clients_search']))
		{
			//Se toma el n�mero de registros y se guarda en varable de sesi�n
			//que se cumpla en todos los accesos del usuario
			$_SESSION['num_regs']= $_POST['regs'];
			
		}
		$tabla_listado = new table(true);
		$per = new permissions();
		$per->get_permissions_list('clients');
		if (!$this->get_list_clients($_SESSION['ident_corp']))
		{
			$cadena=$cadena.$tabla_listado->tabla_vacia('clients', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{
			$cadena=''.$tabla_listado->make_tables('clients',$this->clients_list,array('Nombre',20,'Nombre completo',20,'CIF|NIF',20,'Telefono',20),array($this->ddbb_id_client,$this->ddbb_name,$this->ddbb_full_name,$this->ddbb_cif_nif,$this->ddbb_phone),$_SESSION['num_regs'],$per->permissions_module,$per->add);
			$variables=$tabla_listado->nombres_variables;		
		}		
		$tpl->assign('variables',$variables);
		$tpl->assign('cadena',$cadena);		
		return $tpl;
	}
	
	
	function calculate_tpl($method, $tpl){
		//vemos si el usuario tiene el permiso para hacer la accion requerida
		$result=true;
	//	$result=validate_per($method,$_SESSION['user'],$module);
		if ($result){
				$this->method=$method;
				
				switch($method){

						case 'add':									
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
												$tpl->assign("message","&nbsp;<br>Cliente a&ntilde;adido correctamente<br>&nbsp;");
												break;
									}
									//esto se hace independientemetne del valor que se obtenga
									$cat_clients=new cat_clients();
									$cat_clients->get_list_cat_clients();
									$tpl->assign("categorias",$cat_clients->cat_clients_list);
									//Cuando este hecho pay_types descomentar estas lineas
									//$pay_types=new pay_types();
									//$tpl->assign("tipo_pago",$pay_types->get_list_pay_types());
									$tpl->assign("objeto",$this);
									break;									
						case 'list':
									$tpl=$this->listar($tpl);
									$tpl->assign("objeto",$this);
									$tpl->assign("registro",$_SESSION['num_regs']);
									break;
						case 'modify':

									$this->read($_GET['id']);									
									$return=$this->modify();
									switch ($return){										
										case 0: //por defecto
												$this->payday=$this->fields_list->change_date($this->payday,"es");
												break;
										case -1: //Errores al intentar a�adir datos
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
												}
												break;
										default: //Si se ha a�adido
												$this->method="list";
												$tpl=$this->listar($tpl);										
												$tpl->assign("message","&nbsp;<br>Cliente modificado correctamente<br>&nbsp;");
												break;
									}
									//esto se hace independientemetne del valor que se obtenga
									$cat_clients=new cat_clients();
									$cat_clients->get_list_cat_clients();
									$tpl->assign("categorias",$cat_clients->cat_clients_list);
									//Cuando este hecho pay_types descomentar estas lineas
									//$pay_types=new pay_types();
									//$tpl->assign("tipo_pago",$pay_types->get_list_pay_types());
									$tpl->assign("objeto",$this);
									break;
						case 'delete':/*
									if ($_GET['id']==$_SESSION['ident_corp']){
										$this->emps_list="";
										$this->method="list";
										$tpl=$this->listar($tpl);
										$tpl->assign("message","&nbsp;<br>No se puede borrar la empresa por ser la empresa en uso. Desl&oacute;gese de esta empresa para poder borrarla.<br>&nbsp;");
										$tpl->assign("objeto",$this);
										break;
									}*/
									$this->read($_GET['id']);
									if ($this->remove($_GET['id'])!=0){				
										$this->corps_list="";
										$this->method="list";
										$tpl=$this->listar($tpl);
										$tpl->assign("message","&nbsp;<br>Cliente borrada correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
							
									break;
						case 'view':		
									$_SESSION['id_client']=$_GET['id'];						
									$tpl=$this->view($_GET['id'],$tpl);
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
				$tpl->assign('plantilla','clients_'.$this->method.'.tpl');					
			}
		else
			{
			
			}
		return $tpl;
	}
	function add(){
			if (!isset($_POST['submit_add'])){
			//Mostrar plantilla vac�a	

			return 0;
		}
		//en el caso de que SI este definido submit_add
		else{
						
			//Introducir los datos de post.
			$this->get_fields_from_post();	
						
			//Validacion
			/*
	var $fax;
	var $notes;
			*/
			$this->id_client=0;
			$this->fields_list->modify_value($this->ddbb_id_client,$this->id_client);
			$this->fields_list->modify_value($this->ddbb_id_corp,$this->id_corp);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_full_name,$this->full_name);
			$this->fields_list->modify_value($this->ddbb_cif_nif,$this->cif_nif);
			$this->fields_list->modify_value($this->ddbb_address,$this->address);
			$this->fields_list->modify_value($this->ddbb_fiscal_address,$this->fiscal_address);
			$this->fields_list->modify_value($this->ddbb_postal_address,$this->postal_address);
			$this->fields_list->modify_value($this->ddbb_url,$this->url);
			$this->fields_list->modify_value($this->ddbb_mail,$this->mail);
			$this->fields_list->modify_value($this->ddbb_city,$this->city);
			$this->fields_list->modify_value($this->ddbb_state,$this->state);
			$this->fields_list->modify_value($this->ddbb_postal_code,$this->postal_code);
			$this->fields_list->modify_value($this->ddbb_country,$this->country);
			$this->fields_list->modify_value($this->ddbb_phone,$this->phone);
			$this->fields_list->modify_value($this->ddbb_mobile_phone,$this->mobile_phone);
			$this->fields_list->modify_value($this->ddbb_fax,$this->fax);
			$this->fields_list->modify_value($this->ddbb_notes,$this->notes);
			$this->fields_list->modify_value($this->ddbb_id_pay_type,$this->id_pay_type);
			$this->fields_list->modify_value($this->ddbb_id_cat_client,$this->id_cat_client);
			$this->fields_list->modify_value($this->ddbb_payday,$this->payday);
			$return=$this->fields_list->validate();		
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			
			
			if (!$return){
				//Mostrar plantilla con datos erroneos
				return -1;
			}
			else{
			
			
			$this->payday=$this->fields_list->change_date($this->payday,"en");
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_client." = -1" ;
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
			$record[$this->ddbb_id_corp] = $this->id_corp;
			$record[$this->ddbb_name] = $this->name;
			$record[$this->ddbb_full_name]=$this->full_name;
			$record[$this->ddbb_address]=$this->address;
			$record[$this->ddbb_cif_nif]=$this->cif_nif;
			$record[$this->ddbb_fiscal_address]=$this->fiscal_address;
			$record[$this->ddbb_postal_address] = $this->postal_address;
			$record[$this->ddbb_url]=$this->url;
			$record[$this->ddbb_mail]=$this->mail;
			$record[$this->ddbb_city]=$this->city;
			$record[$this->ddbb_state]=$this->state;
			$record[$this->ddbb_postal_code]=$this->postal_code;
			$record[$this->ddbb_country] = $this->country;
			$record[$this->ddbb_phone]=$this->phone;
			$record[$this->ddbb_mobile_phone]=$this->mobile_phone;
			$record[$this->ddbb_fax]=$this->fax;
			$record[$this->ddbb_notes]=$this->notes;
			$record[$this->ddbb_payday]=$this->payday;
			$record[$this->ddbb_id_pay_type]=$this->id_pay_type;
			$record[$this->ddbb_id_cat_client]=$this->id_cat_client;
			//calculamos la sql de inserci�n respecto a los atributos
			$this->sql = $this->db->GetInsertSQL($this->result, $record);
			//print($this->sql);
			//insertamos el registro
			$this->db->Execute($this->sql);
			//si se ha insertado una fila
			if($this->db->Insert_ID()>=0){
				//capturammos el id de la linea insertada
				$this->id_client=$this->db->Insert_ID();
				
				//print("<pre>::".$this->id_corp."::</pre>");
				//devolvemos el id de la tabla ya que todo ha ido bien
				$this->db->close();
				return $this->id_client;
			}else {
				//devolvemos 0 ya que no se ha insertado el registro
				
				$this->error=-1;
				$this->db->close();
				return 0;
			}			
		
			}}
	}
	
	function get_fields_from_post(){
		
		//Cogemos los campos principales
			
		$this->name=htmlentities($_POST[$this->ddbb_name]);
		$this->id_corp=$_SESSION['ident_corp'];
		$this->full_name=htmlentities($_POST[$this->ddbb_full_name]);
		$this->address=htmlentities($_POST[$this->ddbb_address]);		
		$this->cif_nif=htmlentities($_POST[$this->ddbb_cif_nif]);
		$this->fiscal_address=htmlentities($_POST[$this->ddbb_fiscal_address]);	
		$this->postal_address=htmlentities($_POST[$this->ddbb_postal_address]);
		$this->url=htmlentities($_POST[$this->ddbb_url]);
		$this->mail=htmlentities($_POST[$this->ddbb_mail]);
		$this->city=htmlentities($_POST[$this->ddbb_city]);
		$this->state=htmlentities($_POST[$this->ddbb_state]);
		$this->postal_code=htmlentities($_POST[$this->ddbb_postal_code]);
		$this->country=htmlentities($_POST[$this->ddbb_country]);
		$this->phone=htmlentities($_POST[$this->ddbb_phone]);
		$this->mobile_phone=htmlentities($_POST[$this->ddbb_mobile_phone]);
		$this->fax=htmlentities($_POST[$this->ddbb_fax]);
		$this->notes=htmlentities($_POST[$this->ddbb_notes]);
		$this->id_pay_type=$_POST[$this->ddbb_id_pay_type];
		$this->id_cat_client=$_POST[$this->ddbb_id_cat_client];
		$this->payday=$_POST[$this->ddbb_payday];
		return 0;
	}	
	
	function remove($id){
	if (!isset($_POST["submit_delete"])){
				
									
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
		$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_corp." = ".$id." LIMIT 1";
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
			$this->modify_all_id_client($id,$this->table_names_modify[$i]);
		}
		//borramos todos aquellos registros en los que hay un id_user;		
		for ($i=0;$i<count($this->table_names_delete);$i++){
			$this->delete_all_id_client($id,$this->table_names_delete[$i]);
		}
	}
	
	function modify_all_id_client($id,$table){
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="UPDATE ".$table. " SET id_client = 0 WHERE id_client = ".$id;
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
	
	function delete_all_id_client($id,$table){
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi�n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi�n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.

			$this->sql="DELETE FROM ".$table. " WHERE id_client = ".$id;
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
	
	function modify()
	{
		if (!isset($_POST['submit_modify'])){
			//Mostrar plantilla vac�a		
			return 0;
		}
		else{
			//Introducir los datos de post.
			$this->get_fields_from_post();
			//$this->insert_post();
			
			//Validacion
			$this->fields_list->modify_value($this->ddbb_id_client,$this->id_client);
			$this->fields_list->modify_value($this->ddbb_id_corp,$this->id_corp);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_full_name,$this->full_name);
			$this->fields_list->modify_value($this->ddbb_cif_nif,$this->cif_nif);
			$this->fields_list->modify_value($this->ddbb_address,$this->address);
			$this->fields_list->modify_value($this->ddbb_fiscal_address,$this->fiscal_address);
			$this->fields_list->modify_value($this->ddbb_postal_address,$this->postal_address);
			$this->fields_list->modify_value($this->ddbb_url,$this->url);
			$this->fields_list->modify_value($this->ddbb_mail,$this->mail);
			$this->fields_list->modify_value($this->ddbb_city,$this->city);
			$this->fields_list->modify_value($this->ddbb_state,$this->state);
			$this->fields_list->modify_value($this->ddbb_postal_code,$this->postal_code);
			$this->fields_list->modify_value($this->ddbb_country,$this->country);
			$this->fields_list->modify_value($this->ddbb_phone,$this->phone);
			$this->fields_list->modify_value($this->ddbb_mobile_phone,$this->mobile_phone);
			$this->fields_list->modify_value($this->ddbb_fax,$this->fax);
			$this->fields_list->modify_value($this->ddbb_notes,$this->notes);
			$this->fields_list->modify_value($this->ddbb_id_pay_type,$this->id_pay_type);
			$this->fields_list->modify_value($this->ddbb_id_cat_client,$this->id_cat_client);
			$this->fields_list->modify_value($this->ddbb_payday,$this->payday);
			$return=$this->fields_list->validate();	
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *			
			if (!$return){
				//Mostrar plantilla con datos erroneos
				return -1;	
			}
			else{
		$this->payday=$this->fields_list->change_date($this->payday,"en");
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_client." = \"".$this->id_client."\"" ;
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
		$record[$this->ddbb_id_client]=$this->id_client;
		$record[$this->ddbb_id_corp]=$this->id_corp;
		$record[$this->ddbb_name] = $this->name;
		$record[$this->ddbb_full_name]=$this->full_name;
		$record[$this->ddbb_address]=$this->address;
		$record[$this->ddbb_cif_nif]=$this->cif_nif;
		$record[$this->ddbb_fiscal_address]=$this->fiscal_address;
		$record[$this->ddbb_postal_address] = $this->postal_address;
		$record[$this->ddbb_url]=$this->url;
		$record[$this->ddbb_mail]=$this->mail;
		$record[$this->ddbb_city]=$this->city;
		$record[$this->ddbb_state]=$this->state;
		$record[$this->ddbb_postal_code]=$this->postal_code;
		$record[$this->ddbb_country] = $this->country;
		$record[$this->ddbb_phone]=$this->phone;
		$record[$this->ddbb_mobile_phone]=$this->mobile_phone;
		$record[$this->ddbb_fax]=$this->fax;
		$record[$this->ddbb_notes]=$this->notes;
		$record[$this->ddbb_payday]=$this->payday;
		$record[$this->ddbb_id_pay_type]=$this->id_pay_type;
		$record[$this->ddbb_id_cat_client]=$this->id_cat_client;
		//calculamos la sql de inserci�n respecto a los atributos
		$this->sql = $this->db->GetUpdateSQL($this->result, $record);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Affected_Rows()==1 || $this->sql==""){
			//capturammos el id de la linea insertada
			$this->db->close();
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_client;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}
			}}
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
			// Leemos la empresa y se lo pasamos a la plantilla
			$this->read($id);
			$tpl->assign('objeto',$this);
			$_SESSION['id_client']=$this->id_client;
			
			//listado de contactos
			$tabla_contactos = new table(false);
			
			$contactos = new contacts();

			if ($contactos->get_list_contacts($_SESSION['id_client'])==0)
			{
				
				$per = new permissions();
				$per->get_permissions_list('clients');
				$cadena=$cadena.$tabla_contactos->tabla_vacia('contacts',$per->add);
				$variables_empleados=$tabla_contactos->nombres_variables;
			}
			else
			{	
				$per = new permissions();
				$per->get_permissions_list('clients');
							
				$cadena=$cadena.$tabla_contactos->make_tables('contacts',$contactos->contacts_list,array('Nombre',20,'Primer Apellido',20,'Segundo Apellido',20),array('id_contact', 'name','last_name','last_name2'),$_SESSION['num_regs'],$per->permissions_module,$per->add);
		
				$variables_contactos=$tabla_contactos->nombres_variables;
			}
			
			
			$facturaspen= new table(false);
			$facturascob= new table(false);
			$albaranes= new table(false);
			$partes= new table(false);			
			
			$cadena=$cadena.$facturaspen->dont_show('facturaspen');
			$cadena=$cadena.$facturascob->dont_show('facturascob');
			$cadena=$cadena.$albaranes->dont_show('albaranes');
			$cadena=$cadena.$partes->dont_show('partes');
			
			
			$variables_facturaspen=$facturaspen->nombres_variables;
			$variables_facturascob=$facturascobs->nombres_variables;
			$variables_albaranes=$albaranes->nombres_variables;
			$variables_partes=$partes->nombres_variables;
			
			
			
			$i=0;
			while($i<(count($variables_contactos)+count($variables_facturaspen)+count($variables_facturascob)+count($variables_products)+count($variables_services)+count($variables_albaranes)+count($variables_partes)))
			{
				for($j=0;$j<count($variables_contactos);$j++)
				{
					$variables[$i]=$variables_contactos[$j];
					$i++;
				}
				
				for($j=0;$j<count($variables_facturaspen);$j++)
				{
					$variables[$i]=$variables_facturaspen[$j];
					$i++;
				}
				for($j=0;$j<count($variables_facturascob);$j++)
				{
					$variables[$i]=$variables_facturascob[$j];
					$i++;
				}
				
				for($j=0;$j<count($variables_albaranes);$j++)
				{
					$variables[$i]=$variables_albaranes[$j];
					$i++;
				}
				for($j=0;$j<count($variables_partes);$j++)
				{
					$variables[$i]=$variables_partes[$j];
					$i++;
				}				
			}
			
			//Se comprueba si hay permiso para borrar o modificar
			$permisos_mod_del = new permissions();
			$permisos_mod_del->get_permissions_modify_delete('clients');
			
			$tpl->assign('acciones',$permisos_mod_del->per_mod_del);
			
			$tpl->assign('variables',$variables);
			$tpl->assign('cadena',$cadena);
			
			//			
			return $tpl;
				
	}

	
	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}		
		if ($corp != ""){
			$corp='<a href="index.php?module=corps&method=view&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = '<a href="index.php?module=user_corps">Zona privada</a> :: '.$corp.' <a href="index.php?module=clients">Clientes</a>';
		$nav_bar=$nav_bar.$this->localice($method);
		return $nav_bar;
	}		

	function title($method,$corp){
		if ($corp != ""){
			$corp=$corp." ::";
		}
		$title = "Zona Privada :: $corp Empresas";
		$title=$title.$this->localice($method);		
		return $title;
	}		
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Cliente";
									break;
						case 'list':
									$localice=" :: Buscar Clientes";
									break;
						case 'modify':
									$localice=" :: Modificar Cliente";
									break;
						case 'delete':
									$localice=" :: Borrar Cliente";
									break;
						case 'view':
									$localice=" :: Ver Cliente";									
									break;
						default:
									$localice=" :: Buscar Cliente";
									break;
		}
		return $localice;
	}
	  
}
?>