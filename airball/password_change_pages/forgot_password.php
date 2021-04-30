<?php require_once("../style_connect/controller/connect_airball.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="http://localhost:8888/airball/style_connect/styles/style_password.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="forgot_password">
        <form action="forgot_password.php" method="post">
            <h1>Récupération mot de passe</h1>
            <input type="text" placeholder="Email" name="recover_email">
            <button type="submit" name="forgot_btn">Envoie mail</button>
            <?php if (count($errors_recover)>0):?>
                <?php foreach($errors_recover as $error): ?>
                <li class="alert"><?php echo $error; ?></li>
                <?php endforeach;?>
            <?php endif ;?> 
        </form>
    </div>
</body>
</html>