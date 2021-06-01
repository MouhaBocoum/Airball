<?php require_once("traitement.php");?>
<!DOCTYPE html>
<head>
	<link rel="stylesheet" href="style.css">
	<title>Evaluations CE1</title> 
</head>
<body>
    <section class="quiz">
        <form action="index.php" method="POST"> 
        <?php 
          if (isset($_GET['message']) && $_GET['message']==true)
          {
          ?>
          <p class="message"> N'oublie pas d'écrire ton nom.</p>
          <?php } ?>

          <?php 
          if (isset($_GET['score'])){
          ?>
          <p class="message"> Ton score est de : <?php echo $_GET['score']; ?> , essaie encore !<?php }?></p> 
          
          <label for="nom">Prénom et nom: </label><br>
          <input type="text" id="nom" name="nom" value="<?php echo $_COOKIE['nom']?>" ><br><br>
          <fieldset>
          Dis si les phrases suivantes sont correctes :</br>
          <ul>
          <li> je suis en CE1 </li>
          </ul>
          <input type="radio" id="oui" name="phrase1" value="oui">
          <label for="oui">Oui</label><br>
          <input type="radio" id="non" name="phrase1" value="non">
          <label for="non">Non</label><br>

          <ul>
          <li> Je CE1 suis en. </li>
          </ul>
          <input type="radio" id="oui" name="phrase2" value="oui">
          <label for="oui">Oui</label><br>
          <input type="radio" id="non" name="phrase2" value="non">
          <label for="non">Non</label><br>

          <ul>
          <li> Je suis en CE1. </li>
          </ul>
          <input type="radio" id="oui" name="phrase3" value="oui">
          <label for="oui">Oui</label><br>
          <input type="radio" id="non" name="phrase3" value="non">
          <label for="non">Non</label>
          </fieldset>
          <br><br>
          <fieldset>

          Coche quand la pharse est interrogative :</br>
          
          Où est Brian ? <input type="checkbox" name="phrase4"> <br>
          Il pleut aujourd'hui. <input type="checkbox" name="phrase5"> <br>
          Quelle heure est-il ? <input type="checkbox" name="phrase6"> 
          </fieldset>
          <br><br>
          <input type="submit" value="Vérifier" name=verifier>
          <input type="reset" value="effacer les réponses" onclick="return confirm('Cliquer sur ok pour effacer vos réponses ');">

        </form>
    </section>

</body>
</html>