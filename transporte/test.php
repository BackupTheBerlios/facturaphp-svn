<?
require_once('inc/includes.php');

//Iniciacion de objetos y llamadas a bbdd
echo "antes de users ";
$object=new users();
echo "despues de users<br>";
echo "antes de corps ";
$object=new corps();
echo "despues de corps<br>";
echo "antes de contact ";
$object=new contact();
echo "despues de contact<br>";
echo "antes de clients ";
$object=new clients();
echo "despues de clients<br>";
echo "antes de emps ";
$object=new emps();
echo "despues de emps<br>";
echo "antes de user_corps ";
$object=new user_corps();
echo "despues de user_corps<br>";
echo "antes de groups ";
$object=new groups();
echo "despues de groups<br>";
echo "antes de group_users ";
$object=new group_users();
echo "despues de group_users<br>";
echo "antes de per_group_modules ";
$object=new per_group_modules();
echo "despues de per_group_modules<br>";
echo "antes de per_user_modules ";
$object=new per_user_modules();
echo "despues de per_user_modules<br>";
echo "antes de per_group_methods ";
$object=new per_group_methods();
echo "despues de per_group_methods<br>";
echo "antes de per_user_methods ";
$object=new per_user_methods();
echo "despues de per_user_methods<br>";
echo "antes de permissionss ";
$object=new permissions();
echo "despues de permissions<br>";
echo "antes de products ";
$object=new products();
echo "despues de products<br>";
echo "antes de modules ";
$object=new modules();
echo "despues de modules<br>";
echo "antes de sessions ";
$object=new sessions();
echo "despues de sessions<br>";
echo "antes de methods ";
$object=new methods();
echo "despues de methods<br>";
echo "antes de rel_emps_cats ";
$object=new rel_emps_cats();
echo "despues de rel_emps_cats<br>";
echo "antes de services ";
$object=new services();
echo "despues de services<br>";
echo "antes de cat_emps ";
$object=new cat_emps();
echo "despues de cat_emps<br>";
echo "antes de holydays ";
$object=new holydays();
echo "despues de holydays<br>";
echo "antes de cat_prods ";
$object=new cat_prods();
echo "despues de cat_prods<br>";
echo "antes de vehicles ";
$object=new vehicles();
echo "despues de vehicles<br>";
echo "antes de cat_vehicles ";
$object=new cat_vehicles();
echo "despues de cat_vehicles<br>";
echo "antes de rel_vehicles_cats ";
$object=new rel_vehicles_cats();
echo "despues de rel_vehicles_cats<br>";
echo "antes de drivers ";
$object=new drivers();
echo "despues de drivers<br>";
echo "antes de laborers ";
$object=new laborers();
echo "despues de laborers<br>";
echo "antes de vendors ";
$object=new vendors();
echo "despues de vendors<br>";
echo "antes de rel_prods_cats ";
$object=new rel_prods_cats();
echo "despues de rel_prods_cats<br>";
echo "antes de rel_servs_cats ";
$object=new rel_servs_cats();
echo "despues de rel_servs_cats<br>";
echo "antes de cat_servs ";
$object=new cat_servs();
echo "despues de cat_servs<br>";

