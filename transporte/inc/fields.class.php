<?php
global $INSTALL_DIR, $SMARTY_DIR;
require_once($SMARTY_DIR.'Smarty.class.php');
class fields{
	var $lista;
	var $num;
	var $array_error;
	function fields(){
		
		$this->num=0;
		$this->array_error=array();
	}
	
	function get_ddbb_fields(){
	
		
	
	}
	
	function add($name, $value, $type, $size, $valid,$null=0){
	
		$this->lista[$name] = array("value" => $value, "type" => $type, "size" => $size, "valid" => $valid, "null" => $null);
		$this->num++;
		
	}
	
	function remove(){
	
		
	}
	
	function free(){
	
		
	}
	
	function modify_value($name,$new_value){
		$this->lista[$name]["value"]=$new_value;
	}
	
	function validate(){
		$name_keys=array_keys($this->lista);
		$array_error=array();
		$error=true;
		for ($i=0;$i<$this->num;$i++){	
			switch ($this->lista[$name_keys[$i]]["type"]){					
				case "int": $return=$this->validate_int($this->lista[$name_keys[$i]]["value"],$this->lista[$name_keys[$i]]["null"]);
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				case "text": $return=$this->validate_text($this->lista[$name_keys[$i]]["value"],$this->lista[$name_keys[$i]]["null"]);
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				case "double": $return=$this->validate_double($this->lista[$name_keys[$i]]["value"],$this->lista[$name_keys[$i]]["null"]);
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				case "decimal": $return=$this->validate_double($this->lista[$name_keys[$i]]["value"],$this->lista[$name_keys[$i]]["null"]);
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				case "varchar": $return=$this->validate_varchar($this->lista[$name_keys[$i]]["value"],$this->lista[$name_keys[$i]]["size"],$this->lista[$name_keys[$i]]["null"]);								
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				case "char": $return=$this->validate_char($this->lista[$name_keys[$i]]["value"]);
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				case "string": $return=$this->validate_string($this->lista[$name_keys[$i]]["value"]);
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				case "real": $return=$this->validate_real($this->lista[$name_keys[$i]]["value"]);
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				case "date": $return=$this->validate_date($this->lista[$name_keys[$i]]["value"],$this->lista[$name_keys[$i]]["null"]);
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				case "tinyint":$return=$this->validate_int($this->lista[$name_keys[$i]]["value"],$this->lista[$name_keys[$i]]["null"]);
							if(!is_int($return)){
								array_push($this->array_error,$name_keys[$i],$return);
								$error=false;
							}							
							break;
				default: break;
			}		
			if($this->lista[$name_keys[$i]]["value"]==""){
				//echo $this->lista[$name_keys[$i]]["type"]." ".$name_keys[$i]."<br>";
				$this->lista[$name_keys[$i]]["value"]=null;
			}
		}
		
		return $error;
	}
	
	function validate_int($value,$null){
		if($null==1 && ($value=="" || $value==null)&& $value!=0){
			return "* Este campo no puede estar vacio.";
		}

		if(is_numeric($value))
			settype($value,"integer");
		if (!is_integer($value) && $value != "")
			return "* El valor introducido no es un entero.";
		return 0;
	}
	
	function validate_text($value,$null){
		if($null==1 && ($value=="" || $value==null)){
			return "* Este campo no puede estar vacio.";
		}
		if (!is_string($value)&& $value != "")
			return "* El texto introducido no es valido.";
		return 0;
	}
	
	function validate_double($value,$null){
		if($null==1 && ($value=="" || $value==null)){
			return "* Este campo no puede estar vacio.";
		}
		if (is_numeric($value)){
			settype($value,"double");
		}
		if (!is_double($value) && $value != ""){
			return "* El valor introducido no es un entero o decimal (Separacio&oacute;n de decimal con '.').";
			}
		return 0;
	}
	
