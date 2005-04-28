<?php

class cliente
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
	
	function cliente()
	{
		require_once('/var/www/proyectos/transporte/inc/adodb/adodb.inc.php');
		$this->db_name="pruebas";
		$this->db_ip="localhost";
		$this->db_user="root";
		$this->db_passwd="sta3war2";
		$this->db_port="3306";
		$this->db_type="mysql";
		//$this->table_prefix="";
		$this->$table_name='clientes';
		$this->ddbb_id='id_cliente';
		$this->ddbb_name='name_cliente';
		$this->ddbb_tipo='tipo_cliente';
		$this->enlace = mysql_connect($this->db_ip,$this->db_user,$this->db_passwd) or die("No pudo conectarse : " . mysql_error());
		mysql_select_db("pruebas") or die("No pudo seleccionarse la BD.");
		return 1;
		
	}
	function set_id($val)
	{
		$this->id=$val;
		return 1;
	}
	function coger_listado()
	{
		
		$this->sql='SELECT * FROM clientes';
		$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
		return 1;
	}
	function aniadir()
	{
		$this->id_cliente=3;
		$this->name_cliente='tres';
		$this->tipo_cliente='c';
		$this->sql="INSERT INTO `clientes` ( `id_cliente` , `name_cliente` , `tipo_cliente` ) 
VALUES ('".$this->id_cliente."', '".$this->name_cliente."', '".$this->tipo_cliente."')";
		echo $this->sql;
		$this->resultado= mysql_query ($this->sql) or die ("Invalid query");
		if(1==mysql_affected_rows()){
			echo "<br>fila insertada <br>";
		}else{
			echo "<br>fila no insertada <br>";		
		}
		return 1;
	}
		
	
	function borrar($id)
		{
	
			$this->sql="DELETE FROM `clientes` WHERE `id_cliente` = '".$id."' LIMIT 1";
			$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
			if(1==mysql_affected_rows()){
				echo "<br>fila borrada <br>";
			}else{
				echo "<br>fila no borrada <br>";		
			}
			return 1;
	}
	function read($id){
		
		$this->sql='SELECT * FROM clientes WHERE id_cliente='.$id.'';
		$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
		$this->linea = mysql_fetch_array($this->resultado, MYSQL_ASSOC);
		$i=0;	
		foreach ($this->linea as $valor_col) {
				if($i==0) {
					$this->id_cliente=$valor_col;
				}
				if($i==1){
					$this->name_cliente=$valor_col;					
				}
				if($i==2){
					$this->tipo_cliente=$valor_col;					
				}
				$i++;
		}
		return 1;
		
	}
	
	function modificar($id)
	{
		$this->tipo_cliente='d';
		$this->sql="UPDATE `clientes` SET `tipo_cliente` = '".$this->tipo_cliente."' WHERE `id_cliente` = '".$id."' LIMIT 1" ;
		$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
		if(1==mysql_affected_rows()){
			echo "<br>fila modificada <br>";
		}else{
			echo "<br>fila no modificada <br>";		
		}
		return 1;
	
			
	}
	
	function display_list(){
		echo "<table>\n";
		while ($this->linea = mysql_fetch_array($this->resultado, MYSQL_ASSOC)) {
			echo "\t<tr>\n";
			foreach ($this->linea as $valor_col) {
				echo "\t\t<td>$valor_col</td>\n";
			}
			echo "\t</tr>\n";
		}
		echo "</table>\n";
	
	
	}
	function display_client(){
		echo "<table>\n";
		echo "<tr><td colspan='3'>vista cliente</td></tr>";
			echo "\t<tr>\n";
			echo "<td>".$this->id_cliente."</td>";
			echo "<td>".$this->name_cliente."</td>";
			echo "<td>".$this->tipo_cliente."</td>";			
			echo "\t</tr>\n";
		
		echo "</table>\n";
	
	
	}
	function destroy(){
	
		mysql_close ($this->enlace);
		return 1;
	}
}
?>