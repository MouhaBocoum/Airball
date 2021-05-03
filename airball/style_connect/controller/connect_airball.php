<?php

require_once 'mail.php';
session_start();

//we connect to the database precisely to the table user verfication
try {
    $conn = new PDO('mysql:host=localhost;dbname=user-verification', 'root', 'root');
} catch (PDOException $e){
    exit("Database error.");
}
//this controller's main goal is two enable us to be able to log and sign in the users of our website
//IN THIS PART OF THE CODE WE HAVE THE FEATURES OF OUR SIGN UP PAGE
//these are our variables
//we declare the globally so that they can be used everywhere in the code
$errors_sign_up=array();
$new_user_name="";
$new_user_email="";
$new_user_password="";
$new_user_password_confirm="";
//we define the variables for our sign up
if (isset($_POST["sign_up_btn"])) {
	$new_user_name=$_POST['new_user_name'];
	$new_user_email=$_POST['new_user_email'];
	$new_user_password=$_POST['new_user_password'];
	$new_user_password_confirm=$_POST['new_user_password_confirm'];
	//we manage the possible errors from the user
	if(empty($new_user_name) OR empty($new_user_email) OR empty($new_user_password) OR empty($new_user_password_confirm)){
		$errors_sign_up['vide']="Veuillez renseigner tous les champs";
	}
	//we make sure that the email is good
	//if this statement is true then the mail provided by the user is invalid 
	if (!empty($new_user_email) AND !filter_var($new_user_email,FILTER_VALIDATE_EMAIL)) {
		$errors_sign_up['email']="Adresse mail non valide";
	}
	//we check if the mail used to create has not been used already
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
	$stmt->execute([$new_user_email]); 
	$user = $stmt->fetch();
	if ($user) {
		$errors_sign_in['email']="Email existe déjà";
	}
	//now before processing the registration of the new user, we will check if the information he wrote is correct
	if (count($errors_sign_up)===0 && $new_user_password==$new_user_password_confirm) {
		//if there are no errors, now we can save the user's information
	    // we encrypt his password so it cant be seen in the database
		$new_user_password=password_hash($new_user_password,PASSWORD_DEFAULT);
		//these two variables will help us verify the email of a person
		$token=bin2hex(random_bytes(50));
		$verified=0;
		//now we insert the users info in our database
		$sql = "INSERT INTO users (username, email, user_password, verified, token) VALUES (?,?,?,?,?)";
		$stmt= $conn->prepare($sql);
		$stmt->execute([$new_user_name,$new_user_email,$new_user_password,$verified,$token]);
		if ($stmt->rowCount() >= 1) {
		//We log the new user into his profile page
		$user_id=$conn->insert_id;
		//now in order to log the verify the user on our website,we will send him a verification mail
		sendVerificationEmail($new_user_email,$token);
		header('location:http://localhost:8888/airball/profile_pages/profile_not_verified.php');
		exit();
		} else {
		$errors_sign_up['login_error']="Erreur connexion";
		}
	}
	elseif(!empty($new_user_password_confirm) AND !empty($new_user_password) AND $new_user_password_confirm!=$new_user_password){
		$errors_sign_up['password_error']="Les mots de passe sont différents";
	}
}

