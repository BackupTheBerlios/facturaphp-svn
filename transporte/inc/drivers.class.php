<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");

class drivers{
//internal vars
	var $id_driver;
	var $id_emp;
	var $id_vehicle;
	var $name;
	var $last_name;
	var $last_name2;
	var $num_vehicles;
	var $date="00-00-0000";
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
	var $table_name='drivers';
	var $ddbb_id_driver = 'id_driver';
	var $ddbb_id_emp = 'id_emp';
	var $ddbb_id_vehicle = 'id_vehicle';
	var $ddbb_alias = 'alias';
	var $ddbb_path_photo = 'path_photo';
	var $ddbb_date = 'date';
	var $ddbb_search='search';
//Información necesaria sobre empleado conductor y vehículo conducido
	var $ddbb_name = 'name';
	var $ddbb_last_name = 'last_name';
	var $ddbb_last_name2 = 'last_name2';
//Consultas a la BBDD
	var $db;
	var $result; 
	var $result1; 
	var $sql;
		
//variables complementarias	
	var $emps_trans;
  	var $drivers_list;
	var $vehicles_list;
	var $vehicles_corp;
	var $fecha_cambiada;
  	var $num;
  	var $fields_list;
  	var $error;
//	var $corps_list;
//	var $num_corps;
	var $drivers_emps_list;
//	var $emps_corp_list;
	var $obj_emp;
	var $come;
	var $method;
	
  	//constructor
	function drivers(){
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
		$this->fields_list->add($this->ddbb_id_driver, $this->id_driver, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_emp, $this->id_emp, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_vehicle, $this->id_vehicle, 'int', 11,0);
		$this->fields_list->add($this->ddbb_date, $this->date, 'date', 20,0);
	
		$this->search[0]= 'name';
		$this->search[1]= 'last_name';
		$this->search[2]= 'last_name2';
		
		return $this;	 
		
	}
	
	function get_list_drivers ()
	{
		if (isset($_POST['submit_drivers_search']))
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
			$empleados = new emps();
			$query = $my_search->get_query($this->search_query, FALSE, $this->search, $empleados->fields_list);
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
			$this->sql="SELECT drivers.* FROM emps, drivers WHERE (".$query.") AND emps.id_corp =".$_SESSION['ident_corp']." AND emps.id_emp=drivers.id_emp";
		else
			$this->sql="SELECT drivers.* FROM emps, drivers WHERE emps.id_corp =".$_SESSION['ident_corp']." AND emps.id_emp=drivers.id_emp";

		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		$num_emps=0;
		$drivers = null;
		$this->num = 0;
		$temp = null;
		$this->drivers_list = null;
		while (!$this->result->EOF) 
		{
			//Si hay más de un id_driver asociado a un empleado de la empresa evitamos que salga más de una vez, 
			//para ello por cada emp nuevo se incrementa en uno su contador
			$temp[$num_emps][$this->ddbb_id_driver]=$this->result->fields[$this->ddbb_id_driver];
			$temp[$num_emps][$this->ddbb_id_emp]=$this->result->fields[$this->ddbb_id_emp];
			$temp[$num_emps][$this->ddbb_id_vehicle]=$this->result->fields[$this->ddbb_id_vehicle];
			$temp[$num_emps][$this->ddbb_id_date]=$this->result->fields[$this->ddbb_id_date];

			$drivers[$temp[$num_emps][$this->ddbb_id_emp]]['cont']++;

		
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$num_emps++;		
		}	//while
		
		for($i=0; $i<=$num_emps;$i++)
		{
			if(($drivers[$temp[$i][$this->ddbb_id_emp]]['cont'] == 1))
			{
				//Si aparece y cont es 1 entonces es la primera vez que aparece
				//cogemos los datos del conductor (directamente de la BBDD)
				$this->drivers_list[$this->num][$this->ddbb_id_driver]=$temp[$i][$this->ddbb_id_driver];
				$this->drivers_list[$this->num][$this->ddbb_id_emp]=$temp[$i][$this->ddbb_id_emp];
				$this->drivers_list[$this->num][$this->ddbb_id_vehicle]=$temp[$i][$this->ddbb_id_vehicle];
				$this->drivers_list[$this->num][$this->ddbb_id_date]=$temp[$i][$this->ddbb_id_date];
			
				//Tratamos los datos para poder presentarselos al usuario
				$this->preparar_datos($this->drivers_list[$this->num][$this->ddbb_id_emp], $this->drivers_list[$this->num][$this->ddbb_id_vehicle]);
	
				$this->num++;
			}
			else
				$drivers[$temp[$i][$this->ddbb_id_emp]]['cont']--;
		}
		$this->db->close();
		return $this->num;
	
	
	}
	
