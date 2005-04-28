<?php
/* $Id: calendar.php,v 2.3 2004/05/07 17:58:37 rabus Exp $ */

/*include('admin/grab_globals.lib.php');*/
$is_minimum_common = TRUE;
//include('admin/common.lib.php');
include('admin/header_http.inc.php');
$day_of_week = array('Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab');
$month = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
?>

<html>
<head>
<title>Calendario</title>
<link rel="stylesheet" href="calendar.css" type="text/css">
<script type="text/javascript" src="calendar.js"></script>

<script type="text/javascript">
<!--
var month_names = new Array("<?php echo implode('","', $month); ?>");
var day_names = new Array("<?php echo implode('","', $day_of_week); ?>");
//-->
</script>
</head>
<body onload="initCalendar();">
<div id="calendar_data"></div>
<div id="clock_data"></div>
</body>
</html>
