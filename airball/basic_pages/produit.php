<?php require_once("../style_connect/controller/connect_airball.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:8888/airball/style_connect/styles/style_contact.css">
    <title>Document</title>
</head>
<body>
    <div class="nav_pc">
        <h1><a href="http://localhost:8888/airball/basic_pages/index_airball.php"><img src="../style_connect/styles/img/airball.png" width="160" height="60" alt="Infinite Measures"></a></h1>
        <ul class="nav_bar_pc">
            <li><a href="http://localhost:8888/airball/basic_pages/index_airball.php">Accueil</a>
                <div></div>
            </li>
            <li><a href="http://localhost:8888/airball/basic_pages/produit.php">Notre produit</a>
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
    <div class="contact">
        <form action="produit.php" method="post">
        <input type="text" name="contact_prenom" placeholder="Veuillez rentrer votre prénom">
        <input type="text" name="contact_nom" placeholder="Veuillez rentrer votre nom">
        <textarea name="contact_sujet" placeholder="Posez nous une question" ></textarea>
        <button type="submit" name="valider_support_btn">Soumettre</button> 
        <?php if (count($errors_contact)>0):?>
                <?php foreach($errors_contact as $error): ?>
                <li class="alert"><?php echo $error; ?></li>
                <?php endforeach;?>
            <?php endif ;?>  
        </form>
    </div>
    <div class="footer">
        <p>&copy;2021 By Airball</p>
    </div>
</body>