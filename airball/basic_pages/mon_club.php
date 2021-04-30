<?php require_once("../style_connect/controller/connect_airball.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:8888/airball/style_connect/styles/style_password.css">
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
    </div>
    <div class="club">
        <form action="mon_club.php" method="post">
           <h1>Inscrire mon club</h1>
           <input type="text" placeholder="Nom Club" name="club_name" value="<?php echo $club_name?>">
           <input type="email" placeholder="Email" name="club_email" value="<?php echo $club_email?>">
           <input type="password" placeholder="Mot de passe" name="club_password">
           <input type="password" placeholder="Confirmer mot de passe" name="club_password_confirm">
           <button type="submit" name="sign_up_btn_club">S'inscrire</button> 
           <?php if (count($errors_club)>0):?>
                <?php foreach($errors_club as $error): ?>
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