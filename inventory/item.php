<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE"); 

session_start();

include("inc/header.php");

if($_SESSION["loggedin"] == true) {

if(isset($_POST["add"])) {
	
	$return = addItem($mysqli);
	$server_id = $return[2];
	if($return[1] == "true") {
		$edit = true;
	}
	$message = $return[0];
	
}
elseif(isset($_POST["edit"])) {

	$return = editItem($mysqli);
	$server_id = $return[2];
	if($return[1] == "true") {
		$edit = true;
	}
	$message = $return[0];
	
}

elseif(isset($_POST["checkout"])) {

	$message = checkoutItem($mysqli);
	$_GET["action"] = 'checkout';
	
}

elseif(isset($_POST["checkin"])) {

	$message = checkinItem($mysqli);
	$_GET["action"] = 'checkin';
	
}

elseif(isset($_POST["retire"])) {

	$message = retireItem($mysqli);
	$_GET["action"] = 'retire';
	
}

// FORM FOR ADDING AN ITEM
if($_GET["action"] == 'add') {

	?>
	
	<!-- ROW 1 -->
	<div class='row'>
	<form class='form form-horizontal' name='add_item' method='post' action='item.php'>

	<div class="form-group">
		<label for="environment" class="col-sm-2 control-label">Existing Environment</label>
		<div class="col-sm-10">
		<select name='environment' class='form-control'>

		<?php
		$query = "SELECT DISTINCT environment FROM items WHERE environment <> '' ORDER BY environment ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["environment"] . "'>" . $row["environment"] . "</option>";
		}
		
		?>

		</select>
		</div>
	</div>
	
	<!-- new Environment -->
	<div class="form-group">
		<label for="new_environment" class="col-sm-2 control-label">Environment</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='new_environment' id="new_environment" placeholder='leave blank if use existing environment'>
		</div>
	</div>
	
	<!-- hostname -->
	<div class="form-group">
		<label for="hostname" class="col-sm-2 control-label">Hostname <font color="#FF0000">*</font></label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="hostname" id="hostname">
		</div>
	</div>	

	<div class="form-group">
		<label for="os" class="col-sm-2 control-label">Existing OS Type</label>
		<div class="col-sm-10">
		<select name='os' class='form-control'>

		<?php
		$query = "SELECT DISTINCT os FROM items WHERE os <> '' ORDER BY os ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["os"] . "'>" . $row["os"] . "</option>";
		}
		
		?>

		</select>
		</div>
	</div>	
	
	<!-- new os -->
	<div class="form-group">
		<label for="new_os" class="col-sm-2 control-label">Operating System</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='new_os' id="new_os" placeholder='leave blank if use existing OS type'>
		</div>
	</div>
	
	<!-- virtual_ip -->
	<div class="form-group">
		<label for="virtual_ip" class="col-sm-2 control-label">Virtual IP</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="virtual_ip" id="virtual_ip">
		</div>
	</div>	

	<!-- ip_address -->
	<div class="form-group">
		<label for="ip_address" class="col-sm-2 control-label">IP Address <font color="#FF0000">*</font></label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="ip_address" id="ip_address">
		</div>
	</div>	

	<!-- application -->
	<div class="form-group">
		<label for="application" class="col-sm-2 control-label">Application <font color="#FF0000">*</font></label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="application" id="application">
		</div>
	</div>	

	<div class="form-group">
		<label for="security_zone" class="col-sm-2 control-label">Existing Security Zone</label>
		<div class="col-sm-10">
		<select name='security_zone' class='form-control'>

		<?php
		$query = "SELECT DISTINCT security_zone FROM items WHERE security_zone <> '' ORDER BY security_zone ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["security_zone"] . "'>" . $row["security_zone"] . "</option>";
		}
		
		?>

		</select>
		</div>
	</div>	
	
	
	<!-- new Security Zone -->
	<div class="form-group">
		<label for="new_security_zone" class="col-sm-2 control-label">Security Zone</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='new_security_zone' id="new_security_zone" placeholder='leave blank if use existing Security Zone'>
		</div>
	</div>
	
	<!-- client -->
	<div class="form-group">
		<label for="client" class="col-sm-2 control-label">Client</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="client" id="client">
		</div>
	</div>	

	<!-- description -->
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label">Description</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="description" id="description">
		</div>
	</div>	


	<!-- Submit -->
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" name='add' class="btn btn-primary">Submit</button>
		</div>
	</div>
	
	</form>
	</div> <!-- END ROW 1 -->
	<br><br>
	<?php

}

