<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($ADODB_DIR."adodb.inc.php");
class holydays{
//internal vars
	var $id_holy;
	var $id_emp;
	var $gone="00-00-0000";
	var $come="00-00-0000";
	var $ill;
	var $descrip;
	var $theme;
//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $table_name='holydays';
	var $ddbb_id_holy='id_holy';
  	var $ddbb_id_emp='id_emp';
  	var $ddbb_gone='gone';
	var $ddbb_come='come';
  	var $ddbb_ill='ill';
	var $ddbb_descrip='descrip';
	var $db;
	var $result;  	
//variables complementarias	
  	var $holydays_list;
  	var $num;
  	var $fields_list;
  	var $error;
	var $method;
	var $is_emps=false;
  	//constructor
	function holydays(){
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
		$this->fields_list->add($this->ddbb_id_holy, $this->id_holy, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_emp, $this->id_emp, 'int', 11,0);
		$this->fields_list->add($this->ddbb_gone, $this->gone, 'date', 20,0,1);
		$this->fields_list->add($this->ddbb_come, $this->come, 'date', 20,0,1);		
		$this->fields_list->add($this->ddbb_ill, $this->ill, 'tinyint', 3,0);		
		$this->fields_list->add($this->ddbb_descrip, $this->descrip, 'text', 255,0);				
		//print_r($this);
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
	/*	$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
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
		return $this/*->get_list_holydays()*/;	 
		
	}
	
	function get_list_holydays (){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
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
		
		$this->num=0;
		while (!$this->result->EOF) {
			//cogemos los datos del usuario
			$this->holydays_list[$this->num][$this->ddbb_id_holy]=$this->result->fields[$this->ddbb_id_holy];
			$this->holydays_list[$this->num][$this->ddbb_id_emp]=$this->result->fields[$this->ddbb_id_emp];
			$this->holydays_list[$this->num][$this->ddbb_gone]=$this->result->fields[$this->ddbb_gone];
			$this->holydays_list[$this->num][$this->ddbb_ill]=$this->result->fields[$this->ddbb_ill];
			$this->holydays_list[$this->num][$this->ddbb_come]=$this->result->fields[$this->ddbb_come];
			$this->holydays_list[$this->num][$this->ddbb_descrip]=$this->result->fields[$this->ddbb_descrip];

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
	
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_holy."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_holy=$id;
			$this->id_emp=$this->result->fields[$this->ddbb_id_emp];
			$this->gone=$this->result->fields[$this->ddbb_gone];
			$this->come=$this->result->fields[$this->ddbb_come];
			$this->ill=$this->result->fields[$this->ddbb_ill];
			$this->descrip=$this->result->fields[$this->ddbb_descrip];
			$this->db->close();
			return 1;
		}
		
	
	}
	
