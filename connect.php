<?php
try{
    //Connexion à la base de donnée
    $db = new PDO('mysql: host=localhost;dbname=marketplace2', 'root','');
    $db->exec('SET NAMES "UTF8');
} catch(PDOException $e){
    echo 'Erreur :'. $e->getMessage();
    die();
}