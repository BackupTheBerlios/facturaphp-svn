<?php
//clase que da soporte a los grupos del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");
class sessions{
//internal vars
	var $id_session; 
	var $id_session_php;
	var $id_user;
	var $up;
	var $down;
	var $expire;
	var $theme;
//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $table_name='sessions';
	var $ddbb_id_session='id_session';
  	var $ddbb_id_session_php='id_session_php';
  	var $ddbb_id_user='id_user';
  	var $ddbb_up='up';
  	var $ddbb_down='down';
	var $ddbb_name='name';
	var $ddbb_expire = 'expire';
  	var $db;
	var $result;  	
//variables complementarias	
  	var $sessions_list;
	var $conectados_list;
  	var $num;
  	var $fields_list;
  	var $error;
  	//constructor
	function sessions(){
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
		$this->fields_list->add($this->ddbb_id_session, $this->id_session, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_session_php, $this->id_session_php, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_user, $this->id_user, 'int', 11,0);
		$this->fields_list->add($this->ddbb_up, $this->up, 'datetime',11,0);
		$this->fields_list->add($this->ddbb_down, $this->down, 'datetime',11,0);
		$this->fields_list->add($this->ddbb_expire, $this->expire, 'int',25,0);
		
		return $this;	 
		
	}
	
	function get_list_sessions (){
	
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
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
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		$usuario = new users();
		$this->num=0;
		while (!$this->result->EOF) {
			//cogemos los datos del usuario
			$this->sessions_list[$this->num][$this->ddbb_id_session]=$this->result->fields[$this->ddbb_id_session];
			$this->sessions_list[$this->num][$this->ddbb_id_session_php]=$this->result->fields[$this->ddbb_id_session_php];
			$this->sessions_list[$this->num][$this->ddbb_id_user]=$this->result->fields[$this->ddbb_id_user];
			$this->sessions_list[$this->num][$this->ddbb_up]=$this->result->fields[$this->ddbb_up];
			$this->sessions_list[$this->num][$this->ddbb_down]=$this->result->fields[$this->ddbb_down];		
			$usuario->read_fields($this->sessions_list[$this->num][$this->ddbb_id_user]);
			$this->sessions_list[$this->num][$this->ddbb_name] = $usuario->full_name;

			//Modificaci�n del formato de las fechas para la presentaci�n
	    	list($anno,$mes,$dia,$hora,$minutos,$segundos)=sscanf($this->sessions_list[$this->num][$this->ddbb_up],"%d-%d-%d %d:%d:%d");
			
			if($mes < 10)
				$mes = "0".$mes;
			if($dia < 10)
				$dia = "0".$dia;
			if($hora < 10)
				$hora = "0".$hora;
			if($minutos < 10)
				$minutos = "0".$minutos;
			if($segundos < 10)
				$segundos = "0".$segundos;
				
			$this->sessions_list[$this->num][$this->ddbb_up]="$dia-$mes-$anno $hora:$minutos:$segundos";
		
		
			if ($this->sessions_list[$this->num][$this->ddbb_down] !="0000-00-00 00:00:00")
			{
				list($anno,$mes,$dia,$hora,$minutos,$segundos)=sscanf($this->sessions_list[$this->num][$this->ddbb_down],"%d-%d-%d %d:%d:%d");
				
				if($mes < 10)
					$mes = "0".$mes;
				if($dia < 10)
					$dia = "0".$dia;
				if($hora < 10)
					$hora = "0".$hora;
				if($minutos < 10)
					$minutos = "0".$minutos;
				if($segundos < 10)
					$segundos = "0".$segundos;
				
				$this->sessions_list[$this->num][$this->ddbb_down]="$dia-$mes-$anno $hora:$minutos:$segundos";
			}
			else
			{
				$this->sessions_list[$this->num][$this->ddbb_down]="00-00-0000 00:00:00";
			}		
			
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
	
	function comprobar_conectados()
	{
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$expire = time();

		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_down." = '0000-00-00' AND ".$this->ddbb_expire."<= \"".$expire."\"";

		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			$this->db->close();
			return 0;
		}
		else
		{
			//Desconectar a los que esten caducados, cambiar campo down
			
			$this->num=0;
			while (!$this->result->EOF) 
			{
				$id = $this->result->fields[$this->ddbb_id_session];
				$this->read($id);
				$this->down = gmdate("Y-m-d H:i:s");
				$this->modify_other();
	
				//nos movemos hasta el siguiente registro de resultado de la consulta
				$this->result->MoveNext();
				$this->num++;
				
			}
			$this->db->close();
			
		}
	}
	
	function read($id){
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_session."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			$this->db->close();
			return 0;	
		}
		else
		{
			$this->id_session=$id;
			$this->id_session_php=$this->result->fields[$this->ddbb_id_session_php];
			$this->id_user=$this->result->fields[$this->ddbb_id_user];
			$this->up=$this->result->fields[$this->ddbb_up];
			$this->down=$this->result->fields[$this->ddbb_down];
			$this->expire = $this->result->fields[$this->ddbb_expire];
			$this->db->close();
			return 1;
		}
		
	
	}
	
