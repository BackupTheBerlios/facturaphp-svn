<?php
//clase que da soporte a los usuarios del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");

class vehicles{
//internal vars
	var $id_vehicle;
	var $id_corp;
	var $number_plate;
	var $alias;
	var $path_photo;
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
	var $table_name='vehicles';
	var $ddbb_id_vehicle='id_vehicle';
  	var $ddbb_id_corp='id_corp';
  	var $ddbb_number_plate='number_plate';
  	var $ddbb_alias='alias';
  	var $ddbb_path_photo='path_photo';
	var $ddbb_search='search';
	var $db;
	var $result;  	
//variables complementarias	
  	var $vehicles_list;
  	var $num;
  	var $fields_list;
	var $cat_vehicles;
	var $vehicle_cat_list;
	var $category;
	var $table_names_modify=array();
	var $table_names_delete=array("rel_vehicles_cats",);


  	//constructor
	function vehicles(){
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
		$this->fields_list->add($this->ddbb_id_vehicle, $this->id_vehicle, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_id_corp, $this->id_corp, 'int', 11,0,1);
		$this->fields_list->add($this->ddbb_number_plate, $this->number_plate, 'varchar', 10,0,1);
		$this->fields_list->add($this->ddbb_alias, $this->alias, 'varchar', 255,1);
		$this->fields_list->add($this->ddbb_path_photo, $this->path_photo, 'varchar', 255,0);
		
		$this->search[0]= 'number_plate';
		$this->search[1]= 'alias';

		return $this;	 
		
	}
	
