<?php
# Paul Schmitt | OnboardSense | ISEP 2020
$idchange 			= $_POST['idchange'];
$nomchange 			= $_POST['nomchange'];
$prenomchange 		= $_POST['prenomchange'];
$agechange 			= $_POST['agechange'];
$naisschange 	  	= $_POST['naisschange'];
$addresschange 		= $_POST['addresschange'];

$servername         = "localhost";
$username           = "root";
$password           = "root";
$db                 = "user-verification";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE profile_joueur SET nom='$nomchange', prenom='$prenomchange', age='$agechange', addresse ='$addresschange' WHERE id_user='$idchange'";

if ($conn->query($sql) === TRUE) {
	$home = "../profile_gestio/profile_gestio.php";
	header("location: " . $home);
} else {
	echo "Error updating record: " . $conn->error;
}

$conn->close();
