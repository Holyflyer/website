<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE"); 
include("inc/config.php");

// CONNECT TO DB

$mysqli = new mysqli("$mysql_host", "$mysql_user", "$mysql_password", "$mysql_db");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// Set character_set_client and character_set_connection
$mysqli->query("SET character_set_client=utf8");
$mysqli->query("SET character_set_connection=utf8");
$mysqli->query("SET NAMES 'utf8'");


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>
I.T. Inventory</title>
<meta charset="utf-8">

<script src="//code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="inc/bootstrap3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="inc/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#sortable").tablesorter(); 
    } 
); 
</script>

<!-- Bootstrap core CSS -->
    <!--<link href="inc/bootstrap3/css/bootstrap.css" rel="stylesheet">-->
    <link href='inc/bootstrap3/css/bootstrap_yeti.css' rel='stylesheet'>
    <link rel="stylesheet" href="inc/FontAwesome/css/font-awesome.min.css">

</head>
<body style='margin-top:110px;'>


<!-- NAVBAR -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="container">
	<div class="navbar-header">
	<a class="navbar-brand" href="index.php"><b>INVENTORY</b></a>
	</div>
	<div class="collapse navbar-collapse">
	<ul class="nav navbar-nav">
		<li><a href="item.php?action=add"><b>Add Item</b></a></li>
<!--		<li><a href="reports.php"><b>Queries</b></a></li>    -->
	</ul>
	</div>
</div>
</div>
<!-- END NAVBAR -->

<!-- MAIN CONTAINER -->
<div class='container'>
