<?php
/*require_once('/var/www/proyectos/transporte/inc/smarty/Smarty.class.php') ; 
$tpl=new smarty;*/
class clientesmarty
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
	
	function clientesmarty()
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
		//$this->campos=mysql_list_fields("pruebas","clientes");
		//print_r($this->campos);
			$this->campos[0]=$this->ddbb_id;
			$this->campos[1]=$this->ddbb_name;
			$this->campos[2]=$this->ddbb_tipo;
//			print_r($this->campos);
			return 1;
		
	}
	function coger_lista()
	{
		$this->sql='SELECT * FROM clientes';
		$this->resultado = mysql_query($this->sql) or die("La consulta fall&oacute;: " . mysql_error());
		return 1;
	}
	function display_list()
	{
		echo "<table>\n";
		while ($this->linea = mysql_fetch_array($this->resultado, MYSQL_ASSOC)) {
			echo "\t<tr>\n";
			foreach ($this->linea as $valor_col) {
				echo "\t\t<td>$valor_col</td>\n";
			}
			echo "\t</tr>\n";
		}
		echo "</table>\n";
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
			$tpl->assign("valores",$this->tablacompleta);
			$tpl->display('verconsmarty.tpl');
	}
	
	function destroy(){
	
		mysql_close ($this->enlace);
		return 1;
	}
	
}
?>