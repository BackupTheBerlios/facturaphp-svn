<?php
//clase que da soporte a los grupos del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($ADODB_DIR."adodb.inc.php");
class log_sessions{
//internal vars
	var $id_log_session;
	var $id_session; 
	var $date_in;
	var $date_out;
	var $timeout;
	var $ip;
	var $id_user;
	var $country;
	var $theme;
//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $table_name='log_sessions';
	var $ddbb_id_log_session='id_log_session';
	var $ddbb_id_session='id_session';
  	var $ddbb_date_in='date_in';
  	var $ddbb_date_out='date_out';
  	var $ddbb_timeout='timeout';
  	var $ddbb_ip='ip';
  	var $ddbb_id_user='id_user';
  	var $ddbb_country='country';
	var $db;
	var $result;  	
//variables complementarias	
  	var $log_sessions_list;
  	var $num;
  	var $fields_list;
  	var $error;
  	//constructor
	function log_sessions(){
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
		$this->fields_list->add($this->ddbb_id_log_session, $this->id_log_session, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_session, $this->id_session, 'int', 11,0);		
		$this->fields_list->add($this->ddbb_date_in, $this->date_in, 'datetime',11,0);
		$this->fields_list->add($this->ddbb_date_out, $this->date_out, 'datetime',11,0);
		$this->fields_list->add($this->ddbb_timeout, $this->timeout, 'datetime',11,0);		
		$this->fields_list->add($this->ddbb_ip, $this->ip, 'varchar', 20,0);		
		$this->fields_list->add($this->ddbb_id_user, $this->id_user, 'int', 11,0);		
		$this->fields_list->add($this->ddbb_country, $this->country, 'varchar', 20,0);
		//print_r($this);
		//se puede acceder a las sesiones por numero de campo o por nombre de campo
	/*	$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
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
		return $this/*->get_list_log_sessions()*/;	 
		
	}
	
	function get_list_log_sessions (){
		//se puede acceder a los grupos_usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
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
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		$this->num=0;
		while (!$this->result->EOF) {
			//cogemos los datos del usuario
	

			$this->sessions_list[$this->num][$this->ddbb_id_log_session]=$this->result->fields[$this->ddbb_id_log_session];
			$this->sessions_list[$this->num][$this->ddbb_id_session]=$this->result->fields[$this->ddbb_id_session];			
			$this->sessions_list[$this->num][$this->ddbb_date_in]=$this->result->fields[$this->ddbb_date_in];
			$this->sessions_list[$this->num][$this->ddbb_date_out]=$this->result->fields[$this->ddbb_date_out];
			$this->sessions_list[$this->num][$this->ddbb_timeout]=$this->result->fields[$this->ddbb_timeout];
			$this->sessions_list[$this->num][$this->ddbb_ip]=$this->result->fields[$this->ddbb_ip];
			$this->sessions_list[$this->num][$this->ddbb_id_user]=$this->result->fields[$this->ddbb_id_user];		
			$this->sessions_list[$this->num][$this->ddbb_country]=$this->result->fields[$this->ddbb_country];	
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	
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
	
		//se puede acceder a los gruposs por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_session."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_log_session=$id;
			$this->id_session=$this->result->fields[$this->ddbb_id_session];
			$this->date_in=$this->result->fields[$this->ddbb_date_in];
			$this->date_out=$this->result->fields[$this->ddbb_date_out];
			$this->timeout=$this->result->fields[$this->ddbb_timeout];
			$this->ip=$this->result->fields[$this->ddbb_ip];
			$this->id_user=$this->result->fields[$this->ddbb_id_user];
			$this->country=$this->result->fields[$this->ddbb_country];
			
			
			$this->db->close();
			return 1;
		}
		
	
	}
	
	function add(){
	
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_log_session." = -1" ;
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
		$record[$this->ddbb_id_session] = $this->id_session;
		$record[$this->ddbb_date_in]=$this->date_in;
		$record[$this->ddbb_date_out]=$this->date_out;		
		$record[$this->ddbb_timeout]=$this->timeout;
		$record[$this->ddbb_ip]=$this->ip;
		$record[$this->ddbb_id_user]=$this->id_user;		
		$record[$this->ddbb_country]=$this->country;
		//calculamos la sql de inserci—n respecto a los atributos
		$this->sql = $this->db->GetInsertSQL($this->result, $record);
		//print($this->sql);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Insert_ID()>=0){
			//capturammos el id de la linea insertada
			$this->id_log_session=$this->db->Insert_ID();
			//print("<pre>::".$this->id_user."::</pre>");
			//devolvemos el id de la tabla ya que todo ha ido bien
			$this->db->close();
			return $this->id_log_session;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}			
	}
	
	function remove($id){
	
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		//calcula la consulta de borrado.
		$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_log_session." = ".$id." LIMIT 1";
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
	
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_log_session." = \"".$this->id_log_session."\"" ;
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
		$record[$this->ddbb_id_log_session]=$this->id_log_session;
		$record[$this->ddbb_id_session]=$this->id_session;
		$record[$this->ddbb_date_in]=$this->date_in;
		$record[$this->ddbb_date_out]=$this->date_out;		
		$record[$this->ddbb_timeout]=$this->timeout;
		$record[$this->ddbb_ip]=$this->ip;		
		$record[$this->ddbb_id_user]=$this->id_user;				
		$record[$this->ddbb_country]=$this->country;				
		//calculamos la sql de inserci—n respecto a los atributos
		$this->sql = $this->db->GetUpdateSQL($this->result, $record);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Affected_Rows()==1){
			//capturammos el id de la linea insertada
			$this->db->close();
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_log_session;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}

	
	}
	  
	/*function validate_user($user, $passwd){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi—n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi—n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_login."=\"".$user."\"";
		//printf($this->sql);
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla
		//printf($this); 
		if ($this->result === false){
			//printf('no existe usuario o contrase–a');
			$error=1;
			$this->db->close();
			return 0;
		}else{  
		//la contrase–a es correcta
			if($passwd==$this->result->fields[$this->ddbb_passwd]){
			//printf('existe usuario o contrase–a');
			$this->db->close();
			return 1;
			}
		}
		$this->db->close();
		return 0;
		
		
	
	}*/
	
	function view ($id){
	
	}
	
	function admin ($id){
	
	}
}
?>