	function get_fields_from_search_post(){
		//Cogemos los campos principales de búsqueda
		$this->search_query=$_POST[$this->ddbb_search];
		return 0;
	}
	
	function get_list_drivers_vehicle ($id_vehicle)
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE id_vehicle = ".$id_vehicle;

		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		$num_emps=0;
		$this->num = 0;
		$temp = null;
		$this->drivers_list = null;
		while (!$this->result->EOF) 
		{
			//Si hay más de un id_driver asociado a un empleado de la empresa evitamos que salga más de una vez, 
			//para ello por cada emp nuevo se incrementa en uno su contador
			$temp[$num_emps][$this->ddbb_id_driver]=$this->result->fields[$this->ddbb_id_driver];
			$temp[$num_emps][$this->ddbb_id_emp]=$this->result->fields[$this->ddbb_id_emp];
			$temp[$num_emps][$this->ddbb_id_vehicle]=$this->result->fields[$this->ddbb_id_vehicle];
			$temp[$num_emps][$this->ddbb_id_date]=$this->result->fields[$this->ddbb_id_date];

			$drivers[$temp[$num_emps][$this->ddbb_id_emp]]['cont']++;

		
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$num_emps++;		
		}	//while
		
		for($i=0; $i<=$num_emps;$i++)
		{
			if(($drivers[$temp[$i][$this->ddbb_id_emp]]['cont'] == 1))
			{
				//Si aparece y cont es 1 entonces es la primera vez que aparece
				//cogemos los datos del conductor (directamente de la BBDD)
				$this->drivers_list[$this->num][$this->ddbb_id_driver]=$temp[$i][$this->ddbb_id_driver];
				$this->drivers_list[$this->num][$this->ddbb_id_emp]=$temp[$i][$this->ddbb_id_emp];
				$this->drivers_list[$this->num][$this->ddbb_id_vehicle]=$temp[$i][$this->ddbb_id_vehicle];
				$this->drivers_list[$this->num][$this->ddbb_id_date]=$temp[$i][$this->ddbb_id_date];
			
				//Tratamos los datos para poder presentarselos al usuario
				$this->preparar_datos_vehicle($this->drivers_list[$this->num][$this->ddbb_id_emp]);
	
				$this->num++;
			}
			else
				$drivers[$temp[$i][$this->ddbb_id_emp]]['cont'] --;
		}
		