// FORM FOR EDITING AN ITEM
elseif($_GET["action"] == 'edit' || $edit == true) {

	if(isset($server_id)) {
		// nothing
	}
	else {
		$server_id = $_GET["server_id"];
	}
	$query = "SELECT * FROM items WHERE server_id='$server_id'";
	$result = $mysqli->query($query);
	while ($row = mysqli_fetch_array($result)) {
	    $hostname = $row["hostname"];
	    $environment = $row["environment"];
		$virtual_ip = $row["virtual_ip"];
	    $ip_address = $row["ip_address"];
	    $os = $row["os"];
	    $application = $row["application"];
	    $security_zone = $row["security_zone"];
	    $client = $row["client"];
		$description = $row["description"];
//      $create_date = $row["create_date"];
//		$updated_date = $row["updated_date"];
	}

	if(isset($message)) {
		echo "<div class='row'>$message</div> <!-- end row 1 -->";
	}
	
	?>
	

	
	<!-- ROW 1 -->
	<div class='row'>
	<form class='form form-horizontal' name='edit_item' method='post' action='item.php'>
	

	
	<div class='well'>
	<fieldset>
	<legend>Edit Info</legend>

	<!-- Server ID -->
	<input type='hidden' name='server_id' value='<?php echo $server_id; ?>'>
	
	<div class="form-group">
		<label for="asset_id" class="col-sm-2 control-label">Server ID</label>
		<div class="col-sm-10">
		<?php echo $server_id; ?>
		</div>
	</div>

	<!-- Environment -->
	<div class="form-group">
		<label for="environment" class="col-sm-2 control-label">Environment</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='environment' id="environment" value='<?php  echo $environment; ?>'>
		</div>
	</div>

	<!-- hostname -->
	<div class="form-group">
		<label for="hostname" class="col-sm-2 control-label">Hostname</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='hostname' id="hostname" value='<?php echo $hostname; ?>'>
		</div>
	</div>	
	
	<!--  os -->
	<div class="form-group">
		<label for="os" class="col-sm-2 control-label">Operating System</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='os' id="os"  value='<?php  echo $os; ?>'>
		</div>
	</div>
	
	<!-- virtual_ip -->
	<div class="form-group">
		<label for="virtual_ip" class="col-sm-2 control-label">Virtual IP</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='virtual_ip' id="virtual_ip" value='<?php  echo $virtual_ip; ?>'>
		</div>
	</div>	

	<!-- ip_address -->
	<div class="form-group">
		<label for="ip_address" class="col-sm-2 control-label">IP Address</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="ip_address" id="ip_address" value="<?php  echo $ip_address; ?>">
		</div>
	</div>	

	<!-- application -->
	<div class="form-group">
		<label for="application" class="col-sm-2 control-label">Application</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="application" id="application" value="<?php  echo $application; ?>">
		</div>
	</div>	

	
	<!-- security_zone -->
	<div class="form-group">
		<label for="security_zone" class="col-sm-2 control-label">Security Zone</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='security_zone' id="security_zone" value="<?php  echo $security_zone; ?>">
		</div>
	</div>
	
	<!-- client -->
	<div class="form-group">
		<label for="client" class="col-sm-2 control-label">Client</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="client" id="client" value="<?php  echo $client; ?>">
		</div>
	</div>	

	<!-- description -->
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label">Description</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="description" id="description" value="<?php  echo $description; ?>">
		</div>
	</div>	
	</fieldset>
	</div>

	
	<!-- Submit -->
	<div class='well'>
	<div class="form-group">
		<label for="room" class="col-sm-2 control-label">Save Changes</label>
		<div class="col-sm-10">
		<button type="submit" name='edit' class="btn btn-primary">Submit</button>
		</div>
	</div>
	</div>
	
	
	</form>
	<br><br>
	<?php


}