	function validate_decimal($value,$null){
		if($null==1 && ($value=="" || $value==null)){
			return "* Este campo no puede estar vacio.";
		}
		if (is_numeric($value)){
			settype($value,"double");
		}
		if (!is_double($value) && $value != ""){
			return "* El valor introducido no es un entero o decimal (Separacio&oacute;n de decimal con '.').";
			}
		return 0;
	}
	
	function validate_varchar($value,$size,$null){
		if($null==1 && ($value=="" || $value==null)){
			return "* Este campo no puede estar vacio.";
		}
		if (strlen(html_entity_decode($value))>$size)
			return "* El texto introducido no debe ser mayor a $size caract&eacute;res";
			
		if (!is_string($value)&& $value != "")
			return "* El texto introducido no es valido.";
		return 0;
	}
	
	function validate_char($value){
		return 0;
	}
	
	function validate_string($value,$size,$null){			
		return validate_varchar($value,$size,$null);
	}
	
	function validate_real($value){
		return 0;
	}
	
	function validate_date($value,$null){
		if($null==1 && ($value=="" || $value==null)){
			return "* Este campo no puede estar vacio.";
		}
		$format="Formato de fecha: dd-mm-aaaa";
		if ($value){			
			$resultado = $value;
			if ((substr($value,2,1) == '-') && (substr($value,5,1) == '-')){      
				for ($i=0; $i<10; $i++){	
					if (((substr($value,$i,1)<'0') || (substr($value,$i,1)>'9')) && ($i != 2) && ($i != 5)){
						$resultado = '';
						break;  
					}  
				}				
				if ($resultado){ 
					$a = substr($value,6,4);
					$m = substr($value,3,2);
					$d = substr($value,0,2);
					if((($a < 1900) && ($a!=0)) || ($a > 2100) || ($m < 0) || ($m > 12) || ($d < 0) || ($d > 31)){
						$resultado = '';}
				 
					else{
						if(($a%4 != 0) && ($m == 2) && ($d > 28)){	   
							$format="El a�o $a no es bisiesto y ha introducido $d-02";
							$resultado = ''; // A�o no bisiesto y es febrero y el dia es mayor a 28
						}
						else{
							if (((($m == 4) || ($m == 6) || ($m == 9) || ($m==11)) && ($d>30)) || (($m==2) && ($d>29))){
								$format="El mes $m no tiene $d d&iacute;as";
								$resultado = '';	      				  	 
							}
						}  // else
					} // fin else
				}//fin if($resultado)
			} // if ((substr($value,2,1) == '') && (substr($value,5,1) == ''))			    			
			else
				{
				$resultado = '';
				}
			if ($resultado == '')
				return "* $format";
		}
		return 0;
	}
	
	function change_date($date,$format){
		//La �nica validaci�n de datos que se hace aqu� es que 
		//la fecha ya este en el formato especificado
		switch ($format){
			case "es":
						if (strpos($date,"-")!=2){
							$anno=substr($date,0,4);
							$mes=substr($date,5,2);
							$dia=substr($date,8,2);
							return "$dia-$mes-$anno";
						}
						else{
							return $date;
						}
			case "en":
						if (strpos($date,"-")!=4){
							$anno = substr($date,6,4);
							$mes = substr($date,3,2);
							$dia = substr($date,0,2);
							return "$anno-$mes-$dia";
						}
						else{
							return $date;
						}
			default:
				return 0;
		}
	}
	
	function compare_passwd($original,$retyped){
		if(strcmp(html_entity_decode($original),html_entity_decode($retyped))!=0){
			array_push($this->array_error,"retype","Error *: Las contrase�as no coinciden");
			return false;
		}
		else
			return true;			
	}
	
	function validate_login($login,$array,$name=""){
		//name es el nombre que tenia al principio, por si se viene de un "modify"
		
		if ($name!="" && html_entity_decode($name)==html_entity_decode($login))
			return true;
		if (is_array($array))
			for($i=0;$i<count($array);$i++){
				if (html_entity_decode($login) == html_entity_decode($array[$i])){
					array_push($this->array_error,"login","Error *: El nombre de usuario ya existe");
					return false;
				}
			}
		return true;
	}
	
}
?>