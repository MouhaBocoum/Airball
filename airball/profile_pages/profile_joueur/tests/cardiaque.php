<?php require_once("../../../style_connect/controller/connect_airball.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:8888/airball/style_connect/styles/style_test.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="header">
        <h1><a href="http://localhost:8888/airball/basic_pages/index_airball.php"><img src="http://localhost:8888/airball/style_connect/styles/img/airball.png" width="115" height="110" alt="Infinite Measures"></a></h1>
        <h1>Tests fréquence cardiaque</h1>
        <div class="links">
            <a href="http://localhost:8888/airball/profile_pages/profile_joueur/profile_joueur.php">Mon profil</a>
            <a href="http://localhost:8888/airball/basic_pages/index_airball.php" name="logout">Me déconnecter</a>
        </div>
    </div>
    <div class="container">
        <div class="resultats_test">
            <canvas id="myChart"  width="400" height="92"></canvas>
            <script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [<?php echo $test_dates_cardiaque?>],
                        datasets: [{
                            label: 'Résultats tests fréquence cardiaque',
                            data: [<?php echo $resultats_cardiaque?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>
        <div class="down_panel">
            <div class="repartition_test">
                <canvas id="myChart1"  width="400" height="120"></canvas>
                <script>
                    var ctx = document.getElementById('myChart1').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Frequence Cardiaque','Reflexe','Reconnaissance','Temperature'],
                            datasets: [{
                                label: 'Répartition des tests',
                                data: [<?php echo $nombre_tests_cardiaque ?>,<?php echo $nombre_tests_reflexe ?>, <?php echo $nombre_tests_reconnaissance ?>, <?php echo $nombre_tests_temperature ?>],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>
            <div class="input_value">   
                <h3>Rentrez vos résultats</h3>
                <form action="cardiaque.php" method="post">
                    <input type="number" placeholder="Nouveau résultat" name="test_result">
                    <input type="date" placeholder="Rentrer la date du test" name="test_date">
                    <button type="submit" name="valider_test_result_cardiaque">Valider résultat</button>    
                    <?php if (count($errors_test)>0):?>
                        <?php foreach($errors_test as $error): ?>
                        <li class="alert"><?php echo $error; ?></li>
                        <?php endforeach;?>
                    <?php endif ;?>   
                </form>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>&copy;2021 By Airball</p>
    </div>
</body>
</html>