	function add(){
			if (!isset($_POST['submit_add'])){
			//Mostrar plantilla vacia	
			//pasarle a la plantilla los modulos y grupos con sus respectivos checkbox a checked false
			//Modulos
			
			return 0;
		}
		//en el caso de que SI este definido submit_add
		else{
						
			//Introducir los datos de post.
	
			if ($this->is_emps==false){
				$this->get_fields_from_post();	
				$this->fields_list->modify_value($this->ddbb_gone,$this->gone);
			}	
			//Validacion
			
			//Modificamos los todos los valores del objeto fields con los nuevos datos del objeto product, exceptuando path_photo que eso se deberia hacer mediante la clase upload.
			//Al id_product se le da 0 por quse neecesita un valor para que 
			$this->id_holy=0;
			$this->fields_list->modify_value($this->ddbb_id_holy,$this->id_holy);
			$this->fields_list->modify_value($this->ddbb_id_emp,$this->id_emp);
			
			$this->fields_list->modify_value($this->ddbb_come,$this->come);
			$this->fields_list->modify_value($this->ddbb_ill,$this->ill);
			$this->fields_list->modify_value($this->ddbb_descrip,$this->descrip);
			//validamos
			$return=$this->fields_list->validate();		
			
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			//$return=true; //Para pruebas dejar esta linea sin comentar
			echo "el come es:".$this->come;
			if (!$return){
				//Mostrar plantilla con datos erroneos
				print_r($this->fields_list->array_error);
				echo "erroooor";
				return -1;
			}
			else{
				//Ponemos el formato de fecha a ingles.
				$this->gone=$this->fields_list->change_date($this->gone,"en");
				$this->come=$this->fields_list->change_date($this->come,"en");
				
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexi�n con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexi�n permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_holy." = -1" ;
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
				$record[$this->ddbb_gone]=$this->gone;
				$record[$this->ddbb_ill]=$this->ill;
				$record[$this->ddbb_come]=$this->come;
				$record[$this->ddbb_descrip]=$this->descrip;
				//calculamos la sql de inserci�n respecto a los atributos
				$this->sql = $this->db->GetInsertSQL($this->result, $record);
				//print($this->sql);
				//insertamos el registro
				echo "esto".$this->sql;
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				if($this->db->Insert_ID()>=0){
					//capturammos el id de la linea insertada
					$this->id_holy=$this->db->Insert_ID();
					//print("<pre>::".$this->id_holy."::</pre>");
					//devolvemos el id de la tabla ya que todo ha ido bien
					$this->db->close();
					
					return $this->id_holy;
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
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexi�n con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexi�n permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		//calcula la consulta de borrado.
		$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_holy." = ".$id." LIMIT 1";
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
	
	function modify(){
	if (!isset($_POST['submit_modify'])){
			//Ponemos la fecha en formato espa�ol
			$this->gone=$this->fields_list->change_date($this->gone,"es");
			$this->come=$this->fields_list->change_date($this->come,"es");
			return 0;
		}
		else{
			//Introducir los datos de post.
			if ($this->is_emps==false){
				$this->get_fields_from_post();	
				$this->fields_list->modify_value($this->ddbb_gone,$this->gone);
			}	
			/***Validaci�n***/
			//Modificamos los valores de la lista fields ya
			//que se han modificado.
			$this->fields_list->modify_value($this->ddbb_id_holy,$this->id_holy);
			$this->fields_list->modify_value($this->ddbb_id_emp,$this->id_emp);
			$this->fields_list->modify_value($this->ddbb_come,$this->come);
			$this->fields_list->modify_value($this->ddbb_ill,$this->ill);
			$this->fields_list->modify_value($this->ddbb_descrip,$this->descrip);
			//validamos
			$return=$this->fields_list->validate();		
			
		
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
//			$return=true; //Para pruebas dejar esta linea sin comentar
			
			if (!$return){
				//Mostrar plantilla con datos erroneos
				return -1;
			}
			else{
				$this->gone=$this->fields_list->change_date($this->gone,"en");
				$this->come=$this->fields_list->change_date($this->come,"en");
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexi�n con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexi�n de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexi�n permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_holy." = \"".$this->id_holy."\"" ;
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
				$record[$this->ddbb_id_holy]=$this->id_holy;
				$record[$this->ddbb_id_emp] = $this->id_emp;
				$record[$this->ddbb_gone]=$this->gone;
				$record[$this->ddbb_ill]=$this->ill;
				$record[$this->ddbb_come]=$this->come;
				$record[$this->ddbb_descrip]=$this->descrip;
				//calculamos la sql de inserci�n respecto a los atributos
				$this->sql = $this->db->GetUpdateSQL($this->result, $record);
				//insertamos el registro
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				if($this->db->Affected_Rows()==1){
					//capturammos el id de la linea insertada
					$this->db->close();
					//devolvemos el id de la tabla ya que todo ha ido bien
					return $this->id_holy;
				}else {
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}
			}
		}
	}
	  
	function calculate_tpl($method, $tpl){
		$this->method=$method;
				switch($method){
						case 'add':					
									$empleado=new emps();
									
									
									$empleado->read($_SESSION['id_emp']);
									
									$tpl->assign("empleado",$empleado);
													
								/*	if ($this->add() !=0){
										$this->method="emps_view";																				
										$tpl->assign("message","&nbsp;<br>Baja a&ntilde;adida correctamente<br>&nbsp;");			
										$tpl=$empleado->view($this->id_emp,$tpl);		
																	
										$tpl->assign("plantilla","emps_view.tpl");
										return $tpl;
									}*/									
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
												$this->method="emps_view";																				
												$tpl->assign("message","&nbsp;<br>Baja a&ntilde;adida correctamente<br>&nbsp;");			
												$tpl=$empleado->view($this->id_emp,$tpl);																	
												$tpl->assign("plantilla","emps_view.tpl");
												return $tpl;
												break;
									}
									//esto se hace independientemetne del valor que se obtenga
									$tpl->assign("objeto",$this);
									break;
									
						case 'list':
									$tpl=$this->listar($tpl);
									break;
						case 'modify':
									
									$empleado=new emps();									
									
									$empleado->read($_SESSION['id_emp']);
									
									$tpl->assign("empleado",$empleado);
									
									$this->read($_GET['id']);
									$return=$this->modify();
									switch ($return){										
										case 0: //por defecto												
												break;
										case -1: //Errores al intentar a�adir datos
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
												}												
												break;
										default: //Si se ha a�adido
												$this->method="emps_view";																				
												$tpl->assign("message","&nbsp;<br>Baja/Alta modificada correctamente<br>&nbsp;");			
												$tpl=$empleado->view($this->id_emp,$tpl);		
												$tpl->assign("plantilla","emps_view.tpl");
												return $tpl;
												break;
									}
									$tpl->assign("objeto",$this);
									
									break;
						case 'delete':
									$this->read($_GET['id']);
									if ($this->remove($_GET['id'])!=0){
										$this->method="emps_view";																				
										$tpl->assign("message","&nbsp;<br>Baja/Alta borrada correctamente<br>&nbsp;");			
										$empleado=new emps();
										$tpl=$empleado->view($this->id_emp,$tpl);		
																	
										$tpl->assign("plantilla","emps_view.tpl");
										return $tpl;
									}
									$tpl->assign("objeto",$this);
									break;
						case 'view':									
									$tpl=$this->view($_GET['id'],$tpl);
									break;
						default:
									$this->method='list';
									$tpl=$this->listar($tpl);
									break;
					}
				$tpl->assign('plantilla','holydays_'.$this->method.'.tpl');							
		return $tpl;
	}
	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}		
		
		if ($method=="emps_view"){
			$empleados=new emps();
			$this->method="view";
			return $empleados->bar("view",$corp);
		}
		
	if ($corp != ""){
			$corp='<a href="index.php?module=user_corps&method=select&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$empleado=new emps();
		if ($empleado->read($_SESSION["id_emp"])==0)
			$empleado->read($this->id_emp);
		$nav_bar = '<a href="index.php?module=user_corps">Zona privada</a> :: '.$corp.' <a href="index.php?module=emps">Empleados</a> :: <a href="index.php?module=emps&method=view&id='.$empleado->id_emp.'">Ver Empleados</a>';
		$nav_bar=$nav_bar.$this->localice($method);
		return $nav_bar;
	}	

	function title($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}
		if ($method=="emps_view"){
			$empleados=new emps();
			$this->method="view";
			return $empleados->title("view",$corp);
		}
		if ($corp != ""){
			$corp=$corp." ::";
		}
		$title = "Zona Privada :: $corp Empleados :: Ver Usuario";
		$title=$title.$this->localice($method);		
		return $title;
	}
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Baja";
									break;
						case 'list':
									$localice=" :: Buscar Alba/Baja";
									break;
						case 'modify':
									$localice=" :: Modificar Baja/Alta";
									break;
						case 'delete':
									$localice=" :: Borrar Bajas-Altas";
									break;
						case 'view':
									$localice=" :: Ver Baja-Alta";									
									break;
						default:
									$localice=" :: Buscar Alta/Baja";
									break;
		}
		return $localice;
	}
	
	function get_fields_from_post(){
			$this->id_emp=$_POST[$this->ddbb_id_emp];
			$this->come=$_POST[$this->ddbb_come];
			$this->gone=$_POST[$this->ddbb_gone];
			$this->ill=$_POST[$this->ddbb_ill];
			$this->descrip=htmlentities($_POST[$this->ddbb_descrip]);
			
	}
	
	
	function get_come($id){
		$ill=2;
		//ill ==2 es la nueva alta
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM '.$this->table_name.'  WHERE `'.$this->ddbb_id_emp.'` = \''.$id.'\' AND `'.$this->ddbb_ill.'` = \''.$ill.'\' LIMIT 1';
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
			$this->holydays_list[$this->num]['come']=$this->result->fields['come'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		$this->read($this->holydays_list[0]['id_holy']);
		return $this->num;
	
	}
}
?>