// VIEW AN ITEM
elseif($_GET["action"] == 'view') {

	$server_id = $_GET["server_id"];
	
	echo "<table class='table table-striped'>";
	
	$query = "SELECT * FROM items WHERE server_id='$server_id'";
	$result = $mysqli->query($query);
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr><td>server_id</td><td>" . $row["server_id"] . "</td></tr>";
		echo "<tr><td>environment</td><td>" . $row["environment"] . "</td></tr>";
		echo "<tr><td>os</td><td>" . $row["os"] . "</td></tr>";
		echo "<tr><td>hostname Date</td><td>" . $row["hostname"] . "</td></tr>";
		echo "<tr><td>virtual_ip</td><td>" . $row["virtual_ip"] . "</td></tr>";
		echo "<tr><td>ip_address</td><td>" . $row["ip_address"] . "</td></tr>";
		echo "<tr><td>application</td><td>" . $row["application"] . "</td></tr>";
		echo "<tr><td>security_zone</td><td>" . $row["security_zone"] . "</td></tr>";
		echo "<tr><td>client</td><td>" . $row["client"] . "</td></tr>";
		echo "<tr><td>description</td><td>" . $row["description"] . "</td></tr>";
	}

	echo "</table>";

}



// RETIRE AN ITEM
elseif($_GET["action"] == 'retire') {

	if(isset($message)) {
		echo "$message";
	}
	else {
		$server_id = $_GET["server_id"];
		$hostname = $_GET["hostname"];
		
		echo "
		<div class='well'>
		Do you want to delete server $hostname (ID:$server_id) $today?<br><br>
		<form name='retire' method='post' action='item.php?server_id=$server_id'>
		<button type='submit' name='retire' class='btn btn-primary'>Delete Record</button>
		</form>
		</div>";
	}

}



// ERROR
else {
	echo "no action specified";
}

}

// not logged in
else {
	echo "
	<div class='well'>
	Please <a href='index.php'>return to the home page and log in</a>
	</div>";
}

include("inc/footer.html");


// --------- //
// FUNCTIONS //
// --------- //

// ADD ITEM //
function addItem($mysqli) {

	$environment = $_POST["environment"];
	if($new_environment != "") {
		$environment = $new_environment;
	}
	$hostname = $_POST["hostname"];
	$os = $_POST["os"];
	if($new_os != "") {
		$os = $new_os;
	}
	$virtual_ip = $_POST["virtual_ip"];
	$ip_address = $_POST["ip_address"];
	$application = $_POST["application"];	
	$security_zone = $_POST["security_zone"];
	if($new_security_zone != "") {
		$security_zone = $new_security_zone;
	}
	$client = $_POST["client"];
    $description = $_POST["description"];

	$query = "INSERT INTO items 
	(hostname,environment,virtual_ip,ip_address,os,application,security_zone,client,description)
	VALUES
	('$hostname','$environment','$virtual_ip','$ip_address','$os','$application','$security_zone','$client','$description')";
	
	if($hostname == "" || $ip_address == "" || $application == "") {

		echo "Please input Hostname, IP and application details!";
	    break;
	}
	else {
		$result = $mysqli->query($query);

	if($result) {
		$message = "<div class='alert alert-success'>Item added successfully!</div>";
		$return_vals = array($message,"true",$server_id);
		return $return_vals;
	}
	else {
		echo "<div class='alert alert-error'>Error: " . $mysqli->error . "</div>";
		$itworked = false;
		return $itworked;
	}
	}
	

	}




// EDIT ITEM //
function editItem($mysqli) {

	// editing an item
	//echo "editing..";
	$server_id = $_POST["server_id"];
	$environment = $_POST["environment"];
	$hostname = $_POST["hostname"];
	$os = $_POST["os"];
	$virtual_ip = $_POST["virtual_ip"];
	$ip_address = $_POST["ip_address"];
	$application = $_POST["application"];	
	$security_zone = $_POST["security_zone"];
	$client = $_POST["client"];
    $description = $_POST["description"];

	
	$query = "UPDATE items SET environment='$environment',hostname='$hostname',
	os='$os',virtual_ip='$virtual_ip',ip_address='$ip_address',application='$application',security_zone='$security_zone',
	client='$client',description='$description' WHERE server_id='$server_id'";
	
	//echo "<br><br>$query<br><br>";
	
	$result = $mysqli->query($query);
	if($result) {
		
		$message = "<div class='alert alert-success'>Item edited successfully!</div>";
		$return_vals = array($message,"true",$server_id);
		return $return_vals;
		
	}
	else {
		echo "<div class='alert alert-error'>Error: " . $mysqli->error . "</div>";
		$itworked = false;
		return $itworked;
	}

}

// DELETE ITEM

function retireItem($mysqli) {
	$server_id = $_GET["server_id"];
	$query = "DELETE FROM items WHERE server_id='$server_id'";
	//echo $query;
	$result = $mysqli->query($query);
	if($result) {	
		$message = "<div class='alert alert-success'>Record Deleted.</div>";
		return $message;
	}
}


?>