/*php
$variable1='pepe';
$variable2=is_int($variable1);
echo $variable1." ".$variable2;
if ($variable==NULL){
	echo "es null";
}
return;
//*********************************************************************************
//Usuarios
require_once('inc/includes.php');
echo '<h2 align="center">Bater&iacute;a de pruebas</h2>';
echo '<h3 align="center">M&oacute;dulo de <U>USUARIOS</U></H3>';
//echo "<p>antes de objeto</p>";
echo "<h3>Usuarios</h3>";
$object=new users();

$object->login='pepe';
$object->passwd='san';
$object->name='pepe';
$object->last_name='san';
$object->last_name2='tos';
$object->full_name='';
$salida=$object->add();
echo "<table><tr><td>A&ntilde;adiendo un usuario</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adido</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adido</font></p>";
}
echo "</td></tr></table>";

$salida=$object->remove($object->id_user);
echo "<table><tr><td>Borrando el usuario recien creado</td><td>";
if($salida>0){

echo "<font color='green'>Borrado</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrado</font></p>";
}
echo "</td></tr></table>";

$salida=$object->read(1);
echo "<table><tr><td>Comprobando un usuario existente</td><td>";
if($salida>0 && $object->login=='admin'){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$object->name='Pepe';
$salida=$object->modify();

echo "<table><tr><td>Modificando un usuario existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

$object->name='David';
$salida=$object->modify();

echo "<table><tr><td>Volviendo a Modificar un usuario existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

//********************************************************************************
//Grupos
echo "<br><h3>Grupos</h3>";
$grupo= new groups();
//echo "<p>despues de grupo</p>";
//a–adimos sus variables
$grupo->name='hola';
$grupo->name_web='hola';
$grupo->desc='hola';
$salida=$grupo->add();
echo "<table><tr><td>A&ntilde;adiendo un grupo</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adido</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adido</font></p>";
}
echo "</td></tr></table>";

$salida=$grupo->remove($grupo->id_group);
echo "<table><tr><td>Borrando el grupo recien creado</td><td>";
if($salida>0){

echo "<font color='green'>Borrado</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrado</font></p>";
}
echo "</td></tr></table>";

$salida=$grupo->read(1);
echo "<table><tr><td>Comprobando un grupo existente</td><td>";
if($salida>0 && $grupo->name=='Mi_grupo'){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$grupo->name='grupo2';
$salida=$grupo->modify();

echo "<table><tr><td>Modificando un grupo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

$grupo->name='Mi_grupo';
$salida=$grupo->modify();

echo "<table><tr><td>Volviendo a Modificar un grupo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";


//*************************************************************************
//Grupos usuarios 
echo "<br><h3>Relaci&oacute;n Grupos Usuarios</h3>";
$grupo_usuario= new group_users();
//echo "<p>despues de objeto</p>";
//a–adimos sus variables
$grupo_usuario->id_group=2;
$grupo_usuario->id_user=2;
$grupo_usuario->up='2004-12-12';
$salida=$grupo_usuario->add();
echo "<table><tr><td>A&ntilde;adiendo una relaci&oacute;n grupo usuario</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adida</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adida</font></p>";
}
echo "</td></tr></table>";

$salida=$grupo_usuario->remove($grupo_usuario->id_group_user);
echo "<table><tr><td>Borrando la relaci&oacute;n grupo usuario recien creada</td><td>";
if($salida>0){

echo "<font color='green'>Borrada</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrada</font></p>";
}
echo "</td></tr></table>";

$salida=$grupo_usuario->read(1);
echo "<table><tr><td>Comprobando una relaci&oacute;n grupo usuario existente</td><td>";
if($salida>0 && $grupo_usuario->id_group==1){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$grupo_usuario->id_group=27;
$salida=$grupo_usuario->modify();

echo "<table><tr><td>Modificando una relaci&oacute;n grupo usuario existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

$grupo_usuario->id_group=1;
$salida=$grupo_usuario->modify();

echo "<table><tr><td>Volviendo a Modificar una relaci&oacute;n grupo usuario existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

//*********************************************************************************
//Permisos Grupos Modulos
echo "<br><h3>Relaci&oacute;n Permisos Grupos modulos</h3>";
$permiso_grupo_modulo= new per_group_modules();
//echo "<p>despues de objeto</p>";
//a–adimos sus variables
$permiso_grupo_modulo->id_group=2;
$permiso_grupo_modulo->id_module=2;
$permiso_grupo_modulo->per=2;
$salida=$permiso_grupo_modulo->add();
echo "<table><tr><td>A&ntilde;adiendo una relaci&oacute;n de permiso grupo modulo</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adida</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adida</font></p>";
}
echo "</td></tr></table>";

$salida=$permiso_grupo_modulo->remove($permiso_grupo_modulo->id_per_group_module);
echo "<table><tr><td>Borrando la relaci&oacute;n de permiso grupo modulo recien creada</td><td>";
if($salida>0){

echo "<font color='green'>Borrada</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrada</font></p>";
}
echo "</td></tr></table>";

$salida=$permiso_grupo_modulo->read(1);
echo "<table><tr><td>Comprobando una relaci&oacute;n de permiso grupo modulo existente</td><td>";
if($salida>0 && $permiso_grupo_modulo->id_group==1){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$permiso_grupo_modulo->id_group=27;
$salida=$permiso_grupo_modulo->modify();

echo "<table><tr><td>Modificando una relaci&oacute;n de permiso grupo modulo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

$permiso_grupo_modulo->id_group=1;
$salida=$permiso_grupo_modulo->modify();

echo "<table><tr><td>Volviendo a Modificar una relaci&oacute;n de permiso grupo modulo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

//******************************************************************************
//Permisos Usuarios Modulos
echo "<br><h3>Relaci&oacute;n Permisos Usuarios modulos</h3>";
$permiso_usuario_modulo= new per_user_modules();
//echo "<p>despues de objeto</p>";
//a–adimos sus variables
$permiso_usuario_modulo->id_user=2;
$permiso_usuario_modulo->id_module=2;
$permiso_usuario_modulo->per=2;
$salida=$permiso_usuario_modulo->add();
echo "<table><tr><td>A&ntilde;adiendo una relaci&oacute;n de permiso usuario modulo</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adida</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adida</font></p>";
}
echo "</td></tr></table>";

$salida=$permiso_usuario_modulo->remove($permiso_usuario_modulo->id_per_user_module);
echo "<table><tr><td>Borrando la relaci&oacute;n de permiso usuario modulo recien creada</td><td>";
if($salida>0){

echo "<font color='green'>Borrada</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrada</font></p>";
}
echo "</td></tr></table>";

$salida=$permiso_usuario_modulo->read(1);
echo "<table><tr><td>Comprobando una relaci&oacute;n de permiso usuario modulo existente</td><td>";
if($salida>0 && $permiso_usuario_modulo->id_user==1){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$permiso_usuario_modulo->id_user=27;
$salida=$permiso_usuario_modulo->modify();

echo "<table><tr><td>Modificando una relaci&oacute;n de permiso usuario modulo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

$permiso_usuario_modulo->id_user=1;
$salida=$permiso_usuario_modulo->modify();

echo "<table><tr><td>Volviendo a Modificar una relaci&oacute;n de permiso usuario modulo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";


//********************************************************************************
//Permisos Grupos Operaciones
echo "<br><h3>Relaci&oacute;n Permisos Grupos operaciones</h3>";
$permiso_grupo_operacion=new per_group_methods();
//echo "<p>despues de objeto</p>";
//a–adimos sus variables
$permiso_grupo_operacion->id_group=2;
$permiso_grupo_operacion->id_method=2;
$permiso_grupo_operacion->per=2;
$salida=$permiso_grupo_operacion->add();
echo "<table><tr><td>A&ntilde;adiendo una relaci&oacute;n de permiso grupo operacion</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adida</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adida</font></p>";
}
echo "</td></tr></table>";

$salida=$permiso_grupo_operacion->remove($permiso_grupo_operacion->id_per_group_method);
echo "<table><tr><td>Borrando la relaci&oacute;n de permiso grupo operacion recien creada</td><td>";
if($salida>0){

echo "<font color='green'>Borrada</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrada</font></p>";
}
echo "</td></tr></table>";

$salida=$permiso_grupo_operacion->read(1);
echo "<table><tr><td>Comprobando una relaci&oacute;n de permiso grupo operacion existente</td><td>";
if($salida>0 && $permiso_grupo_operacion->id_group==1){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$permiso_grupo_operacion->id_group=27;
$salida=$permiso_grupo_operacion->modify();

echo "<table><tr><td>Modificando una relaci&oacute;n de permiso grupo operacion existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

$permiso_grupo_operacion->id_group=1;
$salida=$permiso_grupo_operacion->modify();

echo "<table><tr><td>Volviendo a Modificar una relaci&oacute;n de permiso grupo operacion existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

//*******************************************************************************
//Permisos Usuarios Operaciones
echo "<br><h3>Relaci&oacute;n Permisos Usuarios operaciones</h3>";
$permiso_usuario_operacion= new per_user_methods();
//echo "<p>despues de objeto</p>";
//a–adimos sus variables
$permiso_usuario_operacion->id_user=2;
$permiso_usuario_operacion->id_method=2;
$permiso_usuario_operacion->per=2;
$salida=$permiso_usuario_operacion->add();
echo "<table><tr><td>A&ntilde;adiendo una relaci&oacute;n de permiso usuario operacion</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adida</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adida</font></p>";
}
echo "</td></tr></table>";

$salida=$permiso_usuario_operacion->remove($permiso_usuario_operacion->id_per_user_method);
echo "<table><tr><td>Borrando la relaci&oacute;n de permiso usuario operacion recien creada</td><td>";
if($salida>0){

echo "<font color='green'>Borrada</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrada</font></p>";
}
echo "</td></tr></table>";

$salida=$permiso_usuario_operacion->read(1);
echo "<table><tr><td>Comprobando una relaci&oacute;n de permiso usuario operacion existente</td><td>";
if($salida>0 && $permiso_usuario_operacion->id_user==1){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$permiso_usuario_operacion->id_user=27;
$salida=$permiso_usuario_operacion->modify();

echo "<table><tr><td>Modificando una relaci&oacute;n de permiso usuario operacion existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

$permiso_usuario_operacion->id_user=1;
$salida=$permiso_usuario_operacion->modify();

echo "<table><tr><td>Volviendo a Modificar una relaci&oacute;n de permiso usuario operacion existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";



//**************************************************************************************
//Log de sesiones
//echo "<p>antes de objeto</p>";
echo "<h3>Log de sesiones</h3>";
$log_sesiones=new log_sessions();

$log_sesiones->id_session=2;
$log_sesiones->date_in='2004-12-12';
$log_sesiones->date_out='2004-12-12';
$log_sesiones->timeout='00:00:00';
$log_sesiones->ip='127.0.0.1';
$log_sesiones->id_user=2;
$log_sesiones->country='francia';
$salida=$log_sesiones->add();
echo "<table><tr><td>A&ntilde;adiendo un log de sesi&oacute;n</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adido</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adido</font></p>";
}
echo "</td></tr></table>";

$salida=$log_sesiones->remove($log_sesiones->id_log_session);
echo "<table><tr><td>Borrando el log de sesi&oacute;n recien creado</td><td>";
if($salida>0){

echo "<font color='green'>Borrado</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrado</font></p>";
}
echo "</td></tr></table>";

$salida=$log_sesiones->read(1);
echo "<table><tr><td>Comprobando un log de sesi&oacute;n existente</td><td>";
if($salida>0 && $log_sesiones->id_session==1){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$log_sesiones->id_session=2;
$salida=$log_sesiones->modify();

echo "<table><tr><td>Modificando un log de sesi&oacute;n existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

$log_sesiones->id_session=1;
$salida=$log_sesiones->modify();

echo "<table><tr><td>Volviendo a Modificar un log de sesi&oacute;n existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";


//*****************************************************************************
//Modulos
//echo "<p>antes de objeto</p>";
echo "<h3>Modulos</h3>";
$modulos=new modules();

$modulos->name='empresa';
$modulos->name_web='Empresa del programa';
$modulos->path='c:\\windows\\';
$modulos->active=2;
$salida=$modulos->add();
echo "<table><tr><td>A&ntilde;adiendo un modulo</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adido</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adido</font></p>";
}
echo "</td></tr></table>";

$salida=$modulos->remove($modulos->id_module);
echo "<table><tr><td>Borrando el modulo recien creado</td><td>";
if($salida>0){

echo "<font color='green'>Borrado</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrado</font></p>";
}
echo "</td></tr></table>";

$salida=$modulos->read(1);
echo "<table><tr><td>Comprobando un modulo existente</td><td>";
if($salida>0 && $modulos->name=='usuarios'){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$modulos->name='texto';
$salida=$modulos->modify();

echo "<table><tr><td>Modificando un modulo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

$modulos->name='usuarios';
$salida=$modulos->modify();

echo "<table><tr><td>Volviendo a Modificar un modulo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

//*****************************************************************************
//Sesiones
//echo "<p>antes de objeto</p>";
echo "<br><h3>Sesiones</h3>";
$sesiones= new sessions();
//echo "<p>despues de objeto</p>";
//a–adimos sus variables
$sesiones->id_session_php='adadfadfadfadfadf';
$sesiones->id_user=2;
$sesiones->up='2004-12-12';
$sesiones->down='2004-12-12';
$salida=$sesiones->add();
echo "<table><tr><td>A&ntilde;adiendo una sesion</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adida</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adida</font></p>";
}
echo "</td></tr></table>";

$salida=$sesiones->remove($sesiones->id_session);
echo "<table><tr><td>Borrando la sesion recien creada</td><td>";
if($salida>0){

echo "<font color='green'>Borrada</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrada</font></p>";
}
echo "</td></tr></table>";

$salida=$sesiones->read(1);
echo "<table><tr><td>Comprobando una sesion existente</td><td>";
if($salida>0 && $sesiones->id_user==1){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$sesiones->id_user=27;
$salida=$sesiones->modify();

echo "<table><tr><td>Modificando una sesion existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

$sesiones->id_user=1;
$salida=$sesiones->modify();

echo "<table><tr><td>Volviendo a Modificar una sesion existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

//**************************************************************************
//Log de metodos
//echo "<p>antes de objeto</p>";
echo "<h3>Log de metodos</h3>";
$log_metodos=new log_methods();

$log_metodos->id_user=2;
$log_metodos->id_method=3;
$log_metodos->sql_sentence='select * from log_sessions';
$log_metodos->datetime='2004-12-12 00:00:00';
$log_metodos->afected=2;
$salida=$log_metodos->add();
echo "<table><tr><td>A&ntilde;adiendo un log de metodos</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adido</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adido</font></p>";
}
echo "</td></tr></table>";

$salida=$log_metodos->remove($log_metodos->id_log_method);
echo "<table><tr><td>Borrando el log de metodos recien creado</td><td>";
if($salida>0){

echo "<font color='green'>Borrado</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrado</font></p>";
}
echo "</td></tr></table>";

$salida=$log_metodos->read(1);
echo "<table><tr><td>Comprobando un log de metodos existente</td><td>";
if($salida>0 && $log_metodos->id_method==1){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$log_metodos->id_method=2;
$salida=$log_metodos->modify();

echo "<table><tr><td>Modificando un log de metodos existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

$log_metodos->id_method=1;
$salida=$log_metodos->modify();

echo "<table><tr><td>Volviendo a Modificar un log de metodos existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

//*****************************************************************
//Metodos
echo "<h3>Metodos</h3>";
$metodo=new methods();

$metodo->name='a&ntilde;adir';
$metodo->name_web='A&ntilde;adir un nuevo metodo';
$metodo->id_module=1;
$metodo->id_type_method=2;
$salida=$metodo->add();
echo "<table><tr><td>A&ntilde;adiendo un metodo</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adido</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adido</font></p>";
}
echo "</td></tr></table>";

$salida=$metodo->remove($metodo->id_method);
echo "<table><tr><td>Borrando el metodo recien creado</td><td>";
if($salida>0){

echo "<font color='green'>Borrado</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrado</font></p>";
}
echo "</td></tr></table>";

$salida=$metodo->read(1);
echo "<table><tr><td>Comprobando un metodo existente</td><td>";
if($salida>0 && $metodo->name=='alta'){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$metodo->name='Pepe';
$salida=$metodo->modify();

echo "<table><tr><td>Modificando un metodo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

$metodo->name='alta';
$salida=$metodo->modify();

echo "<table><tr><td>Volviendo a Modificar un metodo existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificado</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificado</font></p>";
}
echo "</td></tr></table>";

//*************************************************************************
//MODULO DE EMPRESA
//*************************************************************************
echo '<h3 align="center">M&oacute;dulo de <U>EMPRESA</U></H3>';
//*************************************************************************
//empleados por categoria 
echo "<br><h3>Relaci&oacute;n empleados por categoria</h3>";
$empleado_categoria= new rel_emps_cats();
//echo "<p>despues de objeto</p>";
//a–adimos sus variables
$empleado_categoria->id_emp=2;
$empleado_categoria->id_cat_emp=2;
$salida=$empleado_categoria->add();
echo "<table><tr><td>A&ntilde;adiendo una relaci&oacute;n empleado por categoria</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adida</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adida</font></p>";
}
echo "</td></tr></table>";

$salida=$empleado_categoria->remove($empleado_categoria->id_rel_emp_cat);
echo "<table><tr><td>Borrando la relaci&oacute;n empleado por categoria recien creada</td><td>";
if($salida>0){

echo "<font color='green'>Borrada</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrada</font></p>";
}
echo "</td></tr></table>";

$salida=$empleado_categoria->read(1);
echo "<table><tr><td>Comprobando una relaci&oacute;n empleado por categoria existente</td><td>";
if($salida>0 && $empleado_categoria->id_emp==1){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$empleado_categoria->id_emp=27;
$salida=$empleado_categoria->modify();

echo "<table><tr><td>Modificando una relaci&oacute;n empleado por categoria existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

$empleado_categoria->id_emp=1;
$salida=$empleado_categoria->modify();

echo "<table><tr><td>Volviendo a Modificar una relaci&oacute;n empleado por categoria existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

//********************************************************************************************
//empleados por categoria 
echo "<br><h3>Relaci&oacute;n categoria de empleados</h3>";
$categoria_empleado= new cat_emps();
//echo "<p>despues de objeto</p>";
//a–adimos sus variables
$categoria_empleado->name=2;
$categoria_empleado->descrip=2;
$salida=$categoria_empleado->add();
echo "<table><tr><td>A&ntilde;adiendo una relaci&oacute;n categoria de empleado</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adida</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adida</font></p>";
}
echo "</td></tr></table>";

$salida=$categoria_empleado->remove($categoria_empleado->id_cat_emp);
echo "<table><tr><td>Borrando la relaci&oacute;n categoria de empleado recien creada</td><td>";
if($salida>0){

echo "<font color='green'>Borrada</font>";
}else {

	echo "<p align='right'><font color='red'>No Borrada</font></p>";
}
echo "</td></tr></table>";

$salida=$categoria_empleado->read(1);
echo "<table><tr><td>Comprobando una relaci&oacute;n categoria de empleado existente</td><td>";
if($salida>0 && $categoria_empleado->name=='Gestor'){

echo "<font color='green'>Existe</font>";
}else {

	echo "<p align='right'><font color='red'>No Existe</font></p>";
}
echo "</td></tr></table>";

$categoria_empleado->name='Camionero';
$salida=$categoria_empleado->modify();

echo "<table><tr><td>Modificando una relaci&oacute;n categoria de empleado existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

$categoria_empleado->name='Gestor';
$salida=$categoria_empleado->modify();

echo "<table><tr><td>Volviendo a Modificar una relaci&oacute;n categoria de empleado existente</td><td>";
if($salida>0){

echo "<font color='green'>Modificada</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificada</font></p>";
}
echo "</td></tr></table>";

//*****************************************************************************
//vacaciones
//echo "<p>antes de objeto</p>";
echo "<br><h3>Vacaciones</h3>";
$vacaciones= new holydays();
//echo "<p>despues de objeto</p>";
//a–adimos sus variables
$vacaciones->id_emp=2;
$vacaciones->ill=2;
$vacaciones->gone='2004-12-12';
$vacaciones->come='2004-12-12';
$vacaciones->descrip='ad ad adpfi adfadp a sdp';
$salida=$vacaciones->add();
echo "<table><tr><td>A&ntilde;adiendo unas vacaciones</td><td>";
if($salida>0){

echo "<font color='green'>A&ntilde;adidas</font>";
}else {

	echo "<p align='right'><font color='red'>No A&ntilde;adidas</font></p>";
}
echo "</td></tr></table>";

$salida=$vacaciones->remove($vacaciones->id_holy);
echo "<table><tr><td>Borrando las vacacioens recien creadas</td><td>";
if($salida>0){

echo "<font color='green'>Borradas</font>";
}else {

	echo "<p align='right'><font color='red'>No Borradas</font></p>";
}
echo "</td></tr></table>";

$salida=$vacaciones->read(1);
echo "<table><tr><td>Comprobando unas vacaciones existentes</td><td>";
if($salida>0 && $vacaciones->id_emp==1){

echo "<font color='green'>Existen</font>";
}else {

	echo "<p align='right'><font color='red'>No Existen</font></p>";
}
echo "</td></tr></table>";

$vacaciones->id_emp=27;
$salida=$vacaciones->modify();

echo "<table><tr><td>Modificando unas vacaciones existentes</td><td>";
if($salida>0){

echo "<font color='green'>Modificadas</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificadas</font></p>";
}
echo "</td></tr></table>";

$vacaciones->id_emp=1;
$salida=$vacaciones->modify();

echo "<table><tr><td>Volviendo a Modificar unas vacaciones existentes</td><td>";
if($salida>0){

echo "<font color='green'>Modificadas</font>";
}else {

	echo "<p align='right'><font color='red'>No Modificadas</font></p>";
}
echo "</td></tr></table>";
*/
?>