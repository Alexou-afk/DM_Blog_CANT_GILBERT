<?php 
//On démarre une session
session_start();
if($_POST){
    if(isset($_POST['NumAgence']) && !empty($_POST['NumAgence'])
    && isset($_POST['CodeService']) && !empty($_POST['CodeService'])
    && isset($_POST['NumSalarie']) && !empty($_POST['NumSalarie'])
    && isset($_POST['NomService']) && !empty($_POST['NomService'])){
        // on inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $NumAgence = strip_tags($_POST['NumAgence']);
        $CodeService = strip_tags($_POST['CodeService']);
        $NumSalarie = strip_tags($_POST['NumSalarie']);
        $NomService = strip_tags($_POST['NomService']);

        $sql = 'UPDATE `service` SET (`CodeService`=:CodeService, `NumSalarie`=:NumSalarie, `NomService`=:NomService) WHERE `NumAgence` = :NumAgence;';

        $query = $db->prepare($sql);

        $query->bindValue(':NumAgence', $NumAgence, PDO::PARAM_INT);
        $query->bindValue(':CodeService', $CodeService, PDO::PARAM_INT);
        $query->bindValue(':NumSalarie', $NumSalarie, PDO::PARAM_INT);
        $query->bindValue(':NomService', $NomService, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "CodeService modifié";
        require_once('close.php');

        header('Location: index.php');

    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}
// Est-ce que le numagence existe et n'est pas vide dans l'URL
if(isset($_GET['NumAgence']) && !empty($_GET['NumAgence'])){
    require_once('connect.php');
    // On nettoie l'id envoyé
    $NumAgence = strip_tags($_GET['NumAgence']);

    $sql = 'SELECT * FROM `service` WHERE `NumAgence` = :NumAgence;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':NumAgence', $NumAgence, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le service
    $CodeService = $query->fetch();

    // On vérifie si le service existe
    if(!$CodeService){
        $_SESSION['erreur'] = "Ce service n'existe pas";
    }
}
    else{
        $_SESSION['erreur'] = "URL invalide";
        header('Location: index.php');

}




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modifier un service</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="contener"></main>
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <h1>modifier un service</h1>
                <form method="post">
                <div class="form-group">
                        <label for="NumAgence">NumAgence</label>
                        <input type="number" id="NumAgence" name="NumAgence" class="form-control" value="<?= $CodeService['NumAgence']?>">
                    </div>
                    <div class="form-group">
                        <label for="CodeService">CodeService</label>
                        <input type="number" id="CodeService" name="CodeService" class="form-control" value="<?= $CodeService['CodeService']?>">
                    </div>
                    <div class="form-group">
                        <label for="NumSalarie">NumSalarie</label>
                        <input type="number" id="NumSalarie" name="NumSalarie" class="form-control"value="<?= $CodeService['NumSalarie']?>">
                
                    </div>
                    <div class="form-group">
                        <label for="NomService">NomService</label>
                        <input type="text" id="NomService" name="NomService" class="form-control"value="<?= $CodeService['NomService']?>">
                    </div>
                    <input type="hidden" value="<?= $CodeService['NumAgence']?>" name="NumAgence">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>