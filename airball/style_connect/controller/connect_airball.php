<?php

require_once 'mail.php';

session_start();
//we connect to the database
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','root');
define('DB_NAME', 'user-verification');
$conn=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if ($conn->connect_error) {
	die('Erreur connexion à la base de donnée'. $conn->connect_error);
}


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
	if(empty($new_user_name)){
		$errors_sign_up['username']="Nom d'utilisateur nécessaire";
	}
	if(empty($new_user_email)){
		$errors_sign_up['email']="Email nécessaire";
	}
	if(empty($new_user_password)){
		$errors_sign_up['password']="Mot de passe nécessaire";
	}
	if(empty($new_user_password_confirm)){
		$errors_sign_up['password']="Mot de passe nécessaire";
	}
	//we make sure that the email is good
	//if this statement is true then the mail provided by the user is invalid 
	if (!filter_var($new_user_email,FILTER_VALIDATE_EMAIL)) {
		$errors_sign_up['email']="Adresse mail non valide";
	}
	//we check if the mail used to create has not been used already
	$emailQuery= "SELECT * FROM users WHERE email=? LIMIT 1";
	$stmt= $conn->prepare($emailQuery);
	$stmt->bind_param('s',$new_user_email);
	$stmt->execute();
	$result=$stmt->get_result();
	$usercount=$result->num_rows;
	$stmt->close();
	if (usercount >0) {
		$errors_sign_up['email']="Email existe déjà";
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
		$sql = "INSERT INTO users (username, email, user_password, verified, token)
		VALUES ('$new_user_name', '$new_user_email', '$new_user_password', '$verified', '$token')";
		if ($conn->query($sql) === TRUE) {
		//We log the new user into his profile page
		$user_id=$conn->insert_id;
		$_SESSION['id']=$user_id;
		$_SESSION['username']=$new_user_name;
		$_SESSION['email']=$new_user_email;
		$_SESSION['veridied']=$verified;
		//now in order to log the verify the user on our website,we will send him a verification mail
		sendVerificationEmail($new_user_email,$token);
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

//IN THIS PART OF THE CODE WE HAVE THE FEATURES OF OUR SIGN IN PAGE
//we define the variables for our sign in
$errors_sign_in=array();
$user_name="";
$user_password="";
//we define the variables for our sign up
if (isset($_POST["sign_in_btn"])) {
	$user_name=$_POST['user_name'];
	$user_password=$_POST['user_password'];
	//we manage the possible errors from the user
	if(empty($user_name)){
		$errors_sign_in['username']="Email ou nom d'utilisateur nécessaire";
	}
	if(empty($user_password)){
		$errors_sign_in['password']="Mot de passe nécessaire";
	}
	//now before processing the registration of the new user, we will check if the information he wrote is correct
	if (count($errors_sign_in)==0) {
		//if there are no errors, now we can save the user's information
		//we check if the written email or username is valid
		$sql="SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
		$stmt=$conn->prepare($sql);
		$stmt->bind_param('ss',$user_name,$user_name);
		$stmt->execute();
		$result=$stmt->get_result();
		$user=$result->fetch_assoc();
		//now we check if the password is valid
		if (password_verify($user_password,$user['user_password']) AND $user['verified']==1) { 
			//We log the new user into his profile page
			$_SESSION['id']=$user['id'];
			$_SESSION['username']=$user['username'];
			$_SESSION['email']=$user['email'];
			$_SESSION['veridied']=$user['verified'];
			header('location:http://localhost:8888/airball/profile_pages/profile_joueur/profile_joueur.php');
			exit();
		}
		elseif (password_verify($user_password,$user['user_password']) AND $user['verified']==2) { 
			//We log the new user into his profile page
			$_SESSION['id']=$user['id'];
			$_SESSION['username']=$user['username'];
			$_SESSION['email']=$user['email'];
			$_SESSION['veridied']=$user['verified'];
			header('location:http://localhost:8888/airball/profile_pages/profile_gestio/profile_gestio.php');
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
	$result=mysqli_query($conn,$sql);
	//if we get the result then we verify the user
	if (mysqli_num_rows($result)>0){
		$user=mysqli_fetch_assoc($result);
		//now we update the verified status of our user if the token corresponds to one user
		$update_query="UPDATE users SET verified=1 WHERE token='$token'";
		if(mysqli_query($conn,$update_query)){
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
	$result=mysqli_query($conn,$sql);
	//if we get the result then we verify the user
	if (mysqli_num_rows($result)>0){
		$user=mysqli_fetch_assoc($result);
		//now we update the verified status of our user if the token corresponds to one user
		$update_query="UPDATE users SET verified=2 WHERE token='$token'";
		if(mysqli_query($conn,$update_query)){
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
		$result=mysqli_query($conn,$sql);
		$user=mysqli_fetch_assoc($result);
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
	if($reset_password!==$reset_password_confirm){
		$errors_recover['password']="Les mots de passe sont différents";
	}
	$reset_password=password_hash($reset_password,PASSWORD_DEFAULT); 
	$email=$_SESSION['email'];
	//now we update the passwords of the user in the database
	if(count($errors_recover)===0){
		//we we update our database
		$sql="UPDATE users SET user_password ='$reset_password' WHERE email='$email'";
		//now we apply our sql on our database
		$result=mysqli_query($conn,$sql);
		if($result){
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
	$result=mysqli_query($conn,$sql);
	$user=mysqli_fetch_assoc($result);
	//when the user resets his password, we redirect him to a form where he can reset his information
	$_SESSION['email']=$user['email'];
	header('location:http://localhost:8888/airball/password_change_pages/reset_password.php');
	exit(0);
}

$club_name="";
$club_email="";
$errors_club=array();
//in this part of the code, we are going to set the creation page of our admin user 
if(isset($_POST['sign_up_btn_club'])){
	$club_name=$_POST['club_name'];
	$club_email=$_POST['club_email'];
	$club_password=$_POST['club_password'];
	$club_password_confirm=$_POST['club_password_confirm'];
	if(empty($club_name)){
		$errors_club['name']="Veuillez rentrer le nom de votre club";
	}
	if(empty($club_email)){
		$errors_club['email']="Veuillez rentrer l'addresse mail de votre club";
	}
	if(empty($club_password OR $club_password_confirm)){
		$errors_club['password']="Veuillez rentrer un mot de passe";
	}
	//we make sure that the email is good
	//if this statement is true then the mail provided by the user is invalid 
	if (!filter_var($club_email,FILTER_VALIDATE_EMAIL)) {
		$errors_club['email']="Adresse mail non valide";
	}
	//we check if the mail used to create has not been used already
	$emailQuery= "SELECT * FROM users WHERE email=? LIMIT 1";
	$stmt= $conn->prepare($emailQuery);
	$stmt->bind_param('s',$new_user_email);
	$stmt->execute();
	$result=$stmt->get_result();
	$usercount=$result->num_rows;
	$stmt->close();
	if (usercount >0) {
		$errors_club['email']="Email existe déjà";
	}
	//now before processing the registration of the new user, we will check if the information he wrote is correct
	if (count($errors_club)===0 AND $club_password==$club_password_confirm) {
		$club_password=password_hash($club_password,PASSWORD_DEFAULT);
		//if there are no errors, now we can save the user's information
		//these two variables will help us verify the email of a person
		$token=bin2hex(random_bytes(50));
		$verified=0;
		//now we insert the users info in our database
		$sql = "INSERT INTO users (username, email, user_password, verified, token)
		VALUES ('$club_name', '$club_email', '$club_password', '$verified', '$token')";
		if ($conn->query($sql) === TRUE) {
		//We log the new user into his profile page
		$user_id=$conn->insert_id;
		$_SESSION['id']=$user_id;
		$_SESSION['username']=$club_name;
		$_SESSION['email']=$club_email;
		$_SESSION['veridied']=$verified;
		//now in order to log the verify the user on our website,we will send him a verification mail
		sendVerificationEmailGestio($club_email,$token);
		header('location:http://localhost:8888/airball/profile_pages/profile_not_verified.php');
		exit();
		} else {
		$errors_club['login_error']="Erreur connexion";
		}
	}
}