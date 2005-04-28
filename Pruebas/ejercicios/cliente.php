<?php

class clientes
{
	var $id_cliente;
	var $name_cliente;
	var $tipo_cliente;
	
	var $db_name;
	var $db_ip;
	var $db_user;
	var $db_passwd;
	var $db_port;
	var $db_type;
	var $table_prefix;
	var $table_name;
	var $ddbb_id;
	var $ddbb_name;
	var $ddbb_tipo;
	var $enlace;
	var $resultado;
	var $sql;
	var $linea;
	var $campos;
	var $tablacompleta;
	var $modificar;
	
	function clientes()
	{
		require_once('/var/www/proyectos/transporte/inc/adodb/adodb.inc.php');
		$this->db_name="pruebas";
		$this->db_ip="localhost";
		$this->db_user="root";
		$this->db_passwd="sta3war2";
		$this->db_port="3306";
		$this->db_type="mysql";
		$this->$table_name='clientes';
		$this->ddbb_id='id_cliente';
		$this->ddbb_name='name_cliente';
		$this->ddbb_tipo='tipo_cliente';
		$this->enlace = mysql_connect($this->db_ip,$this->db_user,$this->db_passwd) or die("No pudo conectarse : " . mysql_error());
		mysql_select_db("pruebas") or die("No pudo seleccionarse la BD.");
		$this->campos[0]=$this->ddbb_id;
		$this->campos[1]=$this->ddbb_name;
		$this->campos[2]=$this->ddbb_tipo;	
		return 1;
		
	}
	function asignadatos($id,$nombre,$tipo)
	{
			$this->id_cliente=$id;
			$this->name_cliente=$nombre;
			$this->tipo_cliente=$tipo;
			return 1;
	}

	function coger_cliente()
	{
		$this->sql='SELECT * FROM clientes WHERE `id_cliente` = "'.$this->id_cliente.'"';
		$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
		return 1;
	}
	function coger_lista()
	{
		$this->sql='SELECT * FROM clientes';
		$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
		return 1;
	}
	function aniadir()
	{
		echo "Cliente a&ntilde;adido";
		$this->sql="INSERT INTO `clientes` ( `id_cliente` , `name_cliente` , `tipo_cliente` ) 
				VALUES ('".$this->id_cliente."', '".$this->name_cliente."', '".$this->tipo_cliente."')";
		$this->resultado= mysql_query ($this->sql) or die ("Invalid query");
		return 1;
	}
	function borrar_cliente($id)
		{
	
			$this->sql="DELETE FROM `clientes` WHERE `id_cliente` = '".$id."' LIMIT 1";
			$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
			if(1==mysql_affected_rows()){
				echo "<br>cliente borrado<br>";
			}else{
				echo "<br>cliente borrado<br>";		
			}
			return 1;
	}
	
	
	function display_list_smarty()
	{
		$i=0;
		require_once('/var/www/proyectos/transporte/inc/smarty/Smarty.class.php') ; 
		$tpl = new Smarty;
		$tpl->template_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates/' ; 
		$tpl->compile_dir =  '/var/www/proyectos/Pruebas/ejercicios/templates_c/' ;
		$tpl->config_dir =  '/var/www/proyectos/Pruebas/ejercicios/configs/' ;
		$tpl->cache_dir =  '/var/www/proyectos/Pruebas/ejercicios/cache/' ;   
				while ($this->linea = mysql_fetch_array($this->resultado, MYSQL_ASSOC)) 
			{
								$this->tablacompleta[$i++]=$this->linea;
			
			}
			$tpl->assign("nombrecampos",$this->campos);
			$tpl->assign("id",0);
			$tpl->assign("valores",$this->tablacompleta);
			if ($this->modificar==true)
				$tpl->display('modificando.tpl');
			else
				$tpl->display('verconsmarty.tpl');
		return 1;
	}
	
	function modificar_cliente()
	{	
			
		$this->sql="UPDATE `clientes` SET `tipo_cliente` = '".$this->tipo_cliente."' WHERE `id_cliente` = '".$this->id_cliente."' LIMIT 1" ;
		$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
		$this->sql="UPDATE `clientes` SET `name_cliente` = '".$this->name_cliente."' WHERE `id_cliente` = '".$this->id_cliente."' LIMIT 1" ;
		$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
			
	}
	
	function destroy()
	{
			mysql_close ($this->enlace);
		return 1;
	}
	
}
?>