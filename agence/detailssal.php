<?php
//On démarre une session
session_start();

// Est-ce que le numagence existe et n'est pas vide dans l'URL
if(isset($_GET['NumSalarie']) && !empty($_GET['NumSalarie'])){
    require_once('connect.php');
    // On nettoie l'id envoyé
    $NumSalarie = strip_tags($_GET['NumSalarie']);

    $sql = 'SELECT * FROM `Salarie` WHERE `NumSalarie` = :NumSalarie;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':NumSalarie', $NumSalarie, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le service
    $CodeService = $query->fetch();

    // On vérifie si le service existe
    if(!$CodeService){
        $_SESSION['erreur'] = "Ce salarie n'existe pas";
    }
}
    else{
        $_SESSION['erreur'] = "URL invalide";
        header('Location: index.php');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du salarie</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails salariés <?= $CodeService['CodeService'] ?></h1>
                <p>NumSalarie : <?= $CodeService['NumSalarie'] ?></p>
                <p>CodeService : <?= $CodeService['CodeService'] ?></p>
                <p>NumAgence : <?= $CodeService['NumAgence'] ?></p>
                <p>NomSalarie : <?= $CodeService['NomSalarie'] ?></p>
                <p>PrenomSalarie : <?= $CodeService['PrenomSalarie'] ?></p>
                <p>AdrSalarie : <?= $CodeService['AdrSalarie'] ?></p>
                <p>CpSalarie : <?= $CodeService['CpSalarie'] ?></p>
                <p>VilleSalarie : <?= $CodeService['VilleSalarie'] ?></p>
                <p>TelSalarie : <?= $CodeService['TelSalarie'] ?></p>
                <p>MailSalarie : <?= $CodeService['MailSalarie'] ?></p>
                <p><a href="index.php">Retour</a> <a href="edit.php?id=<?= $CodeService['NumSalarie'] ?>">Modifier</a></p>
            </section>
        </div>
    </main>
</body>
</html>