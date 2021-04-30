<?php require_once("../style_connect/controller/connect_airball.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:8888/airball/style_connect/styles/style_profile.css">
    <title>Document</title>
</head>
<body>
    <div class="log_in">
    <!--THIS PART OF THE CODE CORRESPONDS TO THE PROFILE OF A NOT VERIFIED USER-->
        <h1>Bonjour,<?php echo $_SESSION['username']?></h1>
        <h2>Merci d'avoir créer un compte chez Airball</h2>
        <h3>Afin de vérifier votre compte, veuillez cliquez sur le lien de vérification que nous vous avons envoyez par mail à: <?php echo $_SESSION['email']; ?></h3>
        <a href="http://localhost:8888/airball/basic_pages/index_airball.php">Déconnexion</a>
    </div>
</body>
</html>