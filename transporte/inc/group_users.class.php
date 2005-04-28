<?php
//clase que da soporte a los grupos del programa
//enlaza con la bbdd 
global $ADODB_DIR,$INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($ADODB_DIR."adodb.inc.php");
class group_users{
//internal vars
	var $id_group_user; 
	var $id_group;
	var $id_user;
	var $up;
	var $theme;
//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $table_name='group_users';
	var $ddbb_id_group_user='id_group_user';
	var $ddbb_id_group='id_group';
	var $ddbb_id_user='id_user';
  	var $ddbb_up='up';
	var $db;
	var $result;  	
//variables complementarias	
  	var $group_users_list;
  	var $num;
  	var $fields_list;
  	var $error;
  	//constructor
	function group_users(){
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
		$this->fields_list->add($this->ddbb_id_group_user, $this->id_group_user, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_group, $this->id_group, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_user, $this->id_user, 'int', 11,0);
		$this->fields_list->add($this->ddbb_up, $this->up, 'date',11,0);
	
		return $this;	 
		
	}
	
	function get_list_group_users (){
		//se puede acceder a los grupos_usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
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
			$this->group_users_list[$this->num][$this->ddbb_id_group_user]=$this->result->fields[$this->ddbb_id_group_user];
			$this->group_users_list[$this->num][$this->ddbb_id_group]=$this->result->fields[$this->ddbb_id_group];
			$this->group_users_list[$this->num][$this->ddbb_id_user]=$this->result->fields[$this->ddbb_id_user];
			$this->group_users_list[$this->num][$this->ddbb_up]=$this->result->fields[$this->ddbb_up];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	
	}
	
	function calculate_tpl($method, $tpl)
	{
		
		switch($method)
		{
				case 'select':	
								$_SESSION['ident_group']=$_GET['id'];
								$my_corp = new corps();
								$tpl = $my_corp->view($_SESSION['ident_corp'],$tpl);
								$tpl->assign('plantilla','corps_view.tpl');	
								break;
				default:
								$method='list';
								$tpl=$this->listar($tpl);
	//Empieza comentado
/*								if($_SESSION['super'] || $_SESSION['admin'])
								{
									$tpl->assign('plantilla','user_corps_'.$method.'.tpl');	
								}
								else
								{
								Fin comentado
									if($num_corps == 1)
									{
										$_SESSION['ident_corp'] = $this->emp->corps_list[0]['id_corp'];
										$my_corp = new corps();
										$tpl = $my_corp->view($_SESSION['ident_corp'],$tpl);
										$tpl->assign('plantilla','corps_view.tpl');	
										
									}
									else
										$tpl->assign('plantilla','user_corps_'.$method.'.tpl');	
							Empieza comentado			
								}*/
								//Fin cometnado
								break;
		}
			
		
		return $tpl;
	}
	
	
	function listar($tpl)
	{
		$tabla_listado = new table(true);
		//Empieza comentado
		if($_SESSION['super'] || $_SESSION['admin'])
		{
			$my_group = new groups();
			$my_group->get_list_groups();
			$cadena=''.$tabla_listado->make_tables('user_groups',$my_group->groups_list,array('Nombre',50),array('id_group','name'),10,array('select'),false);
			$variables=$tabla_listado->nombres_variables;		
			$tpl->assign('variables',$variables);
			$tpl->assign('cadena',$cadena);		
			return $tpl;
			
		}
		
		//Fin comentado
		$cadena=''.$tabla_listado->make_tables('user_groups',$this->emp->groups_list,array('Nombre',50),array('id_group','name'),10,array('select'),false);
		$variables=$tabla_listado->nombres_variables;		
		$tpl->assign('variables',$variables);
		$tpl->assign('cadena',$cadena);		
		return $tpl;
	}
	
	function bar($method,$group){		
		if ($group != ""){
			$group='<a href="index.php?module=groups&method=view&id='.$_SESSION['ident_group'].'">'.$group.' ::';
		}
		$nav_bar = 'Zona privada :: '.$group.' <a href="index.php?module=user_groups">Usuario grupos</a>';
		$nav_bar=$nav_bar;
		return $nav_bar;
	}	

	function title($method,$group)
	{
		if ($group != "")
		{
			$group=$group." ::";
		}
		$title = "Zona Privada :: $group Usuario grupos";
		$title=$title;		
		return $title;
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
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_group_user."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_group_user=$id;
			$this->id_group=$this->result->fields[$this->ddbb_id_group];
			$this->id_user=$this->result->fields[$this->ddbb_id_user];
			$this->up=$this->result->fields[$this->ddbb_up];
			$this->db->close();
			return 1;
		}
		
	
	}
	
	function add(){
	
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_group_user." = -1" ;
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
		$record[$this->ddbb_id_group] = $this->id_group;
		$record[$this->ddbb_id_user]=$this->id_user;
		$record[$this->ddbb_up]=$this->up;
		//calculamos la sql de insercin respecto a los atributos
		$this->sql = $this->db->GetInsertSQL($this->result, $record);
		//print($this->sql);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Insert_ID()>=0){
			//capturammos el id de la linea insertada
			$this->id_group_user=$this->db->Insert_ID();
			//print("<pre>::".$this->id_user."::</pre>");
			//devolvemos el id de la tabla ya que todo ha ido bien
			$this->db->close();
			return $this->id_group_user;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}			
	}
	
	function remove($id){
	
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		//calcula la consulta de borrado.
		$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_group_user." = ".$id." LIMIT 1";
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
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_group_user." = \"".$this->id_group_user."\"" ;
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
		$record[$this->ddbb_id_group_user]=$this->id_group_user;
		$record[$this->ddbb_id_group]=$this->id_group;
		$record[$this->ddbb_id_user]=$this->id_user;				
		$record[$this->ddbb_up]=$this->up;
		//calculamos la sql de insercin respecto a los atributos
		$this->sql = $this->db->GetUpdateSQL($this->result, $record);
		//insertamos el registro
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		if($this->db->Affected_Rows()==1){
			//capturammos el id de la linea insertada
			$this->db->close();
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_group_user;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}

	
	}
	  
	function verify_group_user($id_group,$id_user){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT `id_user`,`id_group`,`id_group_user` FROM `group_users` WHERE `id_group` = \''.$id_group.'\' AND `id_user` = \''.$id_user.'\'';
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		if ($this->result === false){
			$this->error=1;
			$this->db->close();
			return 0;
		}  
		
		$this->num=0;
		$id_grupo_usuario=0;
		if (!$this->result->EOF) {//Solo debe de haber un registro
			//cogemos los datos del usuario
			$this->users_list[$this->num]['id_user']=$this->result->fields['id_user'];
			$this->users_list[$this->num]['id_group']=$this->result->fields['id_group'];
			$this->users_list[$this->num]['id_group_user']=$this->result->fields['id_group_user'];
			$id_grupo_usuario=$this->result->fields['id_group_user'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->num++;
		}
		$this->db->close();
		return $id_grupo_usuario;
	
	}
	
	function view ($id){
	
	}
	
	function admin ($id){
	
	}
}

?>