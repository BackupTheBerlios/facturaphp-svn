<?php
	/*
	
	DOCUMENTACION DE LA CLASE table
	Nombre y uso de las variables de la clase "table"
	
	$class_cabecera ====>		nombre de la clase que sera el formato de la cabecera de la tabla.
	$class_tr1 ====>		nombre de la clase que sera el formato de una fila de la tabla
	$class_tr2 ====>		nombre de la clase que sera el formato de una fila de la tabla
	$default_num_rows ===> 		numero de filas por defecto en el caso de que no nos manden un numero de filas concreto	
	$comiezo_variable ===>		como empezara la variable de javascript
	$final_variable ===>		como finalizara la variable de javascript	
	$listado ===>			nos dira si es un listado o una vista (boolean [true = listado] [false = vista])
	$comienzo_tabla ===>		como empezara la tabla
	$final_tabla ===>		como finalizara la tabla
	$select_registros_pagina ===>	array que contendra las opciones de la cantidad de registros que se veran en el modelo vista
	$nombres_variables ===>		esta variable se pasará mas tarde a Smarty para que cree la funcion Ocultar() de javascript en la que estaran las variables creadas en este array.
	$parameter_add ===>			Estara iniciada a "", en caso de que halla algun parametro para añadir deberia ir con esta sintaxis: ej: $tabla->parameter_add="&id_emp=2";
	
	FUNCIONES ****************************************************************************
	
	************************************************
	CONSTRUCTOR: function table($list)
		Aqui creamos el comienzo y final de la variable dependiendo de si es un listado o no.
		
	VARIABLES DE table
		$list ===>		esta se asignara a $this->listado y nos dice si es un listado o no
			
	
	************************************************
	FUNCION CREADOR DE TABLA: function make_tables($var_js,$list_name,$cabecera,$nombre_campos,$num_rows,$acc,$new){
		Crea la tabla en funcion de los parametros que le pasamos.
		
	VARIABLES DE make_tables
		$var_js ===>		es el nombre de el conjunto de variables de una pestaña en concreto. Sera el nombre de la clase/tabla/modulo al que estamos accediendo;
		$list_name ===>		es el listdo que se nos pasa con la informacion, sera un array bidimesional con este formato: array[num][nombre] donde "num" sera un entero, y "nombre" el nombre del campo (como por ejemplo el "users_list" del la clase users.class.php). Siempre el primer dato sera el id (pero no se mostrara en la tabla si no que sera utilizado para las acciones.)
		$cabecera ===>		es el nombre que aparecera en las cabeceras, su formato sera $cabecera(nombre_columna1, ancho_columna1, nombre_columna2, ancho_columna2...) Si se van a incluir acciones (ver, editar y/o borrar), entonces el ancho total no debe ser = o superior al 100% de la tabla
		$nombre_campos ==>	son los nombres de los campos que se utilizaran como segundo parametro en el array list_name (el primero sera al igual que en list_name, el id)	
		$num_rows ===>		Numero de registros que habrá por pagina, si no se especifica se tomara el valor $this->default_num_rows
		$acc ===>		Nombre de las acciones que se podran realizar los valores posibles son "modify" "view" y "delete"
		$new ===>		Nos indica si podremos poner el boton "nuevo" en el listado o vista
		
	
	************************************************
	FUNCION DE PAGINACIÓN: function tabla_paginacion($var,$curr_page,$num_pages)
		Crea la tabla con la que podremos navegar por las distintas variables de javascript.
	
	VARIABLES DE tabla_paginacion
		$var ===>		Nombre de la variable javascript.
		$curr_page ===>		Pagina en la que nos encontramos actualmente
		$num_pages ===>		Numero de paginas totales de la que constara el listado o vista.
		
		
	************************************************************************************************
	************************************************************************************************
	************************************************************************************************
	
	COSAS A ENTER ENCUENTA:
		- "tabla_paginacion" se llama dentro de "make_tables"
		- cuando se haya ejecutado "make_tables", $this->nombres_variables ya contendra los nombres de las variables para pasarselas a smarty.
		- En el modelo de vista, la ejecucion de la búsqueda
	
	*/ 
	
	class table{
	
		var $class_cabecera='cabeceraMultilinea';
		var $class_tr1='multiLinea1';
		var $class_tr2='multiLinea2';	
		var $default_num_rows=10;	
		var $comiezo_variable;
		var $final_variable='';				
		var $listado;
		var $comienzo_tabla='<table align=\\"center\\" width=\\"80%\\">';
		var $final_tabla='</table>';
		var $select_registros_pagina= array(0=>'Todos',10,20,30,40,50);
		var $nombres_variables;// aqui se iran poniendo los nombres de las variables para despues pasarselas a smarty y hacer la funcion javscript Ocultar()
		var $parameter_add="";
		
		function table($list){
			$this->listado = $list;
			if (!$this->listado) {
				$this->final_variable='</td></tr></table>';
			}
			$this->final_variable=$this->final_variable.'";'."\r\n\t";
			return 1;
		}
		
		function make_tables($var_js,$list_name,$cabecera,$nombre_campos,$num_rows,$acc,$new){

			$cadena ='<script>'."\n\r\t";									
			$curr_pag=1;
			$registro=0;
			$num_cols=((count($cabecera)/2) + count($acc));	
			
			// 	 miramos el numero de filas que va a haber por página.
			if ($num_rows=='Todos') {
			    $num_pags=1;
				$num_regs=count($list_name);
			}
			elseif($num_rows==''){//por defecto.
				$num_rows=$this->default_num_rows;
				$num_regs=$this->default_num_rows;
				$num_pags=ceil(count($list_name)/$num_rows);
				
			}	
			else{
				$num_pags=ceil(count($list_name)/$num_rows);
				$num_regs=$num_rows;
			}
				
			// escribimos los nomebres de las variables para la funcion (Ocultar())	
			for($i=0;$i<=$num_pags -1;$i++){
				$this->nombres_variables[$i]=$var_js.'_'.($i + 1);
			}
			//Vamos rellenando página por página.
			while($curr_pag<=$num_pags){
				$variable='var '.$var_js.'_'.$curr_pag.'="';
				$curr_reg=1;
				$clase=1;
				
				
				// ENCABEZADOS
				//si es un listado no aparecera el desplegable ni la búsqueda.
				if ($this->listado && $new) {				
					     $variable=$variable.'<table align=\\"center\\"><tr><td><a href=\\"index.php?module='.$var_js.'&method=add\\"><img border=\\"0\\"src=\\"pics/btnnew.gif\\"></a></td></tr><table>';				
				 }
				elseif(!$this->listado){				
					$variable=$variable.'<table width=\\"80%\\" align=\\"center\\"><tr><td width=\\"20%\\">';
					//si puede o no ejecutar nuevo
					if (!$new) {
					    $variable=$variable.'&nbsp;</td>';
					}
					else{
						$variable=$variable.'<a href=\\"index.php?module='.$var_js.'&method=add'.$this->parameter_add.'\\"><img border=\\"0\\"src=\\"pics/btnnew.gif\\"></a></td>';
					}
					
					
					/*
					//NUMERO DE REGISTROS POR PÁGINA
					$variable=$variable.'<td width=\\"40%\\" align=\\"center\\"><span class=\\"cabeceraCampoFormulario\\">Registros por p&aacute;gina:</span> <select class=\\"textoMenu\\">';					
					for($i=0;$i<count($this->select_registros_pagina);$i++){
						if ($this->select_registros_pagina[$i]==$num_rows){
							$variable=$variable.'<option value=\\"'.$this->select_registros_pagina[$i].'\\" id=\\"'.$this->select_registros_pagina[$i].'\\" selected>'.$this->select_registros_pagina[$i].'</option>';
						}
						else{
							$variable=$variable.'<option value=\\"'.$this->select_registros_pagina[$i].'\\" id=\\"'.$this->select_registros_pagina[$i].'\\">'.$this->select_registros_pagina[$i].'</option>';
						}
					}
					
					*/
					$variable=$variable.'</select></td>';
					
					// BUSQUEDA
					$variable=$variable.'<td width=\\"40%\\" align=\\"right\\"><form method=\\"post\\" action=\\"index.php?module='.$var_js.'&method=list\\"><img src=\\"pics/buscar.gif\\"><input class=\\"textoMenu\\ type=\\"text\\" name=\\"search\\" id=\\"search\\"> <input type=\\"submit\\" class=\\"botones\\" value=\\"Buscar\\" name=\\"submit_'.$var_js.'_search\\"></form></td>';
					
					// FIN
					$variable=$variable.'</tr></table>';
				}				
				
				
				
				//CREAMOS CABECERA
				$i=0;
				$variable=$variable.$this->comienzo_tabla.'<tr><td colspan=\\"'.$num_cols.'\\" class=\\"cabeceraCampoFormulario\\">Listado</td></tr>'.'<tr class=\\"'.$this->class_cabecera.'\\">';
				while($i<=count($cabecera)- 1){			
					$variable=$variable.'<td align=\\"center\\" WIDTH=\\"'.$cabecera[$i + 1].'%\\">'.$cabecera[$i].'</td>';	
					$i=$i+2;
				}
				if (count($acc)!=0) {
				    $variable=$variable.'<td align=\\"center\\" colspan=\\"'.count($acc).'\\">Acciones</td>';
				}
				$variable=$variable.'</tr>';
				
				
				//CONTENIDO
				//creamos filas con contenido.
				while(($curr_reg<=$num_regs) && !($registro==count($list_name))){
					if ($clase==1) {//aplicamos el estilo
	  					$variable=$variable.'<tr class =\\"'.$this->class_tr1.'\\">';   
						$clase=0;
					 }
					else{
						$variable=$variable.'<tr class =\\"'.$this->class_tr2.'\\">';   
						$clase=1;
					}
					// CUERPO DE TABLA
					$col=0;
					$view=false;					
					$micol=0;
					while($micol<=count($acc)-1){
						if($acc[$micol]== 'view'){
							$view=true;
						}
						$micol++;
					}
					while($col<=(count($cabecera)/2)-1){
						$variable=$variable.'<td align=\\"center\\">';	
						if($nombre_campos[$col+1] != 'path_photo')	
						{			
							if($view){
								$variable=$variable.'<A href=\\"index.php?module='.$var_js.'&method=view&id='.$list_name[$registro][$nombre_campos[0]].'\\">';
							}						
							$variable=$variable.$list_name[$registro][$nombre_campos[$col+1]];
							if($view){
								$variable=$variable.'</A>';
							}
						}
						else
						{
							$variable = $variable.'<a href=\\"index.php?module='.$var_js.'&method=show&id='.$list_name[$registro][$nombre_campos[0]].'\\"><img src=\\"'.$list_name[$registro][$nombre_campos[$col+1]].'\\" align=middle width=\\"80\\" height=\\"80\\"></a>';
							//print "******************Tabla hasta ahora: ".$variable."******************************";
						}						
						$variable=$variable.'</td>';
						$col++;
					} // while
					$col=0;
					while($col<=count($acc)-1){
						$variable=$variable.'<td align=\\"center\\"><A href=\\"index.php?module='.$var_js.'&method='.$acc[$col].'&id='.$list_name[$registro][$nombre_campos[0]].'\\"><img src=\\"pics/btn'.$acc[$col].'.gif\\" border=\\"0\\"></A></td>';
						$col++;
					} // while
					// aqui pondremos las acciones;					
					$variable=$variable.'</tr>';
					$registro++;
					$curr_reg++;	
				} // while							
				$variable=$variable.'<tr class=\\"'.$this->class_cabecera.'\\"><td colspan=\\"'.$num_cols.'\\">&nbsp;</td></tr>'.$this->final_tabla.$this->tabla_paginacion($var_js,$curr_pag,$num_pags).$this->final_variable;
				$cadena=$cadena.$variable;
				$curr_pag++;
			} // while			
			$cadena=$cadena."\n\r".'</script>';	
			// devolvemos el resultado.
			return $cadena;				
		}
		
		function tabla_vacia($var_js,$add){
			$cadena='<script>'."\n\r";
			$cadena=$cadena.$var_js.'_1="<table align=\\"center\\">';
			if ($add){
				$cadena=$cadena.'<tr align=\\"center\\"><td><a href=\\"index.php?module='.$var_js.'&method=add'.$this->parameter_add.'\\"><img border=\\"0\\"src=\\"pics/btnnew.gif\\"></a></td></tr>';
			}
			$cadena=$cadena.'<tr align=\\"center\\"><td><h3>No hay registros</h3></td></tr></table>";';
			$cadena=$cadena."\n\r".'</script>';
			$this->nombres_variables=array(0=>$var_js.'_1');
			return $cadena;
		}
		
		
		function dont_show($var_js){
			$cadena='<script>'."\n\r";
			$cadena=$cadena.$var_js.'_1="<br><table align=\\"center\\"><tr align=\\"center\\"><td><h3>No se pueden mostrar los datos</h3></td></tr></table><br>";';
			$cadena=$cadena."\n\r".'</script>';
			$this->nombres_variables=array(0=>$var_js.'_1');
			return $cadena;
		}
		
		/*
		EL DISEÑO DE ESTA FUNCION OBLIGA A QUE LA VARIABLE DE JAVASCRIPT QUE VAYA A ALBERGAR SU CONTENIDO
		DEBA TENER LA CADENA DE CARACTERES ENTRE COMILLAS DOBLES
		*/
		function tabla_paginacion($var,$curr_page,$num_pages){
				$num = 1;
				$pagina='<br><table align=\\"center\\"><tr><td class=\\"cabeceraCampoFormulario\\" colspan=\\"3\\">Ir a la página:</td></tr><tr class=\\"NumerosBuscar\\">';
				if($num==$num_pages)//SI SOLO HAY UN REGISTRO
					$pagina = $pagina.'<td>&nbsp</td><td><b>1</b></td><td>&nbsp</td>';					
				else{
						if ($curr_page==1)//SI ES EL PRIMERO
							$pagina=$pagina.'<td>&nbsp</td><td>';							
						else
							$pagina=$pagina.'<td><a href=\\"#listado\\" onClick=\\"Ocultar(\'\',\''.$var.'_'. ($curr_page - 1) .'\')\\">Anterior</a></td><td>';
							
						while ($num <= $num_pages){//VAMOS RECORRIENDO LAS PAGINAS
							if($num==$curr_page)
								$pagina=$pagina.'<b>'.$num.'</b>&nbsp;';
							else
								$pagina=$pagina.'<a href=\\"#listado\\" onClick=\\"Ocultar(\'\',\''.$var.'_'.$num.'\')\\" >'.$num.'</a>&nbsp;';
							$num++;
						}									
						if($curr_page==$num_pages)//SI ES EL ULTIMO
							$pagina=$pagina.'</td><td>&nbsp</td>';							
						else
							$pagina=$pagina.'</td><td><a href=\\"#listado\\" onClick=\\"Ocultar(\'\',\''.$var.'_'. ($curr_page + 1) .'\')\\" >Siguiente</a></td>';
				}
				$pagina=$pagina.'</tr></table>';
				return $pagina;
			}
			
		function test(){		
		
			$mi_tabla = array(0=>array('id_module'=>1,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>2,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>3,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>4,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>5,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>6,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>7,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>8,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>9,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>10,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>11,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>12,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>13,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>14,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>15,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>16,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>17,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>18,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>19,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>20,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>21,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>22,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'),array('id_module'=>23,'pepe'=>'jose','antonio'=>'tonito','juanito'=>'juan'));
			$micadena=$this->make_tables('modulos',$mi_tabla ,array('nombre1',25,'nombre2',25,'nombre3',25) ,array('id_module','pepe','antonio','juanito') ,10 , array('View','modify','delete'), true);
			echo $micadena;
			return;
		}
	
	}
	
	
	


?>