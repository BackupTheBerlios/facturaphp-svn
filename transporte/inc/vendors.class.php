<?php
//clase que da soporte a las empresas del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");

class vendors{
//internal vars
    var $id_vendor;
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
	var $table_name='vendors';
	var $ddbb_id_vendor='id_vendor';
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
	var $ddbb_notes='notes';
	var $ddbb_search='search';
	var $db;
	var $result;  	
//variables complementarias	
  	var $corps_list;
  	var $num;
  	var $fields_list;
  	var $error;
	var $method;
  	//constructor
	function vendors(){
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
		$this->fields_list->add($this->ddbb_id_vendor, $this->id_vendor, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_id_corp, $this->id_corp, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_name, $this->name, 'varchar', 20,0,1);
		$this->fields_list->add($this->ddbb_full_name, $this->full_name, 'varchar', 50,0,1);
		$this->fields_list->add($this->ddbb_cif_nif, $this->cif_nif, 'varchar', 10,0);		
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
		
		$this->search[0]= 'name';
		$this->search[1]= 'full_name';
		$this->search[2]= 'cif_nif';
		
		return $this;	 
		
	}
	
	function get_list_vendors ($id_corp)
	{
		if (isset($_POST['submit_vendors_search']))
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
		$this->vendors_list = null;
		$this->num=0;
		while (!$this->result->EOF) {
			//cogemos los datos del usuario
			$this->vendors_list[$this->num][$this->ddbb_id_vendor]=$this->result->fields[$this->ddbb_id_vendor];
			$this->vendors_list[$this->num][$this->ddbb_id_corp]=$this->result->fields[$this->ddbb_id_corp];
			$this->vendors_list[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
			$this->vendors_list[$this->num][$this->ddbb_full_name]=$this->result->fields[$this->ddbb_full_name];
			$this->vendors_list[$this->num][$this->ddbb_address]=$this->result->fields[$this->ddbb_address];
			$this->vendors_list[$this->num][$this->ddbb_cif_nif]=$this->result->fields[$this->ddbb_cif_nif];
			$this->vendors_list[$this->num][$this->ddbb_fiscal_address]=$this->result->fields[$this->ddbb_fiscal_address];
			$this->vendors_list[$this->num][$this->ddbb_postal_address]=$this->result->fields[$this->ddbb_postal_address];
			$this->vendors_list[$this->num][$this->ddbb_url]=$this->result->fields[$this->ddbb_url];
			$this->vendors_listt[$this->num][$this->ddbb_mail]=$this->result->fields[$this->ddbb_mail];
			$this->vendors_list[$this->num][$this->ddbb_city]=$this->result->fields[$this->ddbb_city];
			$this->vendors_list[$this->num][$this->ddbb_state]=$this->result->fields[$this->ddbb_state];
			$this->vendors_list[$this->num][$this->ddbb_postal_code]=$this->result->fields[$this->ddbb_postal_code];
			$this->vendors_list[$this->num][$this->ddbb_country]=$this->result->fields[$this->ddbb_country];
			$this->vendors_list[$this->num][$this->ddbb_phone]=$this->result->fields[$this->ddbb_phone];
			$this->vendors_list[$this->num][$this->ddbb_mobile_phone]=$this->result->fields[$this->ddbb_mobile_phone];
			$this->vendors_list[$this->num][$this->ddbb_fax]=$this->result->fields[$this->ddbb_fax];
			$this->vendors_list[$this->num][$this->ddbb_notes]=$this->result->fields[$this->ddbb_notes];
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
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_vendor."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_vendor=$id;
			$this->id_corp=$_SESSION['ident_corp'];
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
			$this->db->close();
			return 1;
		}
			
	
	
	}
	
	function listar($tpl){
		if (isset($_POST['submit_vendors_search']))
		{
			//Se toma el número de registros y se guarda en varable de sesión
			//que se cumpla en todos los accesos del usuario
			$_SESSION['num_regs']= $_POST['regs'];
			
		}
		$tabla_listado = new table(true);
		$per = new permissions();
		$per->get_permissions_list('vendors');
		if (!$this->get_list_vendors($_SESSION['ident_corp']))
		{
			$cadena=$cadena.$tabla_listado->tabla_vacia('vendors', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{
			$cadena=''.$tabla_listado->make_tables('vendors',$this->vendors_list,array('Nombre',20,'Nombre completo',20,'CIF|NIF',20,'Telefono',20),array($this->ddbb_id_vendor,$this->ddbb_name,$this->ddbb_full_name,$this->ddbb_cif_nif,$this->ddbb_phone),$_SESSION['num_regs'],$per->permissions_module,$per->add);
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
										case -1: //Errores al intentar añadir datos
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
												}
												break;
										default: //Si se ha añadido
												$this->method="list";
												$tpl=$this->listar($tpl);										
												$tpl->assign("message","&nbsp;<br>Proveedor a&ntilde;adido correctamente<br>&nbsp;");
												break;
									}
									//esto se hace independientemetne del valor que se obtenga
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
												break;
										case -1: //Errores al intentar añadir datos
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
												}
												break;
										default: //Si se ha añadido
												$this->method="list";
												$tpl=$this->listar($tpl);										
												$tpl->assign("message","&nbsp;<br>Proveedor modificado correctamente<br>&nbsp;");
												break;
									}
									//esto se hace independientemetne del valor que se obtenga
									$tpl->assign("objeto",$this);
									break;
									
						case 'delete':
									$this->read($_GET['id']);
									if ($this->remove($_GET['id'])!=0){				
										$this->corps_list="";
										$this->method="list";
										$tpl=$this->listar($tpl);
										$tpl->assign("message","&nbsp;<br>Proveedor borrado correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
							
									break;
						case 'view':								
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
				$tpl->assign('plantilla','vendors_'.$this->method.'.tpl');					
			}
		else
			{
			
			}
		return $tpl;
	}
	function add(){
			if (!isset($_POST['submit_add'])){
			//Mostrar plantilla vacía	

			return 0;
		}
		//en el caso de que SI este definido submit_add
		else{
						
			$this->get_fields_from_post();	
						
			//Validacion
			/*
	var $fax;
	var $notes;
			*/
			$this->id_vendor=0;
			
			$this->fields_list->modify_value($this->ddbb_id_vendor,$this->id_vendor);
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
			$return=$this->fields_list->validate();		
			
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
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_vendor." = -1" ;
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
			$record[$this->ddbb_id_corp] = $_SESSION['ident_corp'];
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
			//calculamos la sql de insercin respecto a los atributos
			$this->sql = $this->db->GetInsertSQL($this->result, $record);
			//print($this->sql);
			//insertamos el registro
			$this->db->Execute($this->sql);
			//si se ha insertado una fila
			if($this->db->Insert_ID()>=0){
				//capturammos el id de la linea insertada
				$this->id_vendor=$this->db->Insert_ID();
				
				//print("<pre>::".$this->id_corp."::</pre>");
				//devolvemos el id de la tabla ya que todo ha ido bien
				$this->db->close();
				return $this->id_vendor;
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
		$this->id_corp=$_SESSION['ident_corp'];
		$this->name=htmlentities($_POST[$this->ddbb_name]);
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


		return 0;
	}	
	
	function remove($id){
	if (!isset($_POST["submit_delete"])){
				
									
				return 0;
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
		//calcula la consulta de borrado.
		$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_vendor." = ".$id." LIMIT 1";
		//la ejecuta y guarda los resultados
		
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->db->Affected_Rows() == 0){
			$this->error=1;
			$this->db->close();
			return 0;
		}else{
		//	$this->make_remove($id);
			$this->error=0;
			$this->db->close();
			return 1;
			
		}
			}
	}

	function modify()
	{
		if (!isset($_POST['submit_modify'])){
			//Mostrar plantilla vacía		
			
			return 0;
		}
		else{
			//Introducir los datos de post.
			$this->get_fields_from_post();
			//$this->insert_post();
			
			//Validacion
			$this->fields_list->modify_value($this->ddbb_id_vendor,$this->id_vendor);
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
			$return=$this->fields_list->validate();	
			
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_vendor." = \"".$this->id_vendor."\"" ;
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
		$record[$this->ddbb_id_vendor]=$this->id_vendor;
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
		//calculamos la sql de insercin respecto a los atributos
		$this->sql = $this->db->GetUpdateSQL($this->result, $record);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Affected_Rows()==1){
			//capturammos el id de la linea insertada
			$this->db->close();
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_vendor;
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
			Order By (y mantener la búsqueda en el caso de que hubiera hecha una y averiguar la "pestaña" a la que hace referencia)
			Busquedas
	*/
			
	
			$cadena='';			
			// Leemos la empresa y se lo pasamos a la plantilla
			$this->read($id);
			$tpl->assign('objeto',$this);
			
			//Se comprueba si hay permiso para borrar o modificar
			$permisos_mod_del = new permissions();
			$permisos_mod_del->get_permissions_modify_delete('vendors');
			
			$tpl->assign('acciones',$permisos_mod_del->per_mod_del);
		
			//			
			return $tpl;
				
	}

	
	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}		
		if ($corp != ""){
			$corp='<a href="index.php?module=corps&method=view&id='.$_SESSION['ident_corp'].'">'.$corp.'</a> ::';
		}
		$nav_bar = '<a href="index.php?module=user_corps">Zona privada</a> :: '.$corp.' <a href="index.php?module=vendors">Proveedores</a>';
		$nav_bar=$nav_bar.$this->localice($method);
		return $nav_bar;
	}		

	function title($method,$corp){
		if ($corp != ""){
			$corp=$corp." ::";
		}
		$title = "Zona Privada :: $corp Proveedores";
		$title=$title.$this->localice($method);		
		return $title;
	}		
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Proveedor";
									break;
						case 'list':
									$localice=" :: Buscar Proveedor";
									break;
						case 'modify':
									$localice=" :: Modificar Proveedor";
									break;
						case 'delete':
									$localice=" :: Borrar Proveedor";
									break;
						case 'view':
									$localice=" :: Ver Proveedor";									
									break;
						default:
									$localice=" :: Buscar Proveedor";
									break;
		}
		return $localice;
	}
	  
}
?>