<?php require_once("../../style_connect/controller/connect_airball.php");?>
<?php
session_start();
?>
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
    <div class="header">
        <h1><a href="http://localhost:8888/airball/basic_pages/index_airball.php"><img src="http://localhost:8888/airball/style_connect/styles/img/airball.png" width="115" height="110" alt="Infinite Measures"></a></h1>
        <div class="links">
            <a href="http://localhost:8888/airball/profile_pages/profile_joueur/profile_joueur.php">Page profil</a>
            <a href="http://localhost:8888/airball/basic_pages/index_airball.php" name="logout">Me déconnecter</a>
        </div>
    </div>
    <div class="club">
        <form action="edit_profile_joueur.php" method="post">
           <h1>Éditer mon profil</h1>
           <input type="text" placeholder="Nom" name="edit_nom">
           <input type="text" placeholder="Prénom" name="edit_prenom">
           <input type="text" placeholder="Âge" name="edit_age">
           <input type="text" placeholder="Addresse" name="edit_addresse">
           <input type="number" placeholder="Taille en cm" name="edit_taille">
           <button type="submit" name="valider_edit_btn">Valider profil</button> 
           <?php if (count($errors_edit)>0):?>
                <?php foreach($errors_edit as $error): ?>
                <li class="alert"><?php echo $error; ?></li>
                <?php endforeach;?>
            <?php endif ;?>    
       </form>
    </div>
    <div class="footer">
        <p>&copy;2021 By Airball</p>
    </div>
</body>
</html>