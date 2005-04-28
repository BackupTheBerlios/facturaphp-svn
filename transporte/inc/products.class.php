<?php
//clase que da soporte a los productos del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");
class products{
//internal vars
	var $id_product;
	var $id_corp;
	var $name;
	var $name_web;
	var $path_photo;
	var $pvp;
	var $tax;
	var $pvp_tax;
	var $minimun_stock;
	var $descrip;
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
	var $table_name='products';
	var $ddbb_id_product='id_product';
	var $ddbb_id_corp='id_corp';
	var $ddbb_name='name';
	var $ddbb_name_web='name_web';
	var $ddbb_path_photo='path_photo';
	var $ddbb_pvp='pvp';
	var $ddbb_tax='tax';
	var $ddbb_pvp_tax='pvp_tax';
	var $ddbb_minimun_stock='minimun_stock';
	var $ddbb_descrip='descrip';
	var $ddbb_search='search';
	var $db;
	var $result;  
	var $sql;
	
//variables complementarias	
  	var $products_list;
  	var $num;
  	var $fields_list;
  	var $error;
	var $method;
	var $table_names_modify=array();
	var $table_names_delete=array('rel_prods_cats');
	var $prod_cat_list;
//variable para complementar las busquedas
	var $sql_complement;

  	//constructor
	function products()
	{
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
		$this->fields_list->add($this->ddbb_id_product, $this->id_product, 'int', 11,0);
		$this->fields_list->add($this->ddbb_id_corp, $this->id_corp, 'int', 11,0);
		$this->fields_list->add($this->ddbb_name, $this->name, 'varchar', 50,0,1);
		$this->fields_list->add($this->ddbb_name_web, $this->name_web, 'varchar', 50,0);
		$this->fields_list->add($this->ddbb_pvp, $this->pvp, 'double', 11,0,1);
		$this->fields_list->add($this->ddbb_tax, $this->tax, 'double', 11,0,1);
		$this->fields_list->add($this->ddbb_pvp_tax, $this->pvp_tax, 'double', 11,0);
		$this->fields_list->add($this->ddbb_path_photo, $this->path_photo, 'varchar', 255,0);
		$this->fields_list->add($this->ddbb_minimun_stock, $this->minimun_stock, 'double', 11,0,1);
		$this->fields_list->add($this->ddbb_descrip, $this->descrip, 'text', 255,0);

		$this->search[0]= 'name';
		$this->search[1]= 'name_web';
		
		
		return $this;	 
		
	}
	