	function add(){
	
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_session." = -1" ;
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
		$record[$this->ddbb_id_session_php] = $this->id_session_php;
		$record[$this->ddbb_id_user]=$this->id_user;
		$record[$this->ddbb_up]=$this->up;
		$record[$this->ddbb_down]=$this->down;		
		//calculamos la sql de inserci�n respecto a los atributos
		$this->sql = $this->db->GetInsertSQL($this->result, $record);
		//print($this->sql);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Insert_ID()>=0){
			//capturammos el id de la linea insertada
			$this->id_session=$this->db->Insert_ID();
			//print("<pre>::".$this->id_user."::</pre>");
			//devolvemos el id de la tabla ya que todo ha ido bien
			$this->db->close();
			return $this->id_session;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}			
	}
	
	function remove($id){
	
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		//calcula la consulta de borrado.
		$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_session." = ".$id." LIMIT 1";
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
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_session." = \"".$_SESSION['ident_sesion']."\"" ;
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
		$record[$this->ddbb_id_session]=$_SESSION['ident_sesion'];
		$record[$this->ddbb_id_session_php]=$this->id_session_php;
		$record[$this->ddbb_id_user]=$this->id_user;				
		$record[$this->ddbb_up]=$this->up;
		$record[$this->ddbb_down]=$this->down;		
		$record[$this->ddbb_expire]=$this->expire;
		//calculamos la sql de inserci�n respecto a los atributos
		$this->sql = $this->db->GetUpdateSQL($this->result, $record);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Affected_Rows()==1){
			//capturammos el id de la linea insertada
			$this->db->close();
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_session;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}

	
	}

	function modify_other(){

		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_session." = \"".$this->id_session."\"" ;
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
		$record[$this->ddbb_id_session]=$this->id_session;
		$record[$this->ddbb_id_session_php]=$this->id_session_php;
		$record[$this->ddbb_id_user]=$this->id_user;				
		$record[$this->ddbb_up]=$this->up;
		$record[$this->ddbb_down]=$this->down;		
		$record[$this->ddbb_expire]=$this->expire;
		//calculamos la sql de inserci�n respecto a los atributos
		$this->sql = $this->db->GetUpdateSQL($this->result, $record);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Affected_Rows()==1){
			//capturammos el id de la linea insertada
			$this->db->close();
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_session;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}

	
	}


	function listar($tpl){
			
		if (isset($_POST['submit_sessions_reg']))
		{
			//Se toma el n�mero de registros y se guarda en varable de sesi�n
			//que se cumpla en todos los accesos del usuario
			$_SESSION['num_regs']= $_POST['regs'];
			
		}	
		$num = $this->get_list_sessions();
		$tabla_listado = new table(true);			
		$per = new permissions();
		$per->get_permissions_list('sessions');
		
		//Toda persona con permso podr� modificar o borrar los datos del conductor, podr� hacerlo
		$j=0;
		for ($i=0;$i<count($per->permissions_module);$i++)
		{
			if($per->permissions_module[$i]=="delete")
			{
				$permisos[$j]=$per->permissions_module[$i];
				$j++;
			} 
		}

		if ($num==0)
		{
			$cadena=''.$cadena.$tabla_listado->tabla_vacia('sessions', false);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{
			$cadena=''.$tabla_listado->make_tables('sessions',$this->sessions_list,array('Usuario',20, 'Fecha/Hora conexi�n', 20, 'Fecha/Hora desconexi�n', 20),array($this->ddbb_id_session,$this->ddbb_name, $this->ddbb_up, $this->ddbb_down),$_SESSION['num_regs'],$permisos,false);
			$variables=$tabla_listado->nombres_variables;
		}		
		$tpl->assign('variables',$variables);
		$tpl->assign('cadena',$cadena);		
		return $tpl;
	}
	
	function view ($id){
	
	}
	
	function admin ($id){
	
	}
	
	function num(){
	
		return 0;
	}
	
	function conectados()
	{
		//se puede acceder a los usuarios conectados
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM sessions WHERE down = '0000-00-00 00:00:00'";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();
			return 0;
		}  
	
		$usuario = new users();

		$this->num=0;
		$this->conectados_list = null;
		while (!$this->result->EOF)
		{
			
			//cogemos los datos del usuario
			$this->conectados_list[$this->num][$this->ddbb_id_session]=$this->result->fields[$this->ddbb_id_session];
			$this->conectados_list[$this->num][$this->ddbb_id_session_php]=$this->result->fields[$this->ddbb_id_session_php];
			$this->conectados_list[$this->num][$this->ddbb_id_user]=$this->result->fields[$this->ddbb_id_user];
			$this->conectados_list[$this->num][$this->ddbb_up]=$this->result->fields[$this->ddbb_up];
				
			$usuario->read_fields($this->conectados_list[$this->num][$this->ddbb_id_user]);			
			$this->conectados_list[$this->num][$this->ddbb_name] = $usuario->full_name;

			//Modificaci�n del formato de las fechas para la presentaci�n
			list($anno,$mes,$dia,$hora,$minutos,$segundos)=sscanf($this->conectados_list[$this->num][$this->ddbb_up],"%d-%d-%d %d:%d:%d");
			
			if($mes < 10)
				$mes = "0".$mes;
			if($dia < 10)
				$dia = "0".$dia;
			if($hora < 10)
				$hora = "0".$hora;
			if($minutos < 10)
				$minutos = "0".$minutos;
			if($segundos < 10)
				$segundos = "0".$segundos;
				
			$this->conectados_list[$this->num][$this->ddbb_up]="$dia-$mes-$anno $hora:$minutos:$segundos";	
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();

		return $this->num;
	}
/*	
	function preparar_datos_conectados($id_user)
	{
		$usuario = new users();
		$usuario->read($id_user);
		$this->conectados_list[$this->num][$this->ddbb_name] = $usuario->name." ".$usuario->last_name." ".$usuario->last_name2;

		//Modificaci�n del formato de las fechas para la presentaci�n
		
			list($anno,$mes,$dia,$hora,$minutos,$segundos)=sscanf($this->conectados_list[$this->num][$this->ddbb_up],"%d-%d-%d %d:%d:%d");
			
			if($mes < 10)
				$mes = "0".$mes;
			if($dia < 10)
				$dia = "0".$dia;
			if($hora < 10)
				$hora = "0".$hora;
			if($minutos < 10)
				$minutos = "0".$minutos;
			if($segundos < 10)
				$segundos = "0".$segundos;
				
			$this->conectados_list[$this->num][$this->ddbb_up]="$dia-$mes-$anno $hora:$minutos:$segundos";
		
	}
	*/
	function register()
	{
		$this->id_session_php = session_id();
		$user = new users();
		$id_user = $_SESSION['ident_user'];
		$this->id_user = $id_user;
		$this->up = gmdate("Y-m-d H:i:s");	
	
		return $this->add();
	}
	
	function unregister()
	{
		if(isset($_SESSION['ident_sesion']) && $_SESSION['ident_sesion'] > 0)
		{
			$this->down = gmdate("Y-m-d H:i:s");
			$this->modify();
			
		}
	}
	
		
	function calculate_tpl($method, $tpl){
		$this->method=$method;
				switch($method){		
						case 'list':
									$tpl=$this->listar($tpl);
									$tpl->assign("registro",$_SESSION['num_regs']);
									break;
						case 'delete':
									$this->read($_GET['id']);
									if ($this->remove($_GET['id'])==0){
										
									}
									else{
										
										$this->method="list";
										$tpl=$this->listar($tpl);
										$tpl->assign("message","&nbsp;<br>Sesi&oacute;n borrada correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
									break;
						default:
									$this->method='list';
									$tpl=$this->listar($tpl);
									$tpl->assign("registro",$_SESSION['num_regs']);
									break;
					}
				$tpl->assign('plantilla','sessions_'.$this->method.'.tpl');					
		
		return $tpl;
	}

	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}		
	if ($corp != ""){
			$corp='<a href="index.php?module=user_corps&method=select&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = '<a>Zona privada</a> :: '.$corp.' <a href="index.php?module=sessions">Sesiones</a>';
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
		$title = "Zona Privada :: $corp Sesiones";
		$title=$title.$this->localice($method);		
		return $title;
	}		
	
	
	function localice($method){	
		switch($method){
						
						case 'list':
									$localice=" :: Listar Sesiones";
									break;
						case 'delete':
									$localice=" :: Borrar Sesiones";
									break;
						default:
									$localice=" :: Listar Sesiones";
									break;
		}
		return $localice;
	}
}
?>