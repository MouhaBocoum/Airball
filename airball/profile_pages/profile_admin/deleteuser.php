<?php
# Paul Schmitt | OnboardSense | ISEP 2020
$idchange 		= $_POST['idchange'];

$servername          = "localhost";
$username             = "root";
$password             = "root";
$db                    = "user-verification";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM profile_joueur WHERE id_user='$idchange'";

if ($conn->query($sql) === TRUE) {
	$home = "../profile_admin/profile_admin.php";
	header("location: " . $home);
} else {
	echo "Error updating record: " . $conn->error;
}

$conn->close();