	function get_list_products ($id_corp){
		if (isset($_POST['submit_products_search']))
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
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE (".$query.") AND `id_corp` = ".$id_corp;
		else
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE `id_corp` = ".$id_corp;
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
			$this->products_list[$this->num][$this->ddbb_id_product]=$this->result->fields[$this->ddbb_id_product];
			$this->products_list[$this->num][$this->ddbb_id_corp]=$this->result->fields[$this->ddbb_id_corp];
			$this->products_list[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
			$this->products_list[$this->num][$this->ddbb_name_web]=$this->result->fields[$this->ddbb_name_web];
			$this->products_list[$this->num][$this->ddbb_pvp]=$this->result->fields[$this->ddbb_pvp];
			$this->products_list[$this->num][$this->ddbb_tax]=$this->result->fields[$this->ddbb_tax];
			$this->products_list[$this->num][$this->ddbb_pvp_tax]=$this->result->fields[$this->ddbb_pvp_tax];
			$this->products_list[$this->num][$this->ddbb_path_photo]=$this->result->fields[$this->ddbb_path_photo];
			$this->products_list[$this->num][$this->ddbb_minimun_stock]=$this->result->fields[$this->ddbb_minimun_stock];
			$this->products_list[$this->num][$this->ddbb_descrip]=$this->result->fields[$this->ddbb_descrip];
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
	
	function listar($tpl){
		if (isset($_POST['submit_products_search']))
		{
			//Se toma el número de registros y se guarda en varable de sesión
			//que se cumpla en todos los accesos del usuario
			$_SESSION['num_regs']= $_POST['regs'];
			
		}
		$num = $this->get_list_products($_SESSION['ident_corp']);
		$tabla_listado = new table(true);
		$per = new permissions();
		$per->get_permissions_list('products');
		if ($num==0)
		{
			$cadena=''.$cadena.$tabla_listado->tabla_vacia('products', $per->add);
			$variables=$tabla_listado->nombres_variables;
		}
		else
		{	
			$cadena=''.$tabla_listado->make_tables('products',$this->products_list,array('Nombre',40,'Nombre en Factura',40),array($this->ddbb_id_product,$this->ddbb_name,$this->ddbb_name_web),$_SESSION['num_regs'],$per->permissions_module,$per->add);
			$variables=$tabla_listado->nombres_variables;
		}		
		$tpl->assign('variables',$variables);
		$tpl->assign('cadena',$cadena);		
		return $tpl;
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE ".$this->ddbb_id_product."= \"".$id."\"";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 
		if ($this->result === false){
			$error=1;
			return 0;
			$this->db->close();
		}else{
			$this->id_product=$id;
			$this->name=$this->result->fields[$this->ddbb_name];
			$this->name_web=$this->result->fields[$this->ddbb_name_web];
			$this->path_photo=$this->result->fields[$this->ddbb_path_photo];
			$this->pvp=$this->result->fields[$this->ddbb_pvp];
			$this->tax=$this->result->fields[$this->ddbb_tax];
			$this->pvp_tax=$this->result->fields[$this->ddbb_pvp_tax];
			$this->minimun_stock=$this->result->fields[$this->ddbb_minimun_stock];
			$this->descrip=$this->result->fields[$this->ddbb_descrip];
			$this->db->close();
			return 1;
		}
		
	
	}
	
	function add(){
		if (!isset($_POST['submit_add'])){
			//Mostrar plantilla vacía	
			return 0;
		}
		//en el caso de que SI este definido submit_add
		else{
						
			//Introducir los datos de post.
			$this->get_fields_from_post();

			
			//Validacion
			
			//Modificamos los todos los valores del objeto fields con los nuevos datos del objeto product, exceptuando path_photo que eso se deberia hacer mediante la clase upload.
			//Al id_product se le da 0 por quse neecesita un valor para que 
			$this->id_product=0;
			$this->fields_list->modify_value($this->ddbb_id_product,$this->id_product);
			$this->fields_list->modify_value($this->ddbb_id_corp,$this->id_corp);
			$this->fields_list->modify_value($this->ddbb_minimun_stock,$this->minimun_stock);
			$this->fields_list->modify_value($this->ddbb_descrip,$this->descrip);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_name_web,$this->name_web);
			$this->fields_list->modify_value($this->ddbb_pvp,$this->pvp);
			$this->fields_list->modify_value($this->ddbb_tax,$this->tax);
			$this->fields_list->modify_value($this->ddbb_pvp_tax,$this->pvp_tax);
			//validamos
			$return=$this->fields_list->validate();		
			//$return=true;
			//$return=validate_fields();
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			 //Para pruebas dejar esta linea sin comentar
			
			if (!$return){
				//Mostrar plantilla con datos erroneos				
				//Como hay que asignar variables al tpl se hara desde calculate tpl pero devolviendo aqui un -1
				return -1;
			}
			else{
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexi—n con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexi—n de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexi—n permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_corp." = -1" ;
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
			$record[$this->ddbb_name]=$this->name;
			$record[$this->ddbb_name_web]=$this->name_web;
			$record[$this->ddbb_path_photo]=$this->path_photo;
			$record[$this->ddbb_pvp]=$this->pvp;
			$record[$this->ddbb_tax] = $this->tax;
			$record[$this->ddbb_pvp_tax]=$this->pvp_tax;
			$record[$this->ddbb_minimun_stock]=$this->minimun_stock;
			$record[$this->ddbb_descrip]=$this->descrip;
			//calculamos la sql de inserci—n respecto a los atributos
			$this->sql = $this->db->GetInsertSQL($this->result, $record);
			
			//insertamos el registro
			$this->db->Execute($this->sql);
			//si se ha insertado una fila
			if($this->db->Insert_ID()>=0){
				//capturammos el id de la linea insertada
				$this->id_product=$this->db->Insert_ID();
				$this->insert_categories($this->id_product);
				if($_SESSION['ruta_temporal'] != "")
				{
   					$file = new upload_file( $_SESSION['nombre_photo'], $_SESSION['ruta_temporal'], $_SESSION['tamanno_photo'], $this->id_product);
   					$result = $file->upload( "images/products/" );
   					if($result == 1)
   					{
   						//modificar ruta de la foto
						$this->modify_photo($this->id_cat_prod);
					}
   				}
				else
				{
					$direccion = "images/products/".$this->id_product.".gif";
					//Copiar fichero con no imagen
					if (!copy("pics/no-image.gif",$direccion))
					{
   						print("Error al copiar el fichero");
					}
					else
					{
						$_SESSION['ruta_photo'] = "images/products/".$this->id_product.".gif";
						//modificar ruta de la foto
						$this->modify_photo($this->id_product);
					}
				}	
				//print("<pre>::".$this->id_corp."::</pre>");
				//devolvemos el id de la tabla ya que todo ha ido bien
				$this->db->close();
				return $this->id_product;
			}else {
				//devolvemos 0 ya que no se ha insertado el registro
				
				$this->error=-1;
				$this->db->close();
				return 0;
			}			
		
			}}
	}
	
	function insert_categories($id_product){
		$rel_prods_cat = new rel_prods_cats();
		if (is_array($this->prod_cat_list))
			foreach($this->prod_cat_list as $cat){
				$rel_prods_cat->id_cat_prod=$cat['id_cat_prod'];
				$rel_prods_cat->id_product=$id_product;
				$rel_prods_cat->add();
			}
		return 0;
	}
	
	function modify_categories(){
		$rel_prods_cats=new rel_prods_cats();
		
		//Leemos las categorias que estan en bbdd;
		$cats_in_bbdd=$rel_prods_cats->get_rel_prod_cat($this->id_product);
		/**
		Las categorias que estan en el formulario ya se han leido 
		y estan en $this->prod_cat_list
		Se crearan 2 arrays nuevos $nuevas y $borradas
		Las categorias que esten en la bbdd y no esten en el formulario
		seran las borradas, y las que esten en el formulario y no en la
		bbdd son las nuevas
		*/
		//Vemos los borrados
		$k=0;
		for ($i=0;$i<count($cats_in_bbdd);$i++){
			$result=false;
			for ($j=0;$j<count($this->prod_cat_list);$j++){
				if ($cats_in_bbdd[$i]['id_cat_prod']==$this->prod_cat_list[$j]['id_cat_prod']){
					$result=true;
					break;
				}
			}		
			if (!$result){
				$borrados[$k]['id_cat_prod']=$cats_in_bbdd[$i]['id_cat_prod'];
				$borrados[$k]['id_rel_prod_cat']=$cats_in_bbdd[$i]['id_rel_prod_cat'];
				$k++;
			}
		}
		
		//Ahora vemos los nuevos
		$k=0;
		for ($i=0;$i<count($this->prod_cat_list);$i++){
			$result=false;
			for ($j=0;$j<count($cats_in_bbdd);$j++){
				if ($cats_in_bbdd[$i]['id_cat_prod']==$this->prod_cat_list[$j]['id_cat_prod']){
					$result=true;
					break;
				}
			}		
			if (!$result){
				$nuevos[$k]=$this->prod_cat_list[$i]['id_cat_prod'];
				$k++;
			}
		}
		//Borramos los que supuestamente se han borrado
		for ($i=0;$i<count($borrados);$i++){
			$rel_prods_cats->remove($borrados[$i]['id_rel_prod_cat']);			
		}
		//Añadimos los nuevos
		for ($i=0;$i<count($nuevos);$i++){
			$rel_prods_cats->id_product=$this->id_product;
			$rel_prods_cats->id_cat_prod=$nuevos[$i];
			$rel_prods_cats->add();
		}
		if ((count($nuevos)==0)&&(count($borrados)==0))
			return 0;
		else
			return 1;
	}
	
	
	function modify_photo($id_cat_prod)
	{
	
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta para coger los campos de la bbdd
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_product." = \"".$this->id_product."\"" ;
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
		$record[$this->ddbb_id_product]=$this->id_product;
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
			return $this->id_product;
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
	if (!isset($_POST['submit_modify'])){
			//Mostrar plantilla vacía		
			
			return 0;
		}
		else{
			//Introducir los datos de post.
			//Si se modificó la foto
			if($_SESSION['ruta_temporal'] != "")
				{
   				$file = new upload_file( $_SESSION['nombre_photo'], $_SESSION['ruta_temporal'], $_SESSION['tamanno_photo'], $this->id_product,$this->path_photo);
   				$result = $file->upload( "images/products/" );
   				}	
			

			$this->get_fields_from_post();
			//$this->insert_post();
			
			//Validacion
			
			//Modificamos los todos los valores del objeto fields con los nuevos datos del objeto product, exceptuando path_photo que eso se deberia hacer mediante la clase upload.
			$this->fields_list->modify_value($this->ddbb_id_product,$this->id_product);
			$this->fields_list->modify_value($this->ddbb_id_corp,$this->id_corp);
			$this->fields_list->modify_value($this->ddbb_minimun_stock,$this->minimun_stock);
			$this->fields_list->modify_value($this->ddbb_descrip,$this->descrip);
			$this->fields_list->modify_value($this->ddbb_name,$this->name);
			$this->fields_list->modify_value($this->ddbb_name_web,$this->name_web);
			$this->fields_list->modify_value($this->ddbb_pvp,$this->pvp);
			$this->fields_list->modify_value($this->ddbb_tax,$this->tax);
			$this->fields_list->modify_value($this->ddbb_pvp_tax,$this->pvp_tax);
			//validamos
			$return=$this->fields_list->validate();		
			
			//En caso de que la validacion haya sido fallida se muestra la plantilla
			//con los campos erroneos marcados con un *
			//$return=true; //Para pruebas dejar esta linea sin comentar
			
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
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_product." = \"".$this->id_product."\"";
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
		$record[$this->ddbb_id_product]=$this->id_product;
		$record[$this->ddbb_id_corp] = $this->id_corp;
		$record[$this->ddbb_name]=$this->name;
		$record[$this->ddbb_name_web]=$this->name_web;
		$record[$this->ddbb_pvp]=$this->pvp;
		$record[$this->ddbb_tax] = $this->tax;
		$record[$this->ddbb_pvp_tax]=$this->pvp_tax;
		$record[$this->ddbb_minimun_stock]=$this->minimun_stock;
		$record[$this->ddbb_descrip]=$this->descrip;
		//calculamos la sql de insercin respecto a los atributos
		$this->sql = $this->db->GetUpdateSQL($this->result, $record);
		//insertamos el registro		
		$this->db->Execute($this->sql);
		//si se ha insertado una fila
		$Affected_Rows=$this->db->Affected_Rows();
		
		$return_categories=$this->modify_categories();
		if(($Affected_Rows==1)||($this->sql=="")||$return_categories==1){
			//capturammos el id de la linea insertada
			$this->db->close();
			
			//devolvemos el id de la tabla ya que todo ha ido bien
			return $this->id_product;
		}else {
			//devolvemos 0 ya que no se ha insertado el registro
			$this->error=-1;
			$this->db->close();
			return 0;
		}
	}}
	
	}
	
