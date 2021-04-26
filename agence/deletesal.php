<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['NumSalarie']) && !empty($_GET['NumSalarie'])){
    require_once('connect.php');

    // On nettoie le numéro d'agence envoyé
    $NumSalarie = strip_tags($_GET['NumSalarie']);

    $sql = 'SELECT * FROM `salarie` WHERE `NumSalarie` = :NumSalarie;'; 
    // and `CodeService` = :CodeService;';

    //On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre 
    $query->bindValue(':NumSalarie', $NumSalarie, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $CodeService = $query->fetch();

    // On vérifie si le produit existe
    if(!$CodeService){
        $_SESSION['erreur'] = "Ce numéro de salarie n'existe pas";
        header('Location: indexsal.php');
        die();
    }

    $sql = 'DELETE FROM `salarie` WHERE `NumSalarie` = :NumSalarie;'; //AND `CodeService` = :CodeService;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre 
    $query->bindValue(':NumSalarie', $NumSalarie, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    $_SESSION['message1'] = "Salarié supprimé";
    header('Location: indexsal.php');


}else{
    $_SESSION['erreur1'] = "URL invalide";
    header('Location: indexsal.php');
}