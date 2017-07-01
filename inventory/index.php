<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE"); 

session_start();

include("inc/header.php");

// process login if submitted
if(isset($_POST["login"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];
	if($username == $site_admin && $password == $site_admin_password) {
		$_SESSION["loggedin"] = true;
	}
}

// if logged in show inventory
if($_SESSION["loggedin"] == true) {

?>


<!-- ROW 1 -->
<div class='row' style='background-color:#f5f5f5;border:1px solid #dcdcdc;border-radius:5px;margin-bottom:30px;padding:10px;'>
<div class="col-md-3">
<form class='form' name='choose' method='post' action='index.php'>
<select name='environment' onchange='this.form.submit()' class='form-control col-md-3'>
<option value='all'>Environment</option>

<?php
// ENVIRONMENT FILTER
$query = "SELECT distinct environment FROM items";
$result = $mysqli->query($query);
while ($row = mysqli_fetch_array($result)) {
	echo "<option value='" . $row["environment"] . "'>" . $row["environment"] . "</option>";
}

?>

</select>
</form>
</div>

<div class="col-md-3">
<form class='form' name='choose' action='index.php' method='post'>
<select name='security_zone' onchange='this.form.submit()' class='form-control col-md-3'>
<option value='all'>Security Zone</option>

<?php
// security_zone FILTER
$query = "SELECT distinct security_zone FROM items";
$result = $mysqli->query($query);
while ($row = mysqli_fetch_array($result)) {
	echo "<option value='" . $row["security_zone"] . "'>" . $row["security_zone"] . "</option>";
}

?>

</select>
</form>
</div>


<div class="col-md-3">
<form class='form' name='choose' action='index.php' method='post'>
<select name='client' onchange='this.form.submit()' class='form-control col-md-3'>
<option value='all'>Client</option>

<?php
// client FILTER
$query = "SELECT distinct client FROM items";
$result = $mysqli->query($query);
while ($row = mysqli_fetch_array($result)) {
	echo "<option value='" . $row["client"] . "'>" . $row["client"] . "</option>";
}

?>

</select>
</form>
</div>

<!-- SEARCH -->
<div class="col-md-3" style='text-align:right;'>
<form class='form' name='search' action='index.php' method='post'>
<input type='text' name='search' placeholder='search' class='form-control col-md-3'>
</form>
</div>


</div> <!-- END ROW 1 -->
<div class='row'> <!-- ROW 2 -->

<?php
if(isset($_POST["environment"])) {
	$environment = $_POST["environment"];
	$query = "SELECT * FROM items WHERE environment='$environment'";
}
elseif(isset($_POST["security_zone"])) {
	$security_zone = $_POST["security_zone"];
	$query = "SELECT * FROM items WHERE security_zone='$security_zone'";
}
elseif(isset($_POST["client"])) {
	$client = $_POST["client"];
	$query = "SELECT * FROM items WHERE client='$client'";
}
elseif(isset($_POST["search"])) {
	$search = $_POST["search"];
	$query = "SELECT * FROM items WHERE 
	hostname LIKE '%$search%' 
	OR ip_address LIKE '%$search%' 
	OR virtual_ip LIKE '%$search%'
	OR os LIKE '%$search%'
	OR application LIKE '%$search%' 
	OR description LIKE '%$search%' ORDER BY  inet_aton(ip_address) DESC";
}
else {
	$query = "SELECT * FROM items ORDER BY server_id DESC";
}
$result = $mysqli->query($query);

echo "
<table id='sortable' class='table table-striped'>
	<thead>
	<tr>
		<th>NO#</th>
		<th>Environment</th>
		<th>Hostname</th>
		<th>OS</th>
		<th>IP Address</th>
		<th>Application</th>
		<th>Zone</th>
		<th>Client</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	</thead>
	<tbody>";

while ($row = mysqli_fetch_array($result)) {
	
	$server_id = $row["server_id"];
	$environment = $row["environment"];
	$hostname = $row["hostname"];
	$os = $row["os"];
	$ip_address = $row["ip_address"];
	$application = $row["application"];
	$security_zone = $row["security_zone"];
	$client = $row["client"];
    
    echo "
    <tr>
        <td>$server_id</td>
        <td>$environment</td>
        <td>$hostname</td>
        <td>$os</td>
        <td>$ip_address</td>
        <td>$application</td>
        <td>$security_zone</td>
        <td>$client</td>
        <td><a href='item.php?action=view&server_id=$server_id'><i class='icon-file-alt'></i></a></td>
        <td><a href='item.php?action=edit&server_id=$server_id'><i class='icon-edit'></i></a></td>
        <td><a href='item.php?action=retire&server_id=$server_id&hostname=$hostname'><i class='icon-remove-sign'></i></a></td>
    </tr>";

}

echo "
	</tbody>
</table>";

}

// not logged in
else {
	echo "
	<div class='well'>
	<form class='form form-horizontal' name='login' method='post' action='index.php'>
	<fieldset>
	<legend>Login</legend>
	<input type='text' name='username' placeholder='username'>
	<br><br>
	<input type='password' name='password' placeholder='password'>
	<br><br>
	<button type='submit' name='login' class='btn btn-primary'>Authenticate</button>
	</fieldset>
	</form>
	</div>";

}

include("inc/footer.html");

?>