		function remove($id){
			if (!isset($_POST["submit_delete"])){
			//Si hay que hacer alguna comprobacion antes del borrado
			//se hace aqui
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
		$this->sql="DELETE FROM ".$this->table_prefix.$this->table_name. " WHERE ".$this->ddbb_id_product." = ".$id." LIMIT 1";
		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		//si falla 

		if ($this->db->Affected_Rows() == 0){
			$this->error=1;
			$this->db->close();
			return 0;
		}else{
			//Borramos la foto
			if($this->path_photo != "")
				unlink($this->path_photo);
			//Fin del borrado de la foto
			$this->make_remove($this->id_product);
			$this->error=0;
			$this->db->close();
			return 1;
			
		}
			}
	}
	
	function make_remove($id){
		//modificamos todos aquellos registros en los que hay un id_user;
		for ($i=0;$i<count($this->table_names_modify);$i++){
			$this->modify_all_id_product($id,$this->table_names_modify[$i]);
		}
		//borramos todos aquellos registros en los que hay un id_user;		
		for ($i=0;$i<count($this->table_names_delete);$i++){
			$this->delete_all_id_product($id,$this->table_names_delete[$i]);
		}
	
	}
	
	function modify_all_id_product($id,$table){
			$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexión con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexión de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexión permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.
			$this->sql="UPDATE ".$table. " SET id_product = 0 WHERE id_product = ".$id;
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
	
	function delete_all_id_product($id,$table){
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
			//crea una nueva conexión con una bbdd (mysql)
			$this->db = NewADOConnection($this->db_type);
			//le dice que no salgan los errores de conexión de la ddbb por pantalla
			$this->db->debug=false;
			//realiza una conexión permanente con la bbdd
			$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
			//mete la consulta para coger los campos de la bbdd
			//calcula la consulta de borrado.

			$this->sql="DELETE FROM ".$table. " WHERE id_product = ".$id;
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
	
	function get_fields_from_post(){
		//Cogemos los campos principales
		$prefix="";
		$this->id_corp=$_SESSION['ident_corp'];
		$this->name=htmlentities($_POST[$prefix.$this->ddbb_name]);
		$this->name_web=htmlentities($_POST[$prefix.$this->ddbb_name_web]);
		$this->pvp=$_POST[$prefix.$this->ddbb_pvp];
		$this->tax=$_POST[$prefix.$this->ddbb_tax];
		$this->pvp_tax=$_POST[$prefix.$this->ddbb_pvp_tax];
		$this->minimun_stock=$_POST[$prefix.$this->ddbb_minimun_stock];
		$this->descrip=htmlentities($_POST[$prefix.$this->ddbb_descrip]);
		$this->path_photo = $_SESSION['ruta_photo'];

		$this->get_categories_from_post();
		
		return 0;
	}
	
	function get_categories_from_post(){
		//cogemos todas(true) las categorias que hay en bbdd desde los padres huerfanos(0)
		
		$categorias_bbdd=$this->get_categories(0,true);
		
		//Se inicia $this->num a 0 por que va a servir de indice para 
		//la lista $this->categorias
		$this->num=0;		
		$this->prod_cat_list="";
		//con esta lista cogemos los checkbox que esten señalados en el formulario
		
		$this->get_checkbox_categories($categorias_bbdd,'products');
		
		return 0;
	}
	
	function get_checkbox_categories($cats,$variable){
		//Recorremos el array de categorias q hay en bbdd
		//para coger los checkbox activados en el formulario
		for ($i=0;$i<count($cats);$i++){
			//almacenamos el valor del checkbox
			$checkbox=$_POST[$variable."_".$cats[$i]['id_cat_prod']];
			if ($checkbox==1){
				//Si es = a 1 entonces es que esta seleccionado.
				$this->prod_cat_list[$this->num]['id_cat_prod']=$cats[$i]['id_cat_prod'];
				//incrementamos el valor de num
				$this->num++;				
			}
			//Llamamos a los hijos si es que tienen
			
			if ($cats[$i]['hijos']!=0)
				$this->get_checkbox_categories($cats[$i]['hijos'],$variable."_".$cats[$i]['id_cat_prod']);			
		}		
		return 0;
	}
	
	function show($id, $tpl)
	{
		$this->read($id);
		$tpl->assign('objeto', $this);
		return $tpl;
	}
	
	function view ($id, $tpl){
	$this->read($id);
		$tpl->assign('objeto',$this);
	
			//Se comprueba si hay permiso para borrar o modificar
			$permisos_mod_del = new permissions();
			$permisos_mod_del->get_permissions_modify_delete('products');
			
			$tpl->assign('acciones',$permisos_mod_del->per_mod_del);

	return $tpl;
	}

	function calculate_tpl($method, $tpl)
	{
			$this->method=$method;
				switch($method){
						case 'add':
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
												$this->method="list";
												$tpl=$this->listar($tpl);
												$tpl->assign("message","&nbsp;<br>Producto a&ntilde;adido correctamente<br>&nbsp;");									
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
												$tpl->assign("message","&nbsp;<br>Producto modificado correctamente<br>&nbsp;");
												break;
									}
									//esto se hace independientemetne del valor que se obtenga
									$tpl->assign("objeto",$this);
									break;
									
						case 'delete':
									$this->read($_GET['id']);
									if ($this->remove($_GET['id'])!=0){
										$this->products_list="";
										$this->method="list";
										$tpl=$this->listar($tpl);
										$tpl->assign("message","&nbsp;<br>Producto borrado correctamente<br>&nbsp;");
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
				$tpl->assign('plantilla','products_'.$this->method.'.tpl');		
		return $tpl;
	}



	function bar($method,$corp){
		if ($method!=$this->method){
			$method = $this->method;
		}
		if ($corp != ""){
			$corp='<a href="index.php?module=corps&method=view&id='.$_SESSION['ident_corp'].'">'.$corp.' </a> ::';
		}
		$nav_bar = '<a href="index.php?module=user_corps">Zona privada</a> :: '.$corp.' <a href="index.php?module=products">Productos</a>';
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
		$title = "Zona Privada :: $corp :: Productos";
		$title=$title.$this->localice($method);
		return $title;
	}
	
	function localice($method){
		switch($method){
						case 'add':
									$localice=" :: A&ntilde;adir Producto";
									break;
						case 'list':
									$localice=" :: Buscar Producto";
									break;
						case 'modify':
									$localice=" :: Modificar Producto";
									break;
						case 'delete':
									$localice=" :: Borrar Producto";
									break;
						case 'view':
									$localice=" :: Ver Producto";
									break;
						case 'show':
									$localice=" :: Ver foto del Producto";
									break;
						default:
									$localice=" :: Buscar Producto";
									break;
		}
		return $localice;
	}

	/*function verify_products($id){
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
			$this->prod_cat_list[$this->num]['id_emp']=$this->result->fields['id_emp'];
			$this->prod_cat_list[$this->num]['name']=$this->result->fields['name'];
			$this->prod_cat_list[$this->num]['last_name']=$this->result->fields['last_name'];
			$this->prod_cat_list[$this->num]['last_name2']=$this->result->fields['last_name2'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	}*/

	function table_categories($new){
		//Esta funcion hara el listado de checkbox de las categorias jerarquizadas
		//Buscamos las categorias jerarquizadas comenzando por las categorias padre.
		
		$array_cat=$this->get_categories(0,true);
		

		//Si no es para nuevo: Buscamos las categorias relacionadas con el producto
		if (!$new && (!is_array($this->prod_cat_list)||$this->prod_cat_list=="")){			
			if ($this->id_product!="" && $this->id_product!=0){
				$rel = new rel_prods_cats();
				$this->prod_cat_list=$rel->get_rel_prod_cat($this->id_product);
			}
			else{
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
		for ($i=0;$i<count($array_cat);$i++){
			if ($num_current_col==$NUM_MAX_COLS+1){
				$num_current_col=1;
				$cadena=$cadena.$ini_fila;
			}
			$cadena=$cadena.$ini_col;
			//Damos el padre para que empiece la recursividad			
			
			$cadena=$cadena.$this->build_col($new,$array_cat[$i],0,"products");		
			//0 es el numero de tabulaciones inicial.
			//"products" es el nombre que tendran los checkbox.
			$cadena=$cadena.$fin_col;
			$num_current_col++;
			if ($num_current_col==$NUM_MAX_COLS+1){
				$cadena=$cadena.$fin_fila;
			}
		}
		
		//Si el numero de la columna actual es menor
		//que el numero maximo de columnas +1 
		//restamos al maximo la actual para saber cuantas faltan. 
		if ($num_current_col<$NUM_MAX_COLS+1){			
			$cadena=$cadena.'<td colspan="'.($NUM_MAX_COLS+1-$num_current_col).'">&nbsp;'.$fin_col.$fin_fila;
		}
		$cadena=$cadena.'</table>';
		return $cadena;
	}
	
	function build_col($new,$array_cat,$tabulaciones,$variable){
		//Con esta funcion construimos el contenido de la columna
		//Del listado de checkbox de categorias de producto
		$espacios="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$cadena="";
			
		//Hacemos las tabulaciones
		for ($j=0;$j<$tabulaciones;$j++)
			$cadena=$cadena.$espacios;
		$cadena=$cadena.'<img src="pics/separador.gif">&nbsp;';
		//Ponemos el checkbox. Si se quiere que haya una funcion que maneje por javascript su manejo, se debe incluir aqui
		//Insertamos el nombre
		$cadena=$cadena.$array_cat['name'];
		$cadena=$cadena.'<input type="checkbox" value="1" onClick="check_uncheck(this);" name="'.$variable.'_'.$array_cat['id_cat_prod'].'" id="'.$variable.'_'.$array_cat['id_cat_prod'].'" ';		
		//Si no es nuevo es por que puede que haya alguna categoria que este asignada al producto y hay que marcarla.
		if (!$new){
			for($k=0;$k<count($this->prod_cat_list);$k++){
				if ($array_cat['id_cat_prod']==$this->prod_cat_list[$k]['id_cat_prod']){
					$cadena=$cadena.' checked ';
					break;
				}					
			}					
		}
		//Cerramos el checkbox
		$cadena=$cadena.'>';
		//Llamamos recursivamente
		if ($array_cat['hijos']!=0){
			$tabulaciones_hijo=$tabulaciones+1;
			$variable_hijo=$variable.'_'.$array_cat['id_cat_prod'];
			for ($k=0;$k<count($array_cat['hijos']);$k++){
				$cadena=$cadena."<br>\n";	
				$cadena=$cadena.$this->build_col($new,$array_cat['hijos'][$k],$tabulaciones_hijo,$variable_hijo);
			}
		}		
		return $cadena;
	}
	
	function get_categories($id,$all){//Ojo funcion recursiva.
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
		$this->sql='SELECT * FROM `cat_prods` WHERE `id_parent_cat` = \''.$id.'\' ORDER BY `name`';
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
			$tabla[$this->num]['id_cat_prod']=$this->result->fields['id_cat_prod'];
			$tabla[$this->num]['name']=$this->result->fields['name'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		
		if ($all)
			for ($i=0;$i<count($tabla);$i++){
				$tabla[$i]['hijos']=$this->get_categories($tabla[$i]['id_cat_prod'],true);
			}
		return $tabla;
	}
	
	function get_list_products_corps ($id_corp){
		$this->products_list=array ();
		//se puede acceder a los grupos_usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql="SELECT * FROM ".$this->table_prefix.$this->table_name." WHERE `".$this->ddbb_id_corp."` = ".$id_corp;
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
			$this->products_list[$this->num][$this->ddbb_id_product]=$this->result->fields[$this->ddbb_id_product];
			$this->products_list[$this->num][$this->ddbb_id_corp]=$this->result->fields[$this->ddbb_id_corp];
			$this->products_list[$this->num][$this->ddbb_name]=$this->result->fields[$this->ddbb_name];
			$this->products_list[$this->num][$this->ddbb_name_web]=$this->result->fields[$this->ddbb_name_web];
			$this->products_list[$this->num][$this->ddbb_id_pvp]=$this->result->fields[$this->ddbb_id_pvp];
			$this->products_list[$this->num][$this->ddbb_id_tax]=$this->result->fields[$this->ddbb_id_tax];
			$this->products_list[$this->num][$this->ddbb_id_pvp_tax]=$this->result->fields[$this->ddbb_id_pvp_tax];
			$this->products_list[$this->num][$this->ddbb_path_photo]=$this->result->fields[$this->ddbb_path_photo];
			$this->products_list[$this->num][$this->ddbb_minimun_stock]=$this->result->fields[$this->ddbb_minimun_stock];
			$this->products_list[$this->num][$this->ddbb_descrip]=$this->result->fields[$this->ddbb_descrip];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}
		$this->db->close();
		return $this->num;
	
	}
	
	function verify_products($id){
		//se puede acceder a los usuarios por numero de campo o por nombre de campo
		$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		//crea una nueva conexin con una bbdd (mysql)
		$this->db = NewADOConnection($this->db_type);
		//le dice que no salgan los errores de conexin de la ddbb por pantalla
		$this->db->debug=false;
		//realiza una conexin permanente con la bbdd
		$this->db->Connect($this->db_ip,$this->db_user,$this->db_passwd,$this->db_name);
		//mete la consulta
		$this->sql='SELECT `products`.`name`, `products`.`name_web`, `products`.`id_product` FROM `rel_prods_cats` INNER JOIN `products` ON `rel_prods_cats`.`id_product` = `products`.`id_product` WHERE `rel_prods_cats`.`id_cat_prod` = \''.$id.'\'';
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
			$this->prod_cat_list[$this->num]['id_product']=$this->result->fields['id_product'];
			$this->prod_cat_list[$this->num]['name']=$this->result->fields['name'];
			$this->prod_cat_list[$this->num]['name_web']=$this->result->fields['name_web'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
		}

		$this->db->close();
		return $this->num;
	}
	
}
?>