<?php
//clase que da soporte a los productos del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");
class menu{
	var $module;
	//BBDD name vars
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;

  	
	function table_modules($id_padre){
		//Esta funcion hara el listado de los modulos jerarquizados
		//Buscamos lo modulos jerarquizadas comenzando por los modulos padre.	
		$array_mod=$this->get_modules($id_padre,true);
	
		//Construimos la tabla con los arrays
		if (count($array_mod)!=0)
			$table=$this->build_table($id_padre, $array_mod);
		else
			$table='<p class="mensaje">No hay modulos</p>';
			
		//$table es una cadena
		return $table;
	}
	
	function build_table($id_padre,$array_mod){
		//Con esta funcion hacemos la tabla de modulos
		//Hacemos las iniciaciones pertinentes para intentar
		//aclarar un poco el codigo
		$ini_fila='<tr class="textoMenu">';
		$ini_fila_max='<tr class="tituloMenu">';
		$fin_fila="</tr>\n";
		$ini_col='<td valign="top">';
		$fin_col="</td>";
		$NUM_MAX_COLS=1;
		//Por cada columna un padre y sus hijos.
		$cadena='<table border="0">';
		$num_current_col=$NUM_MAX_COLS+1;		
		for ($i=0;$i<count($array_mod);$i++)
		{
			if ($num_current_col==$NUM_MAX_COLS+1)
			{
				$num_current_col=1;
				if($id_padre == -2)
					$cadena=$cadena.$ini_fila_max;
				else
					$cadena=$cadena.$ini_fila;
			}
			$cadena=$cadena.$ini_col;
			//Damos el padre para que empiece la recursividad			
			$cadena=$cadena.$this->build_col($array_mod[$i],0);		
			//0 es el numero de tabulaciones inicial.
			$cadena=$cadena.$fin_col;
			$num_current_col++;
			if ($num_current_col==$NUM_MAX_COLS+1)
			{
				$cadena=$cadena.$fin_fila;
			}
			
		}//for
		
		//Si el numero de la columna actual es menor
		//que el numero maximo de columnas +1 
		//restamos al maximo la actual para saber cuantas faltan. 
		if ($num_current_col<$NUM_MAX_COLS+1){			
			$cadena=$cadena.'<td colspan="'.($NUM_MAX_COLS+1-$num_current_col).'">&nbsp;'.$fin_col.$fin_fila;
		}
		$cadena=$cadena.'</table>';
	
		return $cadena;
	}
	
	function build_col($array_mod,$tabulaciones)
	{
		//Con esta funcion construimos el contenido de la columna
		$espacios="&nbsp;&nbsp;&nbsp;";
		$cadena="";
			
		//Hacemos las tabulaciones
		for ($j=0;$j<$tabulaciones;$j++)
			$cadena=$cadena.$espacios;
	    
		if(($array_mod['parent'] == -2)&&(count($array_mod['hijos']) > 0)&&($array_mod['hijos']!= ""))
		{
			$cadena=$cadena.'<img src="pics/separador.gif">&nbsp;';
			$cadena=$cadena.'<b>'.$array_mod['name_web'].'</b>';
		}
		else if($array_mod['parent'] != -2)
		{
			$cadena=$cadena.'<img src="pics/separador.gif">&nbsp;<a href="'.$array_mod['path'].'" class="enlaceMenu">';
			//Insertamos el nombre
			$cadena=$cadena.$array_mod['name_web'].'</a>';	
		}
		
		
		//Llamamos recursivamente
		if ($array_mod['hijos']!=0){
			$tabulaciones_hijo=$tabulaciones+1;
			for ($k=0;$k<count($array_mod['hijos']);$k++)
			{
				$cadena=$cadena."<br>\n";	
				$cadena=$cadena.$this->build_col($array_mod['hijos'][$k],$tabulaciones_hijo);
			}
		}		
		return $cadena;
	}
	
	function get_modules($id,$all)
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
		$uno = 1;
		$this->sql='SELECT * FROM `modules` WHERE `parent` = \''.$id.'\' AND `active` = '.$uno.' ORDER BY `order`';

		//la ejecuta y guarda los resultados
		$this->result = $this->db->Execute($this->sql);
		if ($this->result === false)
		{
			$this->error=1;
			$this->db->close();

			return 0;
		}
		
		if(($id == 0)||($id == -2)||($_SESSION['super'])||(($_SESSION['admin'])&&($this->result->fields['name'] != 'modules')))
		{
			$this->num=0;
			while (!$this->result->EOF) 
			{
			//cogemos los datos 
			$tabla[$this->num]['id_module']=$this->result->fields['id_module'];
			$tabla[$this->num]['name']=$this->result->fields['name'];
			$tabla[$this->num]['name_web']=$this->result->fields['name_web'];
			$tabla[$this->num]['path']=$this->result->fields['path'];
			$tabla[$this->num]['parent']=$this->result->fields['parent'];
			//nos movemos hasta el siguiente registro de resultado de la consulta
			$this->result->MoveNext();
			$this->num++;
			}
		}
		else
		{	
			$this->num=0;
			while (!$this->result->EOF) 
			{
				//cogemos los datos 
				$temp[$this->num]['id_module']=$this->result->fields['id_module'];
				$temp[$this->num]['name']=$this->result->fields['name'];
				$temp[$this->num]['name_web']=$this->result->fields['name_web'];
				$temp[$this->num]['path']=$this->result->fields['path'];
				$temp[$this->num]['parent']=$this->result->fields['parent'];
				//nos movemos hasta el siguiente registro de resultado de la consulta
				$this->result->MoveNext();
				$this->num++;
			}
			$i=0;
			$j=0;

			$user= new users(); 
			$id_user = $_SESSION['ident_user'];
			$permission = new permissions_modules();
		
			while ($i!=$this->num) 
			{
				if($permission->validate_per_module_menus($id_user,$temp[$i]['id_module']) == 1)
				{
					$tabla[$j]['id_module'] = $temp[$i]['id_module'];
					$tabla[$j]['name'] = $temp[$i]['name'];
					$tabla[$j]['name_web'] = $temp[$i]['name_web'];
					$tabla[$j]['path'] = $temp[$i]['path'];
					$tabla[$j]['parent'] = $temp[$i]['parent'];
					$j++;
				}//if
				$i++;
			}
		}//else
		$this->db->close();
		
		if ($all)
			for ($i=0;$i<count($tabla);$i++)
			{
				$tabla[$i]['hijos']=$this->get_modules($tabla[$i]['id_module'],true);
			}
		return $tabla;
	}
	
}
?>