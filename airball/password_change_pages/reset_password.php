<?php require_once("../style_connect/controller/connect_airball.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="http://localhost:8888/airball/style_connect/styles/style_password.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation mot de passe</title>
</head>
<body>
    <div class="forgot_password">
        <form action="reset_password.php" method="post">
            <h1>Changement du mot de passe</h1>
            <input type="password" placeholder="Nouveau mot de passe" name="new_password">
            <input type="password" placeholder="Confirmer nouveau mot de passe" name="confirm_new_password">
            <button type="submit" name="confirm_password">Réinitialiser mon mot de passe</button>
            <?php if (count($errors_recover)>0):?>
                <?php foreach($errors_recover as $error): ?>
                <li class="alert"><?php echo $error; ?></li>
                <?php endforeach;?>
            <?php endif ;?> 
        </form>
    </div>
</body>
</html>