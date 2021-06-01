<?php require_once("../../style_connect/controller/connect_airball.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:8888/airball/style_connect/styles/style_profile.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>Document</title>
</head>
<body>
    <div class="header">
        <h1><a href="http://localhost:8888/airball/basic_pages/index_airball.php"><img src="http://localhost:8888/airball/style_connect/styles/img/airball.png" width="115" height="110" alt="Infinite Measures"></a></h1>
        <div class="links">
            <a href="http://localhost:8888/airball/profile_pages/profile_joueur/edit_profile_joueur.php">Éditer mon profil</a>
            <a href="http://localhost:8888/airball/basic_pages/index_airball.php" name="logout">Me déconnecter</a>
        </div>
    </div>
    <div class="container">
        <div class="panel_joueur">
            <div class=info_joueur_left>
                <label for="prenom">Nom:</label>
                <h1><?php echo $_SESSION['nom']?></h1>
                <label for="nom">Prénom:</label>
                <h1><?php echo $_SESSION['prenom']?></h1>
                <label for="age">Âge:</label>
                <h1><?php echo $_SESSION['age']?> ans</h1>
                <label for="naissance">Nom de votre club:</label>
                <h1><?php echo $_SESSION['club']?></h1>
                <label for="addresse">Addresse:</label>
                <h1><?php echo $_SESSION['addresse']?></h1>
                <label for="taille">Taille:</label>
                <h1><?php echo $_SESSION['taille']?> cm</h1>
            </div>
        </div>
        <div class="info_joueur">
            <h1 class="hello">Bonjour,<?php echo $_SESSION['username']?></h1>
            <h1>Ici vous avez accés aux résultats de vos tests psychotechniques</h1>
            <div class="tests">
                <div class="test1">
                    <div class="cardiaque">
                        <h1>Fréquence cardiaque:</h1>
                        <a href="http://localhost:8888/airball/profile_pages/profile_joueur/tests/cardiaque.php"><i class="material-icons" style="font-size:150px;color:black;">favorite</i></a>
                    </div>
                    <div class="reflexe">
                        <h1>Réflexe sonore:</h1>
                        <a href="http://localhost:8888/airball/profile_pages/profile_joueur/tests/reflexe.php"><i class="material-icons" style="font-size:150px;;color:black;">touch_app</i></a>
                    </div>
                </div>
                <div class="test2">
                    <div class="temperature">
                        <h1>Température:</h1>
                        <a href="http://localhost:8888/airball/profile_pages/profile_joueur/tests/temperature.php"><i class="material-icons" style="font-size:150px;;color:black;">thermostat</i></a>
                    </div>
                    <div class="reconnaissance">
                        <h1>Reconnaissance sonore:</h1>
                        <a href="http://localhost:8888/airball/profile_pages/profile_joueur/tests/reconnaissance.php"><i class="material-icons" style="font-size:150px;;color:black;">record_voice_over</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>&copy;2021 By Airball</p>
    </div>
</body>
</html>