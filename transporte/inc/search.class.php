<?php
//clase que da soporte a las empresas del programa
//enlaza con la bbdd 
global $ADODB_DIR, $INSTALL_DIR;
require_once ($INSTALL_DIR.'inc/config.inc.php');
require_once ($INSTALL_DIR.'inc/table.class.php');
require_once ($ADODB_DIR."adodb.inc.php");

class search{
//internal vars
var $query = "";
	//BBDD name vars
	//constructor
	function search(){
		//coge las variables globales del fichero config.inc.php
				return $this;	 
		
	}
	
	function get_query ($search_query, $query_type, $search, $fields)
	{		
		//Se compruea el tipo de query (si tiene comillas TRUE o se hace split FALSE)
		if(!$query_type)		
		{
			//Se hace split
			$diferent_queries = split(" ",$search_query);
		}
		else
			$diferent_queries = $search_query;
			
		//Comprobar campos compatibles 
		for($j=0;$j<count($diferent_queries);$j++)
		{
			for($i=0;$i<count($search);$i++)
			{
				//print "Iteración ".$i." de posible campo".$search[$i]."   ";
				//Buscar campo en fields que coincida en nombre y comprobar tipo
				$tipo = $fields->lista[$search[$i]]["type"];
		
				switch($tipo)
				{
					case "int":
								print "Int";
								/*********************En pruebas****************/
								
								$this->comprobar_int($search[$i], $diferent_queries[$j]);
								
								/***********************************************/	
								break;
					case "text":
								print "text";
								break;
					case "double":
								print "double";
								break;
					case "decimal":
								print "decimal";
								break;
					case "varchar":
							//	print "varchar";
								/*********************En pruebas****************/
								
								$this->comprobar_varchar($search[$i], $diferent_queries[$j]);
								
								/***********************************************/
								break;
					case "char":
								print "char";
								break;
					case "string":
								print "string";
								break;
					case "real":
								print "real";
								break;
					case "date":
								print "date";
								break;
					case "tinyint":
								print "tinyint";
								break;
					default:
								break;
				}
				
				
			if(($j!=count($diferent_queries)-1)||($i!=count($search)-1))
				$this->query .="OR";	
			}
		}
		
		//Se devuelve el WHERE construído
		return $this->query;
	}
	
	
	function comprobar_varchar($search, $search_query)	
	{
		//Se asigna el tipo de la variable en fields a $search_query
		settype($search_query, 'string');
		if(is_string($search_query))
			//Se añade a la consulta
			$this->query .=" `".$search."` LIKE  \"%".$search_query."%\"";	
	}  
	
	function comprobar_int($search, $search_query)	
	{
		//Se asigna el tipo de la variable en fields a $search_query
		if(is_numeric($search_query))
		{
			settype($search_query, 'int');
			if(is_int($search_query))
				//Se añade a la consulta
				$this->query .=" `".$search."` = ".$search_query."";	
		}
	}
}
?>