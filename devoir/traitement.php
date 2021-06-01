<?php
//we start the session
session_start();
$message="false";
$score=0;
//if we click on the verify button
if (isset($_POST["verifier"])) {
	if (empty($_POST["nom"])){
	unset($_COOKIE['nom']);
	setcookie('nom', '', time() - 3600);
	$message="true";
	Header("location:index.php?message=".$message);
	}
	else 
		{
		setcookie("nom",$_POST['nom']);
	
		if (isset($_POST['phrase1'])){
			if ($_POST['phrase1']=="non"){
				$score++;
			}
		}
		if (isset($_POST['phrase2'])){
			if ($_POST['phrase2']=="non"){
				$score++;
			}
		}
		if (isset($_POST['phrase3'])){
			if ($_POST['phrase3']=="oui"){
				$score++;
			}
		}

		if (isset($_POST['phrase4'])){
				$score++;
		}


		if (!isset($_POST['phrase5'])){
				$score++;
		}

		if (isset($_POST['phrase6'])){
				$score++;
		}


		if ($score<6){
			Header("location:index.php?score=".$score);
		}

		else 
		{
			$db = new PDO("mysql:host=localhost;dbname=ce1", "root", "root");
			$reponse = $db->prepare("insert into eleve (nom) values (?)");
			$reponse->execute(array($_POST["nom"]));
			Header("location:bravo.php");
		}
}
}
?>