		$this->db->close();
		return $this->num;
	
	}
	
	function preparar_datos_vehicle($id_emp)
	{
		$empleado = new emps();
		$empleado->read($id_emp);
		
		$this->drivers_list[$this->num][$this->ddbb_name] = $empleado->name;
		$this->drivers_list[$this->num][$this->ddbb_last_name] = $empleado->last_name;
		$this->drivers_list[$this->num][$this->ddbb_last_name2] = $empleado->last_name2;
		
		$this->name = $empleado->name;
		$this->last_name = $empleado->last_name;
		$this->last_name2 = $empleado->last_name2;
	}
	
	
	function preparar_datos($id_emp)
	{
		$empleado = new emps();
		$empleado->read($id_emp);

		$this->drivers_list[$this->num][$this->ddbb_name] = $empleado->name;
		$this->drivers_list[$this->num][$this->ddbb_last_name] = $empleado->last_name;
		$this->drivers_list[$this->num][$this->ddbb_last_name2] = $empleado->last_name2;
		
		$this->name = $empleado->name;
		$this->last_name = $empleado->last_name;
		$this->last_name2 = $empleado->last_name2;
		
		$this->get_list_vehicles($id_emp);
		
	}
	
	function get_list_emps_trans()
	{
		//Buscar todos los empleados con categoría transportista

		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);

		//mete la consulta
		$this->sql='SELECT emps.id_emp, emps.name, emps.last_name, emps.last_name2 FROM emps WHERE emps.id_corp = '.$_SESSION['ident_corp'];

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
			//cogemos los datos del conductor (directamente de la BBDD)
			$this->emps_trans[$this->num][$this->ddbb_id_emp]=$this->result->fields[$this->ddbb_id_emp];
			$this->emps_trans[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
			$this->emps_trans[$this->num][$this->ddbb_last_name]=$this->result->fields[$this->ddbb_last_name];
			$this->emps_trans[$this->num][$this->ddbb_last_name2]=$this->result->fields[$this->ddbb_last_name2];
			$this->emps_trans[$this->num]['nombre_completo'] = $this->emps_trans[$this->num][$this->ddbb_name]." ".$this->emps_trans[$this->num][$this->ddbb_last_name]." ".$this->emps_trans[$this->num][$this->ddbb_last_name2];
		
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	}
	
	function get_list_vehicles($id_emp)
	{
		//Buscar todos los id_drivers asociados al empleado

		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT id_vehicle, id_driver, date FROM ".$this->table_prefix.$this->table_name." WHERE id_emp = ".$id_emp;

		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		$this->vehicles_list = null;
		$this->num_vehicles=0;
		while (!$this->result->EOF) {
			//cogemos los datos del conductor (directamente de la BBDD)
			$this->vehicles_list[$this->num_vehicles][$this->ddbb_id_driver]=$this->result->fields[$this->ddbb_id_driver];
			$this->vehicles_list[$this->num_vehicles][$this->ddbb_alias]=$this->result->fields[$this->ddbb_id_emp];
			$this->vehicles_list[$this->num_vehicles][$this->ddbb_id_vehicle]=$this->result->fields[$this->ddbb_id_vehicle];
			$this->vehicles_list[$this->num_vehicles][$this->ddbb_date]=$this->result->fields[$this->ddbb_date];
			
			//Por cada uno buscar el alias y demás datos (enlazar con vehículos)
			$vehiculo = new vehicles();
			$vehiculo->read($this->vehicles_list[$this->num_vehicles][$this->ddbb_id_vehicle]);
			//Añadir vehículo al listado		
			$this->vehicles_list[$this->num_vehicles][$this->ddbb_alias]=$vehiculo->alias;
			$this->vehicles_list[$this->num_vehicles][$this->ddbb_path_photo]=$vehiculo->path_photo;

			//Se cambia el formato de la fecha
			if ($this->vehicles_list[$this->num_vehicles][$this->ddbb_date]!="0000-00-00")
			{
				list($anno,$mes,$dia)=sscanf($this->vehicles_list[$this->num_vehicles][$this->ddbb_date],"%d-%d-%d");
				$this->vehicles_list[$this->num_vehicles]['fecha_cambiada']="$dia-$mes-$anno";
			}
			else{
				$this->vehicles_list[$this->num_vehicles]['fecha_cambiada']="00-00-0000";
			}	
			
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num_vehicles++;
		}
		$this->db->close();
		return $this->num_vehicles;
	}
	
	function add(){
		
		//Miramos a ver si esta definida el "submit_add" y si no lo esta, pasamos directamente a mostrar la plantilla
		if (!isset($_POST['submit_add'])){
			//Mostrar plantilla vacía	
			//Buscar los empleados de la empresa en cuestión, que tengan categoría de conductores (transportistas)
			/*$this->get_list_emps_trans();
			$this->vehicles_corp = new vehicles();
			$this->vehicles_corp->get_list_vehicles($_SESSION['ident_corp']);*/
			return 0;
		}
		//en el caso de que SI este definido submit_add
		else{
						
			//Introducir los datos de post.
			$this->get_fields_from_post();	
						
			//Validacion
			$this->id_driver=0;
			$this->fields_list->modify_value($this->ddbb_id_laborer,$this->id_driver);
			$this->fields_list->modify_value($this->ddbb_id_emp,$this->id_emp);
			$this->fields_list->modify_value($this->ddbb_id_vehicle,$this->id_vehicle);
			$this->fields_list->modify_value($this->ddbb_date,$this->date);
			//validamos
			$return=$this->fields_list->validate();	//Para pruebas dejar esta linea sin comentar
			//$return=validate_fields();
			
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
		
			
			if (!$return){
				//Mostrar plantilla con datos erroneos
				return -1;		
			}
		    else{
				//Si todo es correcto si meten los datos
				$this->date=$this->fields_list->change_date($this->date,"en");
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexin con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexin de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexin permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_driver." = -1" ;
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
				$record[$this->ddbb_id_vehicle]=$this->id_vehicle;
				$record[$this->ddbb_date]=$this->date;
					
				//calculamos la sql de insercin respecto a los atributos
				$this->sql = $this->db->GetInsertSQL($this->result, $record);
				//print($this->sql);
				//insertamos el registro
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				if($this->db->Insert_ID()>=0){
					//Cogemos el id del conductor insertado.					
					$this->id_driver=$this->db->Insert_ID();
				
					//devolvemos el id de la tabla ya que todo ha ido bien
					$this->db->close();
					return $this->id_driver;
				}else {
					
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}						
			}
		}
	}
	
	function modify(){	
		if (!isset($_POST['submit_modify'])){
			$this->date=$this->fields_list->change_date($this->date,"es");
			//Mostrar plantilla vacía	
			//Buscar los empleados de la empresa en cuestión, que tengan categoría de conductores (transportistas)
			
			return 0;
		}
		else{
			//Introducir los datos de post.
			$this->get_fields_from_post();			
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			$this->fields_list->modify_value($this->ddbb_id_driver,$this->id_driver);
			$this->fields_list->modify_value($this->ddbb_id_emp,$this->id_emp);
			$this->fields_list->modify_value($this->ddbb_id_vehicle,$this->id_vehicle);
			$this->fields_list->modify_value($this->ddbb_date,$this->date);
			//validamos
			$return=$this->fields_list->validate();	//Para pruebas dejar esta linea sin comentar
			
			if (!$return){
				//Mostrar plantilla con datos erroneos
				return -1;
			}
			else{
				$this->date=$this->fields_list->change_date($this->date,"en");
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexin con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexin de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexin permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_driver." = \"".$this->id_driver."\"" ;
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
				$record[$this->ddbb_id_vehicle]=$this->id_vehicle;
				$record[$this->ddbb_date]=$this->date;

				//calculamos la sql de insercin respecto a los atributos
				$this->sql = $this->db->GetUpdateSQL($this->result, $record);
				//insertamos el registro
				
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				$Affected_Rows=$this->db->Affected_Rows();
					
				if(($Affected_Rows==1)||($this->sql=="")){
					//capturammos el id de la linea insertada
					$this->db->close();
					//devolvemos el id de la tabla ya que todo ha ido bien
					return $this->id_driver;
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
			$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_driver." = ".$id;
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
		$this->sql="SELECT * FROM `drivers` WHERE `id_driver`=".$id;
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false)
		{
			$error=1;
			$this->db->close();
			return 0;
		}
		else
		{
			$this->id_driver = $id;
			$this->id_emp = $this->result->fields[$this->ddbb_id_emp];
			$this->id_vehicle = $this->result->fields[$this->ddbb_id_vehicle];
			$this->date = $this->result->fields[$this->ddbb_date];
			//Prepara datos
			$this->preparar_datos($this->id_emp);
			
			$this->db->close();
				
			return 1;
		}
		
	
	}


	function view ($id,$tpl){
			$cadena='';			
			// Leemos el conductor y se lo pasamos a la plantilla
			$this->read($id);
			$tpl->assign('objeto',$this);

			//Puede darse el caso de contratar un condutor temporalmente y no asignarle un usuario de la empresa
			$empleado = new emps();
			$empleado->read($this->id_emp);
			if(($empleado->id_user==0)||($empleado->id_user=='')){
				$tpl->assign("emp_driver","Sin Usuario");
			}
			else
			{
				$usuario = new users();
				$usuario->read_fields($empleado->id_user);
				$tpl->assign("emp_driver",$usuario->login);
			}
			
			
			
			//Como puede que un mismo empleado tenga a su cargo más de un vehículo, no se podrá optar por este camino a borrar o modificar
			/*$permisos_mod_del = new permissions();
			$permisos_mod_del->get_permissions_modify_delete('drivers');
			$tpl->assign('acciones',$permisos_mod_del->per_mod_del);*/
			
			//Para borrar o modificar se debe acceder mediante la tabla
			
			//Se prepara la lista de vehiculos
			$tabla_listado = new table(true);
			$per = new permissions();
			$per->get_permissions_list('drivers');
	
				
			//Toda persona con permso podrá modificar o borrar los datos del conductor, podrá hacerlo
			$j=0;
			for ($i=0;$i<count($per->permissions_module);$i++)
			{
				if(($per->permissions_module[$i]=="modify")||($per->permissions_module[$i]=="delete"))
				{
					$permisos[$j]=$per->permissions_module[$i];
					$j++;
				} 
			}

		
			if ($this->num_vehicles==0)
			{
				$cadena=''.$cadena.$tabla_listado->tabla_vacia('drivers', $per->add);
				$variables=$tabla_listado->nombres_variables;
			}
			else
			{	
				$cadena=''.$tabla_listado->make_tables('drivers',$this->vehicles_list,array('Alias del vehículo',60,'Fecha de asignacion',20),array($this->ddbb_id_driver, $this->ddbb_alias, 'fecha_cambiada'),$_SESSION['num_regs'],$permisos,$per->add);
				$variables=$tabla_listado->nombres_variables;	
			}				
			$tpl->assign('variables',$variables);
			$tpl->assign('cadena',$cadena);		
						
			return $tpl;
				
	}
	
	function listar($tpl)
	{
		if (isset($_POST['submit_drivers_search']))
		{
			//Se toma el número de registros y se guarda en varable de sesión
			//que se cumpla en todos los accesos del usuario
			$_SESSION['num_regs']= $_POST['regs'];
			
		}
		$num = $this->get_list_drivers();
		$tabla_listado = new table(true);
		$per = new permissions();
		$num_per = $per->get_permissions_list('drivers');
		
		$per_vi_del = null;
		for($i=0; $i<$num_per;$i++)
			if($per->permissions_module[$i] == 'view')
				$per_vi_del = array($per->permissions_module[$i]);
			
		
		if ($num==0)
		{
			$cadena=''.$tabla_listado->tabla_vacia('drivers', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{	
			$cadena=''.$tabla_listado->make_tables('drivers',$this->drivers_list,array('Nombre',20,'Primer Apellido',20,'Segundo Apellido',20),array($this->ddbb_id_driver, $this->ddbb_name, $this->ddbb_last_name, $this->ddbb_last_name2),$_SESSION['num_regs'],$per_vi_del,$per->add);
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
							/*if ($this->add() !=0){
								$this->method="list";
								$tpl=$this->listar($tpl);										
								$tpl->assign("message","&nbsp;<br>Conductor a&ntilde;adido correctamente<br>&nbsp;");
							}					
							$tpl->assign("objeto",$this);									
							$tpl->assign("empleados",$this->emps_trans);
							$tpl->assign("vehiculos", $this->vehicles_corp->vehicles_list);
							break;*/
							
							$this->get_list_emps_trans();
							$this->vehicles_corp = new vehicles();
							$this->vehicles_corp->get_list_vehicles($_SESSION['ident_corp']);
							$return=$this->add();
							switch ($return){										
								case 0:
										$tpl->assign("empleados",$this->emps_trans);
										$tpl->assign("vehiculos", $this->vehicles_corp->vehicles_list);											
										break;
								case -1: //Errores al intentar añadir datos
										for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
											$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
										}												
										$tpl->assign("empleados",$this->emps_trans);
										$tpl->assign("vehiculos", $this->vehicles_corp->vehicles_list);
										break;
								default: //Si se ha añadido
										$this->method="list";
										$tpl=$this->listar($tpl);										
										$tpl->assign("message","&nbsp;<br>Conductor a&ntilde;adido correctamente<br>&nbsp;");
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
							/*$this->read($_GET['id']);
							if ($this->modify() !=0){
								$this->method="list";
								$tpl=$this->listar($tpl);										
								$tpl->assign("message","&nbsp;<br>Conductor modificado correctamente<br>&nbsp;");
							}
						
							//Se cambia el formato de la fecha
							if ($this->date!="0000-00-00")
							{
								list($anno,$mes,$dia)=sscanf($this->date,"%d-%d-%d");
								$this->fecha_cambiada="$dia-$mes-$anno";
							}
							else
							{
								$this->fecha_cambiada="00-00-0000";
							}	
							$tpl->assign("objeto",$this);									
							$tpl->assign("empleados",$this->emps_trans);
							$tpl->assign("vehiculos", $this->vehicles_corp->vehicles_list);
							break;*/
							$this->get_list_emps_trans();
							$this->vehicles_corp = new vehicles();
							$this->vehicles_corp->get_list_vehicles($_SESSION['ident_corp']);
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
										$tpl->assign("message","&nbsp;<br>Conductor modificado correctamente<br>&nbsp;");
										break;
							}
							$tpl->assign("empleados",$this->emps_trans);
							$tpl->assign("vehiculos", $this->vehicles_corp->vehicles_list);
							$tpl->assign("objeto",$this);
							break;
				case 'delete':
							$this->read($_GET['id']);
							if ($this->remove($_GET['id'])==0){
								$tpl->assign("message",$this->conductores);
							}
							else{
								
								$this->method="list";
								$tpl=$this->listar($tpl);
								$tpl->assign("message","&nbsp;<br>Conductor borrado correctamente<br>&nbsp;");
							}
							$tpl->assign("objeto",$this);
							break;
				case 'view':									
							$tpl=$this->view($_GET['id'],$tpl);
							break;
				default:
							if($_SESSION['ident_corp'] !=0)
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
		$tpl->assign('plantilla','drivers_'.$this->method.'.tpl');					
		
		return $tpl;
	}
	
	function get_fields_from_post()
	{		
		//Cogemos la fecha de asignación
		$this->date=$_POST["date"];
		//Si el usuario ya estaba creado, se lo asignamos		
		$this->id_emp=$_POST["empleados"];					
		//Cogemos el vehículo
		$this->id_vehicle=$_POST["vehiculos"];
	}

	function bar($method,$corp){	
		if ($method!=$this->method){
			$method=$this->method;
		}	
		if ($corp != ""){
			$corp='<a href="index.php?module=corps&method=view&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = '<a href="index.php?module=user_corps">Zona privada</a> :: '.$corp.' <a href="index.php?module=drivers">Conductores</a>';
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
		$title = "Zona Privada :: $corp Conductores";
		$title=$title.$this->localice($method);		
		return $title;
	}		
	
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Conductores";
									break;
						case 'list':
									$localice=" :: Buscar Conductores";
									break;
						case 'modify':
									$localice=" :: Modificar Conductores";
									break;
						case 'delete':
									$localice=" :: Borrar Conductores";
									break;
						case 'view':
									$localice=" :: Ver Conductor";									
									break;
						default:
									$localice=" :: Buscar Conductores";
									break;
		}
		return $localice;
	}
	
	function verify_drivers($id){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM `drivers` WHERE `id_emp` = \''.$id.'\'';
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
			$this->emps_users_list[$this->num]['id_driver']=$this->result->fields['id_driver'];
			$this->emps_users_list[$this->num]['id_emp']=$this->result->fields['id_emp'];
			$this->emps_users_list[$this->num]['id_vehicle']=$this->result->fields['id_vehicle'];
			$this->emps_users_list[$this->num]['date']=$this->result->fields['date'];
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