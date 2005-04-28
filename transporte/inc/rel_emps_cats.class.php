<?php
//clase que da soporte a los grupos del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($ADODB_DIR."adodb.inc.php");
class rel_emps_cats{
//internal vars
	var $id_rel_emp_cat; 
	var $id_emp;
	var $id_cat_emp;
	var $theme;
//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $table_name='rel_emps_cats';
	var $ddbb_id_rel_emp_cat='id_rel_emp_cat';
	var $ddbb_id_emp='id_emp';
	var $ddbb_id_cat_emp='id_cat_emp';
	var $db;
	var $result;  	
//variables complementarias	
  	var $rel_emps_cats_list;
  	var $num;
  	var $fields_list;
  	var $error;
	var $emps_cats_list;
  	//constructor
	function rel_emps_cats(){
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
		$this->fields_list->add($this->ddbb_id_rel_emp_cat, $this->id_rel_emp_cat, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_emp, $this->id_emp, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_cat_emp, $this->id_cat_emp, 'int', 11,0);
		//print_r($this);
		//se puede acceder a los grupos por numero de campo o por nombre de campo
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
		return $this/*->get_list_rel_emps_cats()*/;	 
		
	}
	
	function get_list_rel_emps_cats (){
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
			$this->rel_emps_cats_list[$this->num][$this->ddbb_id_rel_emp_cat]=$this->result->fields[$this->ddbb_id_rel_emp_cat];
			$this->rel_emps_cats_list[$this->num][$this->ddbb_id_emp]=$this->result->fields[$this->ddbb_id_emp];
			$this->rel_emps_cats_list[$this->num][$this->ddbb_id_cat_emp]=$this->result->fields[$this->ddbb_id_cat_emp];
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
		$this->sql='SELECT * FROM `rel_emps_cats` WHERE `id_cat_emp` = \''.$id.'\'';
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		if ($this->result === false){
			$this->error=1;
			$this->db->close();
			return 0;
		}  
		
		$this->num=0;
		$emp = new emps();
		while (!$this->result->EOF) {
			//cogemos los datos del usuario
			$emp->read($this->result->fields['id_emp']);
			$this->emps_cats_list[$this->num]['id_emp']=$emp->id_emp;
			$this->emps_cats_list[$this->num]['name']=$emp->name;
			$this->emps_cats_list[$this->num]['last_name']=$emp->last_name;
			$this->emps_cats_list[$this->num]['last_name2']=$emp->last_name2;
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_rel_emp_cat."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_rel_emp_cat=$id;
			$this->id_emp=$this->result->fields[$this->ddbb_id_emp];
			$this->id_cat_emp=$this->result->fields[$this->ddbb_id_cat_emp];
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_rel_emp_cat." = -1" ;
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
		$record[$this->ddbb_id_emp] = $this->id_emp;
		$record[$this->ddbb_id_cat_emp]=$this->id_cat_emp;
		//calculamos la sql de inserci—n respecto a los atributos
		$this->sql = $this->db->GetInsertSQL($this->result, $record);
		//print($this->sql);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Insert_ID()>=0){
			//capturammos el id de la linea insertada
			$this->id_rel_emp_cat=$this->db->Insert_ID();
			//print("<pre>::".$this->id_cat_emp."::</pre>");
			//devolvemos el id de la tabla ya que todo ha ido bien
			$this->db->close();
			return $this->id_rel_emp_cat;
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
		$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_rel_emp_cat." = ".$id." LIMIT 1";
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_rel_emp_cat." = \"".$this->id_rel_emp_cat."\"" ;
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
		$record[$this->ddbb_id_rel_emp_cat]=$this->id_rel_emp_cat;
		$record[$this->ddbb_id_emp]=$this->id_emp;
		$record[$this->ddbb_id_cat_emp]=$this->id_cat_emp;				
		//calculamos la sql de inserci—n respecto a los atributos
		$this->sql = $this->db->GetUpdateSQL($this->result, $record);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Affected_Rows()==1){
			//capturammos el id de la linea insertada
			$this->db->close();
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_rel_emp_cat;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}

	
	}
	  
	
	
	function view ($id){
	
	}
	
	function admin ($id){
	
	}
	
	function get_rel_emp_cat($id_emp){
	
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM '.$this->table_name.'  WHERE `'.$this->ddbb_id_emp.'` = \''.$id_emp.'\' LIMIT 1';
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
			$this->rel_emps_cats_list[$this->num]['id_rel_emp_cat']=$this->result->fields['id_rel_emp_cat'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();		
		return $this->rel_emps_cats_list[0]['id_rel_emp_cat'];
	
	}
	
}

?>