<?php
ini_set('display_errors', 1);

$idajax = intval($_GET['idajax']);
$action = intval($_GET['action']);

$servername          = "localhost";
$username             = "root";
$password             = "root";
$db                    = "user-verification";

$conn = new mysqli($servername, $username, $password, $db);

$sql = "SELECT * FROM profile_joueur WHERE id_user = '" . $idajax . "'";

$result = mysqli_query($conn, $sql);

if ($action == 0) { // affichage de la modification
    echo '<div class = "modify" style ="width:100%">';
    echo '<form action = "modifyuser.php" method="post" class = "modify" style ="width:100%">';
    echo '<table style="width:100%">';
    while ($row = $result->fetch_assoc()) {

        $field1 = $row["id_user"];
        $field4 = $row["nom"];
        $field5 = $row["prenom"];
        $field6 = $row["age"];
        $field8 = $row["addresse"];

        $table1 = '<tr><th>' . 'identifiant' . '	        	</th><td>' . $field1 . ' <input type= "hidden" name="idchange" value ="' . $field1 . '"> </td></tr>
                                        <tr><th>nom             </th><td><input class="textinputmod" type= "text" name="nomchange" 	        placeholder = "nom"	 value ="' . $field4 . '"></td></tr>
                                        <tr><th>prenom          </th><td><input class="textinputmod" type= "text" name="prenomchange" 	    placeholder = "prenom" 			 value ="' . $field5 . '"></td></tr>
										<tr><th>age 	        </th><td><input class="textinputmod" type= "text" name="agechange" 		placeholder = "age" 		 value ="' . $field6 . '"></td></tr>
                                        <tr><th>addresse 	    </th><td><input class="textinputmod" type= "text" name="addresschange" 		placeholder = "addresse" 		 value ="' . $field8 . '"></td></tr>
                                        <tr><td> <input style = "background: red" type = "button" value="annuler" class = "homebutton" onclick = "cancelmodify()">	</td><td><input type= "submit" value ="modifier" class = "homebutton"></td></tr>';
        ';';
        echo ($table1);
    }
    echo "</table>";
    echo "</form>";
    echo "</div>";
} else if ($action == 1) { // affichage de la suppression
    echo '<div class = "modify" style ="width:100%">';
    echo '<form action = "deleteuser.php" method="post" class = "modify" style ="width:100%">';
    echo '<table style="width:100%">';
    while ($row = $result->fetch_assoc()) {

        $field1 = $row["id_user"];
        $field2 = $row["nom"];
        $field3 = $row["prenom"];

        $table = '<tr><th>identifiant	</th><td>' . $field1 . ' <input type= "hidden" name="idchange" value ="' . $field1 . '"> </td></tr>
										<tr><th>nom</th><td>' . $field2 . ' </td></tr>
										<tr><th>prenom</th><td>' . $field3 . ' </td></tr>
										<tr><td> <input style = "background: red" type = "button" value="annuler" class = "homebutton" onclick = "cancelmodify()">	</td><td><input type= "submit" value ="supprimer" class = "homebutton"></td></tr>';
        echo $table;
    }
    echo "</table>";
    echo "</form>";
    echo "</div>";
} else { //affichage du message d'erreur
    echo "erreur";
}

mysqli_close($conn);