//IN THIS PART OF THE CODE WE HAVE THE FEATURES OF OUR SIGN IN PAGE
//we define the variables for our sign in
$errors_sign_in=array();
$user_name="";
$user_password="";
if (isset($_POST["sign_in_btn"])) {
	$user_name=$_POST['user_name'];
	$user_password=$_POST['user_password'];
	//we manage the possible errors from the user
	if(empty($user_name) OR empty($user_password)){
		$errors_sign_in['vide']="Veuillez renseigner tous les champs";
	}
	//now before processing the registration of the new user, we will check if the information he wrote is correct
	if (count($errors_sign_in)==0) {
		//if there are no errors, now we can save the user's information
		//we check if the written email or username is valid
		//we check if the mail used to create has not been used already
		$sql="SELECT * FROM users WHERE email=:email OR username=:user LIMIT 1";
		$stmt=$conn->prepare($sql);
		$stmt->execute(array(':email'=>$user_name, ':user'=>$user_name));
		$user=$stmt->fetch(PDO::FETCH_ASSOC);
		$_SESSION['id']=$user['id'];
		//we get the profile information of our user
		// select a particular user by id
		$stmt = $conn->prepare("SELECT * FROM profile_joueur WHERE id_user=:id");
		$stmt->execute(['id' => $_SESSION['id']]); 
		$user_profile = $stmt->fetch();
		//now we check if the password is valid
		if (password_verify($user_password,$user['user_password']) AND $user['verified']==1) { 
			//We log the new user into his profile page
			$_SESSION['token']=$user['token'];
			$_SESSION['username']=$user['username'];
			$_SESSION['email']=$user['email'];
			$_SESSION['veridied']=$user['verified'];
			$_SESSION['nom']=$user_profile['nom'];
			$_SESSION['prenom']=$user_profile['prenom'];
			$_SESSION['age']=$user_profile['age'];
			$_SESSION['naissance']=$user_profile['naissance'];
			$_SESSION['addresse']=$user_profile['addresse'];
			header('location:http://localhost:8888/airball/profile_pages/profile_joueur/profile_joueur.php');
			exit();
		}
		elseif (password_verify($user_password,$user['user_password']) AND $user['verified']==2) { 
			//We log the new user into his profile page
			$_SESSION['token']=$user['token'];
			$_SESSION['username']=$user['username'];
			$_SESSION['email']=$user['email'];
			$_SESSION['veridied']=$user['verified'];
			$_SESSION['nom']=$user_profile['nom'];
			$_SESSION['prenom']=$user_profile['prenom'];
			$_SESSION['age']=$user_profile['age'];
			$_SESSION['naissance']=$user_profile['naissance'];
			$_SESSION['addresse']=$user_profile['addresse'];
			header('location:http://localhost:8888/airball/profile_pages/profile_joueur/profile_joueur.php');
			exit();
		}
		elseif(!password_verify($user_password,$user['user_password'])){
			$errors_sign_in['login_error']="Mauvais mot de passe";
		}
		elseif (!$user['verified']==1 OR !$user['verified']==2) {
			$errors_sign_in['login_error']="Veuillez vérifier votre compte";
		}
	}
}
//this function will be used to verify the token of the user
//if the token that we got from our link can be found on the list of tokens on our database then a user is trying to verify his mail 
function verifyUser($token){
	//we call our variable globally so that we can use it in this function
	global $conn;
	//we are looking for the token in our database and we want to find it only once
	$sql="SELECT * FROM users WHERE token='$token' LIMIT 1";
	$stmt=$conn->prepare($sql);
	$stmt->execute();
	$user=$stmt->fetch(PDO::FETCH_ASSOC);
	//if we get the result then we verify the user
	if ($stmt->rowCount()>0){
		//now we update the verified status of our user if the token corresponds to one user
		$update_query="UPDATE users SET verified=1 WHERE token='$token'";
		$stmt= $conn->prepare($update_query);
		if ($stmt->execute()){
			//si les conditions sont réunies, on log le user dans son compte Airball
			$_SESSION['id']=$user['id'];
			$_SESSION['username']=$user['username'];
			$_SESSION['email']=$user['email'];
			$_SESSION['veridied']=1;
			header('location:http://localhost:8888/airball/profile_pages/profile_joueur/profile_joueur.php');
			exit(0);
		}
	}
}
function verifyUserGestio($token){
	//we call our variable globally so that we can use it in this function
	global $conn;
	//we are looking for the token in our database and we want to find it only once
	$sql="SELECT * FROM users WHERE token='$token' LIMIT 1";
	$stmt=$conn->prepare($sql);
	$stmt->execute();
	$user=$stmt->fetch(PDO::FETCH_ASSOC);
	//if we get the result then we verify the user
	if ($stmt->rowCount()>0){
		//now we update the verified status of our user if the token corresponds to one user
		$update_query="UPDATE users SET verified=2 WHERE token='$token'";
		$stmt= $conn->prepare($update_query);
		if ($stmt->execute()){
			//si les conditions sont réunies, on log le user dans son compte Airball
			$_SESSION['id']=$user['id'];
			$_SESSION['username']=$user['username'];
			$_SESSION['email']=$user['email'];
			$_SESSION['veridied']=2;
			header('location:http://localhost:8888/airball/profile_pages/profile_gestio/profile_gestio.php');
			exit(0);
		}
	}
}

