<?php
try{
    //connexion à la base
    $db = new PDO('mysql:host=localhost;dbname=agence', 'root', 'root');
    $db->exec('SET NAMES "UTF8"');

} catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage();
    die();
}