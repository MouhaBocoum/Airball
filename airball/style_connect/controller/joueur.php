<?php

try {
    $conn = new PDO('mysql:host=localhost;dbname=user-verification', 'root', 'root');
} catch (PDOException $e){
    exit("Database error.");
}