//in this part of the code, we are going to set the part where the user resets his password
//if the user clicks the forgot button then we reset the user's password
$errors_recover=array();
if(isset($_POST['forgot_btn'])){
	$email=$_POST['recover_email'];
	//we make sure that the email is good
	//if this statement is true then the mail provided by the user is invalid 
	if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$errors_recover['email']="Adresse mail non valide";
	}
	if(empty($email)){
		$errors_recover['email']="Email nécessaire";
	}
	//if there are no errors in what the user has written, then we are going to send an email to the user
	if(count($errors_recover)==0){
		//we select the user from the database that corresponds to the email adress
		$sql="SELECT * FROM users WHERE email='$email' LIMIT 1";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		$user=$stmt->fetch(PDO::FETCH_ASSOC);
		$token=$user['token'];
		sendPasswordResetLink($email,$token);
		header('location:http://localhost:8888/airball/password_change_pages/password_message.php');
		exit(0);
	}
}
//if the user clicks on the reset password button  then we take the information
if(isset($_POST['confirm_password'])){
	$reset_password=$_POST['new_password'];
	$reset_password_confirm=$_POST['confirm_new_password'];
	if(empty($reset_password) OR empty($reset_password_confirm)){
		$errors_recover['password']="Mot de passe nécessaire";
	}
	if(!empty($reset_password) AND !empty($reset_password_confirm) AND $reset_password!==$reset_password_confirm){
		$errors_recover['password']="Les mots de passe sont différents";
	}
	$reset_password=password_hash($reset_password,PASSWORD_DEFAULT); 
	$email=$_SESSION['email'];
	//now we update the passwords of the user in the database
	if(count($errors_recover)===0){
		//we we update our database
		$sql="UPDATE users SET user_password ='$reset_password' WHERE email='$email'";
		$stmt=$conn->prepare($sql);
		//now we apply our sql on our database
		if($stmt->execute()){
			header('location:http://localhost:8888/airball/basic_pages/index_airball.php');
			exit(0);
		}
	}
}
//we are going to use this funtion to reset the password of the user that has the token
function resetPassword($token){
	//we connect to the database
	global $conn;
	//now we select the user that correponds to the token on the link
	$sql="SELECT * FROM users WHERE token='$token' LIMIT 1";
	//this value corresponds to the result of our search anfd we grab the user that owns the token
	$stmt=$conn->prepare($sql);
	$stmt->execute();
	$user=$stmt->fetch(PDO::FETCH_ASSOC);
	//when the user resets his password, we redirect him to a form where he can reset his information
	$_SESSION['email']=$user['email'];
	header('location:http://localhost:8888/airball/password_change_pages/reset_password.php');
	exit(0);
}


