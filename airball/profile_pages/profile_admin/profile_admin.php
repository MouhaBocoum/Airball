<?php require_once("../../style_connect/controller/connect_airball.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:8888/airball/style_connect/styles/style_gest_admin.css">
    <title>Document</title>
</head>

<body>
    <div class="header">
        <h1><a href="http://localhost:8888/airball/basic_pages/index_airball.php"><img src="http://localhost:8888/airball/style_connect/styles/img/airball.png" width="115" height="110" alt="Infinite Measures"></a></h1>
        <div class="links">
            <a href="http://localhost:8888/airball/basic_pages/index_airball.php" name="logout">Me déconnecter</a>
        </div>
    </div>
    <div class="container">
        <!--THIS PART OF THE CODE CORRESPONDS TO THE PROFILE OF A VERIFIED USER-->
        <h1 class="title">Bonjour, bienvenue sur votre compte administrateur</h1>
        <html class="listusers">
        <h1 class="title">Liste joueurs</h1>
        <form action="" method="post">
            <div class="tbl-header">
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th class="col">identifiant <br> <input type="text" class="searchbars" name="idsearch" value=<?php if (isset($_POST["idsearch"]))     echo $_POST["idsearch"];      ?>></th>
                            <th class="col">prénom <br> <input type="text" class="searchbars" name="prenomsearch" value=<?php if (isset($_POST["prenomsearch"])) echo $_POST["prenomsearch"]; ?>></th>
                            <th class="col">nom <br> <input type="text" class="searchbars" name="nomsearch" value=<?php if (isset($_POST["nomsearch"]))    echo $_POST["nomsearch"];    ?>></th>
                            <th class="col">login <br> <input type="text" class="searchbars" name="idusearch" value=<?php if (isset($_POST["idusearch"]))    echo $_POST["idusearch"];    ?>></th>

                            <th> <input type="submit" style="height : 47px;" value='rechercher' class="searchbutton"></th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div>

            </div>

        </form>

        <div class="tbl-content">
            <?php
            ini_set('display_errors', 0);

            //var_dump($_SESSION);


            //var_dump($_POST);

            $idsearch         = $_POST['idsearch'];
            $prenomsearch     = $_POST['prenomsearch'];
            $nomsearch        = $_POST['nomsearch'];
            $idusearch        = $_POST['idusearch'];

            $servername       = "localhost";
            $username         = "root";
            $password         = "root";
            $db               = "user-verification";

            $conn = new mysqli($servername, $username, $password, $db);

            $sql = "SELECT *
            FROM profile_joueur
            INNER JOIN users ON profile_joueur.id_user=users.id
            
            where users.id like '$idsearch%'
            and profile_joueur.prenom like '$prenomsearch%' 
            AND profile_joueur.nom like '$nomsearch%' 
            AND users.username like '$idusearch%'";

            if (empty($_POST)) {
                $sql = "SELECT *
            FROM profile_joueur
            INNER JOIN users ON profile_joueur.id_user=users.id";
            }
            //var_dump($_POST);
            //echo ($sql);

            #$stmt = $conn->prepare($sql);
            #$stmt->execute(array(':prenomsearch' => $prenomsearch, ':nomsearch' => $nomsearch, ':idusearch' => $idusearch, ':club' => $_SESSION['club']));
            #$user = $stmt->fetch();


            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table cellpadding='5' cellspacing='0' border='0'>";
                echo "<tbody id = 'mytable'>";

                while ($row = $result->fetch_assoc()) {

                    //var_dump($row);

                    $field1 = $row["id"];
                    $field2 = ucfirst($row['prenom']);
                    $field3 = ucfirst($row['nom']);
                    $field4 = $row["username"];
                    $field5 = $row["age"];
                    $field7 = $row["addresse"];
                    $field8 = $row["taille"];
                    $field9 = $row["email"];


                    echo '<tr>
										<td data-label="identifiant">' . $field1 . '</td>
										<td data-label="Prenom">' . $field2 . '</td>
										<td data-label="Nom">' . $field3 . '</td>
										<td data-label="Login">' . $field4 . '</td>
										<td data-label="Mail">' . $field5 . '</td>
										<td data-label="Type">' . $field6 . '</td>
                                        <td data-label="Type">' . $field7 . '</td>
                                        <td data-label="Type">' . $field8 . '</td>
                                        <td data-label="Type">' . $field9 . '</td>
										<td class="interact">
											<input type = "submit" name = "' . $field1 . '" value="modifier" class = "homebutton" href="#modifyajax" onclick="showUser(this.name,0);">
											<input style = "background:red;" type = "submit" name = "' . $field1 . '" value="supprimer" class = "homebutton" href="#lecons" onclick="showUser(this.name,1);">
										</td>
							</tr>';
                }

                echo "</table>";
            } else {
                echo "<h> aucun résultat </h>";
            }

            $conn->close();

            ?>
        </div>


        <div class="modifyajax" id="modifyajax"></div>

        </html>

        <script>
            function showUser(str, a) {
                console.log(str, a);

                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("modifyajax").innerHTML = this.responseText;
                    }
                };

                xhttp.open("GET", "getuser.php?idajax=" + str + "&action=" + a, true);
                xhttp.send();
            }

            function cancelmodify() {
                document.getElementById("modifyajax").innerHTML = "";
            }
        </script>
    </div>
</body>

</html>