	function get_list_vehicles ($id_corp){
		if (isset($_POST['submit_vehicles_search']))
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
		
		
		//cogemos los datos del usuario
		$this->num=0;
		while (!$this->result->EOF) 
		{
			$this->vehicles_list[$this->num][$this->ddbb_id_vehicle]=$this->result->fields[$this->ddbb_id_vehicle];
			$this->vehicles_list[$this->num][$this->ddbb_id_corp]=$this->result->fields[$this->ddbb_id_corp];
			$this->vehicles_list[$this->num][$this->ddbb_number_plate]=$this->result->fields[$this->ddbb_number_plate];
			$this->vehicles_list[$this->num][$this->ddbb_alias]=$this->result->fields[$this->ddbb_alias];
			$this->vehicles_list[$this->num][$this->ddbb_path_photo]=$this->result->fields[$this->ddbb_path_photo];
			
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

	
	function table_categories($new){
		//Esta funcion hara el listado de checkbox de las categorias jerarquizadas
		//Buscamos las categorias jerarquizadas comenzando por las categorias padre.
		
		$array_cat=$this->get_categories();

		//Si no es para nuevo: Buscamos las categorias relacionadas con el producto
		if (!$new && (!is_array($this->vehicle_cat_list)||$this->vehicle_cat_list==""))
		{		
			if ($this->id_vehicle!="" && $this->id_vehicle!=0)
			{
				$rel = new rel_vehicles_cats();
				$this->vehicle_cat_list=$rel->get_rel_vehicle_cat($this->id_vehicle);
			}
			else
			{
				$new=true;
			}
		}
		//Construimos la tabla con los arrays
		if (count($array_cat)!=0)
			$table=$this->build_table($new,$array_cat);
		else
			$table='<p class="mensaje">No hay categorías</p>';
		
		//$table es una cadena
		return $table;
	}
	
	function build_table($new,$array_cat){
		//Con esta funcion hacemos la tabla de los checkbox
		//de categorias de producto.
		//Hacemos las iniciaciones pertinentes para intentar
		//aclarar un poco el codigo
		$ini_fila="<tr>";
		$fin_fila="</tr>";
		$ini_col='<td valign="top" nowrap>';
		$fin_col="</td>";
		$NUM_MAX_COLS=1;
		//Por cada columna un padre y sus hijos.
		$cadena='<table border="0">';
		$num_current_col=$NUM_MAX_COLS+1;		
		for ($i=0;$i<count($array_cat);$i++)
		{
			if ($num_current_col==$NUM_MAX_COLS+1)
			{
				$num_current_col=1;
				$cadena=$cadena.$ini_fila;
			}
			$cadena=$cadena.$ini_col;
			//Damos el padre para que empiece la recursividad			
			
			$cadena=$cadena.$this->build_col($new,$array_cat[$i],0,"vehicles");		
			//0 es el numero de tabulaciones inicial.
			//"vehicles" es el nombre que tendran los checkbox.
			$cadena=$cadena.$fin_col;
			$num_current_col++;
			if ($num_current_col==$NUM_MAX_COLS+1)
			{
				$cadena=$cadena.$fin_fila;
			}
		}
		
		//Si el numero de la columna actual es menor
		//que el numero maximo de columnas +1 
		//restamos al maximo la actual para saber cuantas faltan. 
		if ($num_current_col<$NUM_MAX_COLS+1)
		{			
			$cadena=$cadena.'<td colspan="'.($NUM_MAX_COLS+1-$num_current_col).'">&nbsp;'.$fin_col.$fin_fila;
		}
		$cadena=$cadena.'</table>';
		return $cadena;
	}
	
	function build_col($new,$array_cat,$tabulaciones,$variable){
		//Con esta funcion construimos el contenido de la columna
		//Del listado de checkbox de categorias de vehiculos
		$espacios="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$cadena="";
			
		//Hacemos las tabulaciones
		for ($j=0;$j<$tabulaciones;$j++)
			$cadena=$cadena.$espacios;
		$cadena=$cadena.'<img src="pics/separador.gif">&nbsp;';
		//Ponemos el checkbox. Si se quiere que haya una funcion que maneje por javascript su manejo, se debe incluir aqui
		//Insertamos el nombre
		$cadena=$cadena.$array_cat['name'];
	
		$cadena=$cadena.'<input type="checkbox" value="1" onClick="check_uncheck(this);" name="'.$variable.'_'.$array_cat['id_cat_vehicle'].'" id="'.$variable.'_'.$array_cat['id_cat_vehicle'].'" ';		
	
		//Si no es nuevo es por que puede que haya alguna categoria que este asignada al vehiculo y hay que marcarla.
		if (!$new){
			for($k=0;$k<count($this->vehicle_cat_list);$k++)
			{
				if ($array_cat['id_cat_vehicle']==$this->vehicle_cat_list[$k]['id_cat_vehicle'])
				{
					$cadena=$cadena.' checked ';
					break;
				}					
			}					
		}
		//Cerramos el checkbox
		$cadena=$cadena.'>';
		return $cadena;
	}
	
	function get_categories(){//Ojo funcion recursiva.
		//El parametro $all nos indica si se quieren todos los hijos, nietos...
		//a partir del id dado (0 para los padres), o solo los hijos de un solo padre.
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM `cat_vehicles`';
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		if ($this->result === false){
			$this->error=1;
			$this->db->close();
			return 0;
		}
		
		
		$this->num=0;
		$tabla = null;
		
		while (!$this->result->EOF) {
			//cogemos los datos de la categoria
			$tabla[$this->num]['id_cat_vehicle']=$this->result->fields['id_cat_vehicle'];
			$tabla[$this->num]['name']=$this->result->fields['name'];
	
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $tabla;
	}
	

	
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_vehicle."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			$this->db->close();
			return 0;		
		}else{
			$this->id_vehicle=$id;
			$this->id_corp=$this->result->fields[$this->ddbb_id_corp];
			$this->number_plate=$this->result->fields[$this->ddbb_number_plate];
			$this->alias=$this->result->fields[$this->ddbb_alias];
			$this->path_photo=$this->result->fields[$this->ddbb_path_photo];
			$this->category = $this->category_vehicles($id);
		
			$this->db->close();
			return 1;
		}
		
	
	}
	
	function category_vehicles($id){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT * FROM `rel_vehicles_cats` WHERE `id_vehicle`='.$id;
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		if ($this->result === false){
			$this->error=1;
			$this->db->close();
			return 0;
		}  
		
		while (!$this->result->EOF) {
			
			$id_category = $this->result->fields['id_cat_vehicle'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		//Se busca el nombre de la categoria a la que pertenece
		$categorias = new cat_vehicles();
		$categorias->read($id_category);
		return $categorias->name;
	}
	
	function show($id, $tpl)
	{
		$this->read($id);
		$tpl->assign('objeto', $this);
		return $tpl;
	}
	
	function add()
	{
		
		//Miramos a ver si esta definida el "submit_add" y si no lo esta, pasamos directamente a mostrar la plantilla
		if (!isset($_POST['submit_add']))
		{
			//Mostrar plantilla vacía	
			//pasarle a la plantilla las categorías de vehículos con sus respectivos checkbox a checked false
			
			return 0;
		}
		else		//en el caso de que SI este definido submit_add
		{
				//Entramos porque hemos introducido datos y aún no hemos preguntado por la foto
				//Introducir los datos de post.
				$this->get_fields_from_post();	
				
				$this->id_vehicle=0;
				$this->fields_list->modify_value($this->ddbb_id_vehicle,$this->id_vehicle);
				$this->fields_list->modify_value($this->ddbb_id_corp,$this->id_corp);
				$this->fields_list->modify_value($this->ddbb_number_plate,$this->number_plate);
				$this->fields_list->modify_value($this->ddbb_alias,$this->alias);
				//validamos
				
				$return=$this->fields_list->validate();	
				//Validacion
				//$return=validate_fields();
				
				//En caso de que la validacion haya sido fallida se muestra la plantilla
				//con los campos erroneos marcados con un *
				
				
				if (!$return)
				{
					//Mostrar plantilla con datos erroneos
					return -1;
				}
				else
				{
					//Si todo es correcto si meten los datos
					
					//Se copia el fichero de la foto elegida por el usuario en el servidor
					
					
					//Se añaden los campos a la base de datos
					$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
					//crea una nueva conexi—n con una bbdd (mysql)
					$this->db = NewADOConnection($this->db_type);
					//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
					$this->db->debug=false;
					//realiza una conexi—n permanente con la bbdd
					$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
					//mete la consulta para coger los campos de la bbdd
					$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_vehicle." = -1" ;
					//la ejecuta y guarda los resultados
					$this->result = $this->db->Execute($this->sql);
					//si falla 
					if ($this->result === false)
					{
						$this->error=1;
						$this->db->close();
						return 0;
					}
					//rellenamos el array con los datos de los atributos de la clase
					$record = array();
					$record[$this->ddbb_id_corp] = $this->id_corp;
					$record[$this->ddbb_alias]=$this->alias;
					$record[$this->ddbb_number_plate]=$this->number_plate;
					$record[$this->ddbb_path_photo]=$this->path_photo;
					
					//calculamos la sql de inserci—n respecto a los atributos
					$this->sql = $this->db->GetInsertSQL($this->result, $record);
					//print($this->sql);
					//insertamos el registro
					$this->db->Execute($this->sql);
					//si se ha insertado una fila
					if($this->db->Insert_ID()>=0)
					{
						//capturammos el id de la linea insertada
						$this->id_vehicle=$this->db->Insert_ID();
						//capturammos el id de la linea insertada
						//Introducimos categorias;
						$this->insert_categories($this->id_vehicle);
												
						//Se introduce consulta en la bbdd
						
						
						$this->db->close();
						
						//se inserto el vehiculo, ahora se inserta la foto y se modifica el registro para indicar la ruta
						if($_SESSION['ruta_temporal'] != "")
						{
   							$file = new upload_file( $_SESSION['nombre_photo'], $_SESSION['ruta_temporal'], $_SESSION['tamanno_photo'], $this->id_vehicle);
							$result = $file->upload( "images/vehicles/" );
   							if($result == 1)
   							{
   								//modificar ruta de la foto
								$this->modify_photo($this->id_vehicle);
							}
   						}	
						else
						{
							$direccion = "C:\\wamp\\www\\transporte\\images\\vehicles\\".$this->id_vehicle.".GIF";
							//Copiar fichero con no imagen
							
							if (!copy("C:\\wamp\\www\\transporte\\pics\\no-image.gif",$direccion))
							{
   								print("Error al copiar el fichero");
							}
							else
							{
								$_SESSION['ruta_photo'] = "images/vehicles/".$this->id_vehicle.".GIF";
								//modificar ruta de la foto
								$this->modify_photo($this->id_vehicle);
							}
						}
						return $this->id_vehicle;
					}
					else 
					{
						//devolvemos 0 ya que no se ha insertado el registro
						$this->error=-1;
						$this->db->close();
						return 0;
					}	
					
				}
		}
	}
	
	function insert_categories($id_vehicle){
		$rel_vehicles_cat = new rel_vehicles_cats();
		if (is_array($this->vehicle_cat_list))
			foreach($this->vehicle_cat_list as $cat){
				$rel_vehicles_cat->id_cat_vehicle=$cat['id_cat_vehicle'];
				$rel_vehicles_cat->id_vehicle=$id_vehicle;
				$rel_vehicles_cat->add();
			}
		return 0;
	}

	
	function add_category($id)
	{
		$category=new rel_vehicles_cats();
		$category->id_vehicle=$id;
		$category->id_cat_vehicle=$this->category;
		return $category->add();
	}
	
	function sig_id()
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." ORDER BY id_vehicle";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$this->error=1;
			$this->db->close();

			return 0;
		}  
		
		
		//cogemos los datos del usuario
		$this->num=0;
		while (!$this->result->EOF) 
		{
			$this->vehicles_list[$this->num][$this->ddbb_id_vehicle]=$this->result->fields[$this->ddbb_id_vehicle];
			$this->vehicles_list[$this->num][$this->ddbb_id_corp]=$this->result->fields[$this->ddbb_id_corp];
			$this->vehicles_list[$this->num][$this->ddbb_number_plate]=$this->result->fields[$this->ddbb_number_plate];
			$this->vehicles_list[$this->num][$this->ddbb_alias]=$this->result->fields[$this->ddbb_alias];
			$this->vehicles_list[$this->num][$this->ddbb_path_photo]=$this->result->fields[$this->ddbb_path_photo];
			
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
	
	
		
		$this->db->close();
		
		return $this->vehicles_list[$this->num-1][$this->ddbb_id_vehicle] + 1;
	
	}
	
	
	function get_fields_from_post(){
		//Cogemos los campos principales
		$this->id_corp=$_SESSION['ident_corp'];
		$this->alias=htmlentities($_POST[$this->ddbb_alias]);
		$this->number_plate=htmlentities($_POST[$this->ddbb_number_plate]);
		$this->path_photo = $_SESSION['ruta_photo'];	
		//Cogemos las categorias
		//$this->category=$_POST["category"];
		$this->get_categories_from_post();
	
		return 0;
	}
	
		
	function get_categories_from_post(){
		//cogemos todas(true) las categorias que hay en bbdd desde los padres huerfanos(0)
		
		$categorias_bbdd=$this->get_categories();
		
		//Se inicia $this->num a 0 por que va a servir de indice para 
		//la lista $this->categorias
		$this->num=0;		
		$this->vehicle_cat_list="";
		//con esta lista cogemos los checkbox que esten señalados en el formulario
		
		$this->get_checkbox_categories($categorias_bbdd,'vehicles');
		
		return 0;
	}
	
		
	function get_checkbox_categories($cats,$variable){
		//Recorremos el array de categorias q hay en bbdd
		//para coger los checkbox activados en el formulario
		for ($i=0;$i<count($cats);$i++){
			//almacenamos el valor del checkbox
			$checkbox=$_POST[$variable."_".$cats[$i]['id_cat_vehicle']];
		
			if ($checkbox==1){
				//Si es = a 1 entonces es que esta seleccionado.
				$this->vehicle_cat_list[$this->num]['id_cat_vehicle']=$cats[$i]['id_cat_vehicle'];
			
				//incrementamos el valor de num
				$this->num++;				
			}
			
		}		
		return 0;
	}

		
	function remove($id){
		if (!isset($_POST["submit_delete"]))
		{				
			return 0;
		}
		else
		{
			//Se borra el vehiculo de la bbdd
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//Crea una nueva conexión con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexión de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexión permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_vehicle." = ".$id;
			//la ejecuta y guarda los resultados		
			$this->result = $this->db->Execute($this->sql);
			//si falla 
			if ($this->db->Affected_Rows() == 0)
			{				
				$this->error=1;
				$this->db->close();
				return 0;
			}
			else
			{
				$this->make_remove($id);
				$this->error=0;
				$this->db->close();				
				//Se borra la foto asociada con el vehiculo, si hay
				if($this->path_photo != "")
					unlink($this->path_photo);
				return 1;	
			}
		}		
	}
	
	function make_remove($id){
		//borramos todos aquellos registros en los que hay un id_user;		
		for ($i=0;$i<count($this->table_names_delete);$i++){
			$this->delete_all_id_vehicle($id,$this->table_names_delete[$i]);
		}
	}
	
	function delete_all_id_vehicle($id,$table)
	{
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexión con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexión de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexión permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.

			$this->sql="DELETE FROM ".$table. " WHERE id_vehicle = ".$id;
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
	
	function modify_photo()
	{
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_vehicle." = \"".$this->id_vehicle."\"" ;
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();
			return 0;
		}
		//rellenamos el array con los datos de los atributos de la clase
		$record = array();
		$record[$this->ddbb_id_vehicle]=$this_vehicle;
		$record[$this->ddbb_path_photo]=$_SESSION['ruta_photo'];
		//calculamos la sql de insercin respecto a los atributos
		$this->sql = $this->db->GetUpdateSQL($this->result, $record);
		//insertamos el registro				
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		$Affected_Rows=$this->db->Affected_Rows();
				
		if(($Affected_Rows==1)||($this->sql==""))
		{
			//capturammos el id de la linea insertada
			$this->db->close();
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_vehicle;
		}
		else 
		{
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}
	}
	
	function modify(){
		if (!isset($_POST['submit_modify']))
		{
			
			return 0;
		}
		else{
			//Introducir los datos de post.
			
	
			
			//Si se modificó la foto
			if($_SESSION['ruta_temporal'] != "")
			{
   				$file = new upload_file( $_SESSION['nombre_photo'], $_SESSION['ruta_temporal'], $_SESSION['tamanno_photo'], $this->id_vehicle, $this->path_photo);
   				$result = $file->upload( "images/vehicles/" );
				if($result == 1)
   				{
   					//modificar ruta de la foto
					$this->modify_photo($this->id_vehicle);
				}
   			}	
			
			$this->get_fields_from_post();
			
			//$this->insert_post();
			$this->fields_list->modify_value($this->ddbb_id_vehicle,$this->id_vehicle);
			$this->fields_list->modify_value($this->ddbb_id_corp,$this->id_corp);
			$this->fields_list->modify_value($this->ddbb_number_plate,$this->number_plate);
			$this->fields_list->modify_value($this->ddbb_alias,$this->alias);
				//validamos
				
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
				$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
				//crea una nueva conexin con una bbdd (mysql)
				$this->db = NewADOConnection($this->db_type);
				//le dice que no salgan los errores de conexin de la ddbb por pantalla
				$this->db->debug=false;
				//realiza una conexin permanente con la bbdd
				$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
				//mete la consulta para coger los campos de la bbdd
				$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_vehicle." = \"".$this->id_vehicle."\"" ;
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
				$record[$this->ddbb_id_vehicle]=$this->id_vehicle;
				$record[$this->ddbb_id_corp]=$this->id_corp;
				$record[$this->ddbb_alias] = $this->alias;
				$record[$this->ddbb_number_plate]=$this->number_plate;
				$record[$this->ddbb_path_photo]=$this->path_photo;
				//calculamos la sql de insercin respecto a los atributos
				$this->sql = $this->db->GetUpdateSQL($this->result, $record);
				//insertamos el registro				
				$this->db->Execute($this->sql);
				//si se ha insertado una fila
				$Affected_Rows=$this->db->Affected_Rows();
				/*Al hacer la modificacion de categorias antes del siguiente "if"
				 se debe de guardar en una variable el contenido de las filas afectadas y hacer
				 la condicion del if con esa variable ya que al hacer las modificaciones ese valor varía.
				*/
			/*	
				$return_category=$this->modify_category($this->id_emp);
			
				if(($Affected_Rows==1)||($user_changed!=0)||($this->sql=="")||($return_category!=0))
				{
					//capturammos el id de la linea insertada
					$this->db->close();
					//devolvemos el id de la tabla ya que todo ha ido bien
					return $this->id_vehicle;
				}
				else 
				{
					//devolvemos 0 ya que no se ha insertado el registro
					$this->error=-1;
					$this->db->close();
					return 0;
				}*/
				
				$return_categories=$this->modify_categories();
		if(($Affected_Rows==1)||($this->sql=="")||$return_categories==1){
			//capturammos el id de la linea insertada
			$this->db->close();
			
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_vehicle;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}
			}
		}	
	}
	
		
	function modify_categories(){
		$rel_vehicles_cats=new rel_vehicles_cats();
		
		//Leemos las categorias que estan en bbdd;
		$cats_in_bbdd=$rel_vehicles_cats->get_rel_vehicle_cat($this->id_vehicle);
		/**
		Las categorias que estan en el formulario ya se han leido 
		y estan en $this->vehicle_cat_list
		Se crearan 2 arrays nuevos $nuevas y $borradas
		Las categorias que esten en la bbdd y no esten en el formulario
		seran las borradas, y las que esten en el formulario y no en la
		bbdd son las nuevas
		*/
		//Vemos los borrados
		$k=0;
		for ($i=0;$i<count($cats_in_bbdd);$i++)
		{
			$result=false;
			for ($j=0;$j<count($this->vehicle_cat_list);$j++)
			{
				if ($cats_in_bbdd[$i]['id_cat_vehicle']==$this->vehicle_cat_list[$j]['id_cat_vehicle'])
				{
					$result=true;
					break;
				}
			}		
			if (!$result)
			{
				$borrados[$k]['id_cat_vehicle']=$cats_in_bbdd[$i]['id_cat_vehicle'];
				$borrados[$k]['id_rel_vehicle_cat']=$cats_in_bbdd[$i]['id_rel_vehicle_cat'];
				$k++;
			}
		}
		
		//Ahora vemos los nuevos
		$k=0;
		for ($i=0;$i<count($this->vehicle_cat_list);$i++){
			$result=false;
			for ($j=0;$j<count($cats_in_bbdd);$j++){
				if ($cats_in_bbdd[$i]['id_cat_vehicle']==$this->vehicle_cat_list[$j]['id_cat_vehicle']){
					$result=true;
					break;
				}
			}		
			if (!$result){
				$nuevos[$k]=$this->vehicle_cat_list[$i]['id_cat_vehicle'];
				$k++;
			}
		}
		//Borramos los que supuestamente se han borrado
		for ($i=0;$i<count($borrados);$i++){
			$rel_vehicles_cats->remove($borrados[$i]['id_rel_vehicle_cat']);			
		}
		//Añadimos los nuevos
		for ($i=0;$i<count($nuevos);$i++){
			$rel_vehicles_cats->id_vehicle=$this->id_vehicle;
			$rel_vehicles_cats->id_cat_vehicle=$nuevos[$i];
			$rel_vehicles_cats->add();
		}
		if ((count($nuevos)==0)&&(count($borrados)==0))
			return 0;
		else
			return 1;
	}

	
	
	function modify_category($id)
	{
		$category=new rel_vehicles_cats();
		$return=$category->read($category->get_rel_vehicle_cat($this->id_vehicle));
		if ($return==0){
			return $this->add_category($id);
		}
		$category->id_vehicle=$id;
		$category->id_cat_vehicle=$this->category;
		return $category->modify();
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
			// Leemos el vehículo y se lo pasamos a la plantilla
			$this->read($id);
			$tpl->assign('objeto',$this);	
			
			$user = new users();
			$id_user = $_SESSION['ident_user'];
			$user->validate_per_user($id_user);
			
			if(!$_SESSION['super'] && !$_SESSION['admin'])
			{	
				$drivers = false;
				$laborers = false;
			
				$i=0;
				while($i!=$user->num_modules)
				{
			
					if(($user->per_modules[$i]->per == 1)&&($user->per_modules[$i]->module_name=='drivers'))
					{
					//Se comprueba si se tiene permiso para ver
						$j=0;
						while(($j<$user->per_modules[$i]->num_methods))
						{
							if(($user->per_modules[$i]->per_methods[$j]->per == 1)&&($user->per_modules[$i]->per_methods[$j]->method_name == 'view'))
							{
								$drivers = true;
							}
							$j++;
						}
					}
					else 
					if(($user->per_modules[$i]->per == 1)&&($user->per_modules[$i]->module_name=='laborers'))
					{
						//Se comprueba si se tiene permiso para ver
						$j=0;
						while(($j<$user->per_modules[$i]->num_methods))
						{
							if(($user->per_modules[$i]->per_methods[$j]->per == 1)&&($user->per_modules[$i]->per_methods[$j]->method_name == 'view'))
							{
								$laborers = true;
							}
							$j++;
						}
					}
					
					$i++;
					
				}

			}
			else
			{
				$drivers = true;
				$laborers = true;
			}
			
			$mensaje = null;
			$mensaje[0]['id_mensaje'] = 1;
			$mensaje[0]['mes'] = "Sentimos informarle de que no tiene permiso para acceder a esta información";
			
			//listado de conductores
			$tabla_listado_drivers = new table(false);
			if($drivers)
			{
				$conductor = new drivers();
				$num_drivers = $conductor->get_list_drivers_vehicle($_GET['id']);

				if ($num_drivers==0)
				{
					$cadena=$cadena.$tabla_listado_drivers->tabla_vacia('drivers', false);
					$variables_drivers=$tabla_listado_drivers->nombres_variables;
				}
				else
				{	
					$cadena=$cadena.$tabla_listado_drivers->make_tables('drivers',$conductor->drivers_list,array('Nombre',20,'Primer Apellido',20,'Segundo Apellido',20),array($conductor->ddbb_id_driver, $conductor->ddbb_name, $conductor->ddbb_last_name, $conductor->ddbb_last_name2),$_SESSION['num_regs'],array(),false);
					$variables_drivers=$tabla_listado_drivers->nombres_variables;	
				}				
			}
			else
			{
				$cadena=$cadena.$tabla_listado_drivers->make_tables('drivers',$mensaje,array('ACCION NO PERMITIDA',50),array('id_mensaje','mes'),10,null,false);
				$variables_drivers=$tabla_listado_drivers->nombres_variables;
			}
			
			
			//listado de permisos por modulos
			$tabla_listado_laborers = new table(false);
			if($laborers)
			{
				
				$peon = new laborers();
				$num_laborers = $peon->get_list_laborers_vehicle($_GET['id']);
						
				if ($num_laborers==0)
				{
					$cadena=$cadena.$cadena.$tabla_listado_laborers->tabla_vacia('laborers', false);
					//print ("Cadena".$cadena);
					$variables_laborers=$tabla_listado_laborers->nombres_variables;
				}
				else
				{	
					$cadena=$cadena.$tabla_listado_laborers->make_tables('laborers',$peon->laborers_list,array('Nombre',20,'Primer Apellido',20,'Segundo Apellido',20),array($peon->ddbb_id_laborer, $peon->ddbb_name, $peon->ddbb_last_name, $peon->ddbb_last_name2),$_SESSION['num_regs'],array(),false);
					$variables_laborers=$tabla_listado_laborers->nombres_variables;	
				}	
			}
			else
			{
				$cadena=$cadena.$tabla_listado_laborers->make_tables('laborers',$mensaje,array('ACCION NO PERMITIDA',50),array('id_mensaje','mes'),10,null,false);
				$variables_laborers=$tabla_listado_laborers->nombres_variables;
			}
			
			
			
			$i=0;
			while($i<(count($variables_grupos)+count($variables_modulos))){
				for($j=0;$j<count($variables_drivers);$j++){
					$variables[$i]=$variables_drivers[$j];
					$i++;
				}
				for($k=0;$k<count($variables_laborers);$k++){
					$variables[$i]=$variables_laborers[$k];
					$i++;
				}
			}
						
			$tpl->assign('variables',$variables);
			$tpl->assign('cadena',$cadena);	
		
			return $tpl;
				
	}
	
	function listar($tpl){
		if (isset($_POST['submit_vehicles_search']))
		{
			//Se toma el número de registros y se guarda en varable de sesión
			//que se cumpla en todos los accesos del usuario
			$_SESSION['num_regs']= $_POST['regs'];
			
		}
		$num = $this->get_list_vehicles($_SESSION['ident_corp']);
		$tabla_listado = new table(true);			
		$per = new permissions();
		$per->get_permissions_list('vehicles');
		if ($num==0)
		{
			$cadena=''.$tabla_listado->tabla_vacia('vehicles', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{
			$cadena=''.$tabla_listado->make_tables('vehicles',$this->vehicles_list,array('Alias',40,'Matr&iacute;cula',40),array($this->ddbb_id_vehicle,$this->ddbb_alias,$this->ddbb_number_plate),$_SESSION['num_regs'],$per->permissions_module,$per->add);
			$variables=$tabla_listado->nombres_variables;
		}		
		$tpl->assign('variables',$variables);
		$tpl->assign('cadena',$cadena);		
		return $tpl;
	}
	
	
	function calculate_tpl($method, $tpl){
		$this->method=$method;
				switch($method){
						case 'add':	/*
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
												$this->vehicles_list = "";
												$this->method="list";
												$tpl=$this->listar($tpl);										
												$tpl->assign("message","&nbsp;<br>Veh&iacute;culo a&ntilde;adido correctamente<br>&nbsp;");
												break;
									}
									$this->cat_vehicles=new cat_vehicles();
									$tpl->assign("categorias",$this->cat_vehicles->cat_vehicles_list);
									$tpl->assign("objeto",$this);
									break;*/
									$return=$this->add();
									switch ($return){										
										case 0: //por defecto
												$tpl->assign("tabla_checkbox",$this->table_categories(true));
												break;
										case -1: //Errores al intentar añadir datos
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
												}
												$tpl->assign("tabla_checkbox",$this->table_categories(false));
												break;
										default: //Si se ha añadido
												$this->vehicles_list = "";
												$this->method="list";
												$tpl=$this->listar($tpl);										
												$tpl->assign("message","&nbsp;<br>Veh&iacute;culo a&ntilde;adido correctamente<br>&nbsp;");
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
						case 'modify':/*
									$this->read($_GET['id']);
									if ($this->modify() !=0)
									{
										$this->vehicles_list = "";
										$this->method="list";
										$tpl=$this->listar($tpl);										
										$tpl->assign("message","&nbsp;<br>Veh&iacute;culo modificado correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
									$tpl->assign("categorias",$this->cat_vehicles->cat_vehicles_list);
									break;*/
									/*
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
												$this->vehicles_list = "";
												$this->method="list";
												$tpl=$this->listar($tpl);										
												$tpl->assign("message","&nbsp;<br>Veh&iacute;culo modificado correctamente<br>&nbsp;");
												break;
									}
									$this->cat_vehicles=new cat_vehicles();
									$tpl->assign("categorias",$this->cat_vehicles->cat_vehicles_list);
									$tpl->assign("objeto",$this);
									break;*/
									
									$this->read($_GET['id']);
									$return=$this->modify();
									switch ($return){										
										case 0: //por defecto
												$tpl->assign("tabla_checkbox",$this->table_categories(false));
												break;
										case -1: //Errores al intentar añadir datos
												for ($i=0;$i<count($this->fields_list->array_error);$i+=2){
													$tpl->assign("error_".$this->fields_list->array_error[$i],$this->fields_list->array_error[$i+1]);
												}
												$tpl->assign("tabla_checkbox",$this->table_categories(false));
												break;
										default: //Si se ha añadido
												$this->method="list";
												$tpl=$this->listar($tpl);
												$tpl->assign("message","&nbsp;<br>Veh&iacute;culo modificado correctamente<br>&nbsp;");
												break;
									}
									//esto se hace independientemetne del valor que se obtenga
									$tpl->assign("objeto",$this);
									break;
									
						case 'delete':
									$this->read($_GET['id']);
									if ($this->remove($_GET['id'])==0){
										//$tpl->assign("message",$this->emps);
									}
									else{
										$this->vehicles_list = "";
										$this->method="list";
										$tpl=$this->listar($tpl);
										$tpl->assign("message","&nbsp;<br>Veh&iacute;culo borrado correctamente<br>&nbsp;");
									}
									$tpl->assign("objeto",$this);
									break;
						case 'view':									
									$tpl=$this->view($_GET['id'],$tpl);
									break;
						case 'show':
									$tpl=$this->show($_GET['id'], $tpl);									
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
				$tpl->assign('plantilla','vehicles_'.$this->method.'.tpl');					
		
		return $tpl;
	}

	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}		
	if ($corp != ""){
			$corp='<a href="index.php?module=user_corps&method=select&id='.$_SESSION['ident_corp'].'">'.$corp.' ::';
		}
		$nav_bar = '<a>Zona privada</a> :: '.$corp.' <a href="index.php?module=vehicles">Vehículos</a>';
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
		$title = "Zona Privada :: $corp Vehículos";
		$title=$title.$this->localice($method);		
		return $title;
	}		
	
	
	function localice($method){	
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Vehículos";
									break;
						case 'list':
									$localice=" :: Buscar Vehículos";
									break;
						case 'modify':
									$localice=" :: Modificar Vehículos";
									break;
						case 'delete':
									$localice=" :: Borrar Vehículos";
									break;
						case 'view':
									$localice=" :: Ver Vehículos";	
									break;
						case 'show':
									$localice=" :: Ver foto del Vehículo";	
									break;
						default:
									$localice=" :: Buscar Vehículos";
									break;
		}
		return $localice;
	}
	
	
}
?>