$club_name="";
$club_email="";
$errors_club=array();
//in this part of the code, we are going to set the creation page of our admin user 
//we define the variables for our sign up
if (isset($_POST["sign_up_btn_club"])) {
	$club_name=$_POST['club_name'];
	$club_email=$_POST['club_email'];
	$club_password=$_POST['club_password'];
	$club_password_confirm=$_POST['club_password_confirm'];
	if(empty($club_name) OR empty($club_email) OR empty($club_password OR $club_password_confirm)){
		$errors_club['vide']="Veuillez renseigner tous les champs";
	}
	//we make sure that the email is good
	//if this statement is true then the mail provided by the user is invalid 
	if (!filter_var($club_email,FILTER_VALIDATE_EMAIL)) {
		$errors_club['email']="Adresse mail non valide";
	}
	//we check if the mail used to create has not been used already
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
	$stmt->execute([$club_email]); 
	$user = $stmt->fetch();
	if ($user) {
		$errors_club['email']="Email existe déjà";
	}
	//now before processing the registration of the new user, we will check if the information he wrote is correct
	if (count($errors_club)===0 && $club_password==$club_password_confirm) {
		//if there are no errors, now we can save the user's information
	    // we encrypt his password so it cant be seen in the database
		$club_password=password_hash($club_password,PASSWORD_DEFAULT);
		//these two variables will help us verify the email of a person
		$token=bin2hex(random_bytes(50));
		$verified=0;
		//now we insert the users info in our database
		$sql = "INSERT INTO users (username, email, user_password, verified, token) VALUES (?,?,?,?,?)";
		$stmt= $conn->prepare($sql);
		$stmt->execute([$club_name,$club_email,$club_password,$verified,$token]);
		if ($stmt->rowCount() >= 1) {
		//We log the new user into his profile page
		$user_id=$conn->insert_id;
		//now in order to log the verify the user on our website,we will send him a verification mail
		sendVerificationEmailGestio($club_email,$token);
		header('location:http://localhost:8888/airball/profile_pages/profile_not_verified.php');
		exit();
		} else {
		$errors_sign_up['login_error']="Erreur connexion";
		}
	}
	else{
		$errors_sign_up['password_error']="Les mots de passe sont différents";
	}
}

//-------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------------------------//

$errors_club=array();
$nom="";
$prenom="";
$age="";
$naissance="";
$addresse="";
//in this part of the code we will retrieve the values entered by the user when he is entering his information
if (isset($_POST['valider_edit_btn'])) {
	//if the user presses the button,then we take the information
	$nom=$_POST['edit_nom'];
	$prenom=$_POST['edit_prenom'];
	$age=$_POST['edit_age'];
	$naissance=$_POST['edit_naissance'];
	$addresse=$_POST['edit_addresse'];
	$id_user=$_SESSION['id'];
	if(empty($nom) OR empty($prenom) OR empty($addresse) OR empty($age) OR empty($naissance)){
		$errors_club['vide']="Veuillez renseigner tous les champs";
	}
	if (count($errors_club)==0) {
		//we dont want our users to have multiple profile informations for our user,only one row
		//so before adding a new row with the information that he entered, we are going to delete the last one
		$sql = "DELETE FROM profile_joueur WHERE id_user = :id_user";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id_user', $id_user);
        $stmt->execute();
		//that means that the user has entered all of his values
		//we are going to save them in the profile table of our database user-verfication
		$sql = "INSERT INTO profile_joueur(nom,prenom,age,naissance,addresse,id_user) VALUES (?,?,?,?,?,?)";
		$stmt= $conn->prepare($sql);
		$stmt->execute([$nom,$prenom,$age,$naissance,$addresse,$id_user]);
		//also if the user updates his profile threw the form, we are going to update the session with the values that he has entered
		//so that he can visualize the new result
		//we get the profile information of our user
		// select a particular user by id
		$stmt = $conn->prepare("SELECT * FROM profile_joueur WHERE id_user=:id");
		$stmt->execute(['id' => $_SESSION['id']]); 
		$user_profile = $stmt->fetch();
		$_SESSION['nom']=$user_profile['nom'];
		$_SESSION['prenom']=$user_profile['prenom'];
		$_SESSION['age']=$user_profile['age'];
		$_SESSION['naissance']=$user_profile['naissance'];
		$_SESSION['addresse']=$user_profile['addresse'];
	}
}
//in this part we destroy the session if the user logs out
if (isset($_POST['logout'])) {
	session_destroy();
	header('location:http://localhost:8888/airball/basic_pages/index_airball.php');
}

