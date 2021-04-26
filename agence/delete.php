<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['NumAgence']) && !empty($_GET['NumAgence'])){
    require_once('connect.php');

    // On nettoie le numéro d'agence envoyé
    $NumAgence = strip_tags($_GET['NumAgence']);

    $sql = 'SELECT * FROM `Agence` WHERE `NumAgence` = :NumAgence;'; 
    // and `CodeService` = :CodeService;';

    //On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre 
    $query->bindValue(':NumAgence', $NumAgence, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $CodeService = $query->fetch();

    // On vérifie si le produit existe
    if(!$CodeService){
        $_SESSION['erreur'] = "Ce numéro d'agence n'existe pas";
        header('Location: index.php');
        die();
    }

    $sql = 'DELETE FROM `Service` WHERE `NumAgence` = :NumAgence;'; //AND `CodeService` = :CodeService;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre 
    $query->bindValue(':NumAgence', $NumAgence, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    $_SESSION['message'] = "Service supprimé";
    header('Location: index.php');


}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
