<?php require_once("../style_connect/controller/connect_airball.php");?>
<?php
//in this part of the code we check on the link of the page if the token is there, in other words we are trying to see if the index page we
//are on has been opened from a verification mail, if it is the case then we are going to confirm the mail of the new user
if(isset($_GET['token'])){
    $token=$_GET['token'];
    verifyUser($token);
}
if(isset($_GET['tokenGestio'])){
    $token=$_GET['tokenGestio'];
    verifyUserGestio($token);
}
//in this part of the code we check on the link of the page if the password token is there
//if the password token is in the link, then we know that the user is trying to reset his password
if(isset($_GET['password-token'])){
    $PasswordToken=$_GET['password-token'];
    resetPassword($PasswordToken);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost:8888/airball/style_connect/styles/style_index.css">
    <title>Document</title>
</head>
<body>
    <div class="nav_pc">
        <h1><a href="http://localhost:8888/airball/basic_pages/index_airball.php"><img src="../style_connect/styles/img/airball.png" width="160" height="60" alt="Infinite Measures"></a></h1>
        <ul class="nav_bar_pc">
            <li><a href="http://localhost:8888/airball/basic_pages/index_airball.php">Accueil</a>
                <div></div>
            </li>
            <li><a href="#">Notre produit</a>
                <div></div>
            </li>
            <li><a href="http://localhost:8888/airball/basic_pages/FAQ.php">FAQ</a>
                <div></div>
            </li>
            <li><a href="http://localhost:8888/airball/basic_pages/mon_club.php">Inscrire mon club</a>
                <div></div>
            </li>
        </ul>
        <button type="button" class="button"><a href="#">S'authentifier</a></button>
    </div>
    <div class="overlay open">
        <div class="connection">
            <div class="form sign_up">
                <form action="index_airball.php" method="post">
                    <h1>S'inscrire</h1>
                    <input type="text" placeholder="Nom" name="new_user_name" value="<?php echo $new_user_name; ?>">
                    <input type="email" placeholder="Email" name="new_user_email" value="<?php echo $new_user_email; ?>">
                    <input type="password" placeholder="Mot de passe" name="new_user_password">
                    <input type="password" placeholder="Confirmer mot de passe" name="new_user_password_confirm">
                    <button type="submit" name="sign_up_btn">S'inscrire</button>
                    <?php if (count($errors_sign_up)>0):?>
                        <?php foreach($errors_sign_up as $error): ?>
                        <li class="alert"><?php echo $error; ?></li>
                        <?php endforeach;?>
                    <?php endif ;?>    
                </form>
            </div>
            <div class="form sign_in">
                <form action="index_airball.php" method="POST">
                    <h1>Se connecter</h1>
                    <input type="text" placeholder="Email ou Nom d'utilisateur" name="user_name">
                    <input type="password" placeholder="Mot de passe" name="user_password">
                    <a href="http://localhost:8888/airball/password_change_pages/forgot_password.php">Mot de passe oublié?</a>
                    <button type="submit" name="sign_in_btn">Se connecter</button>
                    <?php if (count($errors_sign_in)>0):?>
                        <?php foreach($errors_sign_in as $error): ?>
                        <li class="alert"><?php echo $error; ?></li>
                        <?php endforeach;?>
                    <?php endif ;?>  
                </form>
            </div>
            <div class="panel_container">
                <div class="panels">
                    <div class="panel right">
                        <h1>Bienvenue</h1>
                        <p>Afin de vous inscrire veuillez renseigner vos informations</p>
                        <button id="signUp">S'inscrire</button>
                    </div>
                    <div class="panel left">
                        <h1>Bonjour</h1>
                        <p>Ravie de vous revoir, veuillez rentrer vos informations afin de vous connecter</p>
                        <button id="signIn">Se connecter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero">
        <div class="hero1">
            <h1>Bienvenue sur le site d'Airball</h1>
            <p>Chez INFINITE MEASURES nous sommes très concernés par le bien être des basketteurs. Retrouvez sur notre site les différents tests psychotehcniques effectués sur notre produit.

            Que vous soyez coach d’une équipe ou bien joueur vous pourrez créer un compte aisément et accéder à vos statistiques.

            Vous pouvez ainsi consulter : 
            le rythme cardiaque 
            la température et la sueur du corps lors de l’effort
            le temps de réaction au sifflet de l’arbitre lors des différentes phases de jeu
            </p>
        </div>
    </div>
    <div class="footer">
        <p>&copy;2021 By Airball</p>
    </div>
    <script src="style_connect/styles/js/script_airball.js"></script>
</body>
</html>