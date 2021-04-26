<?php 
//On démarre une session
session_start();
if($_POST){
    if(isset($_POST['NumSalarie']) && !empty($_POST['NumSalarie'])
    && isset($_POST['CodeService']) && !empty($_POST['CodeService'])
    && isset($_POST['NumAgence']) && !empty($_POST['NumAgence'])
    && isset($_POST['NomSalarie']) && !empty($_POST['NomSalarie'])
    && isset($_POST['PrenomSalarie']) && !empty($_POST['PrenomSalarie'])
    && isset($_POST['AdrSalarie']) && !empty($_POST['AdrSalarie'])
    && isset($_POST['CpSalarie']) && !empty($_POST['CpSalarie'])
    && isset($_POST['VilleSalarie']) && !empty($_POST['VilleSalarie'])
    && isset($_POST['TelSalarie']) && !empty($_POST['TelSalarie'])
    && isset($_POST['MailSalarie']) && !empty($_POST['MailSalarie']))
    {
        // on inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $NumSalarie = strip_tags($_POST['NumSalarie']);
        $CodeService = strip_tags($_POST['CodeService']);
        $NumAgence = strip_tags($_POST['NumAgence']);
        $NomSalarie = strip_tags($_POST['NomSalarie']);
        $PrenomSalarie = strip_tags($_POST['PrenomSalarie']);
        $AdrSalarie = strip_tags($_POST['AdrSalarie']);
        $CpSalarie = strip_tags($_POST['CpSalarie']);
        $VilleSalarie = strip_tags($_POST['VilleSalarie']);
        $TelSalarie = strip_tags($_POST['TelSalarie']);
        $MailSalarie = strip_tags($_POST['MailSalarie']);


        $sql = 'UPDATE `salarie` SET (`CodeService`=:CodeService, `NumAgence`=:NumAgence, `NomSalarie`=:NomSalarie, `PrenomSalarie`=:PrenomSalarie, `AdrSalarie`=:AdrSalarie, `CpSalarie`=:CpSalarie, `VilleSalarie`=:VilleSalarie, `TelSalarie`=:TelSalarie, `MailSalarie`=:MailSalarie) WHERE `NumAgence` = :NumAgence;';

        $query = $db->prepare($sql);

        $query->bindValue(':NumSalarie', $NumSalarie, PDO::PARAM_INT);
        $query->bindValue(':CodeService', $CodeService, PDO::PARAM_INT);
        $query->bindValue(':NumAgence', $NumAgence, PDO::PARAM_INT);
        $query->bindValue(':NomSalarie', $NomSalarie, PDO::PARAM_STR);
        $query->bindValue(':PrenomSalarie', $PrenomSalarie, PDO::PARAM_STR);
        $query->bindValue(':AdrSalarie', $AdrSalarie, PDO::PARAM_STR);
        $query->bindValue(':CpSalarie', $CpSalarie, PDO::PARAM_STR);
        $query->bindValue(':VilleSalarie', $VilleSalarie, PDO::PARAM_STR);
        $query->bindValue(':TelSalarie', $TelSalarie, PDO::PARAM_STR);
        $query->bindValue(':MailSalarie', $MailSalarie, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message1'] = "CodeService modifié";
        require_once('close.php');

        header('Location: indexsal.php');

    }else{
        $_SESSION['erreur1'] = "Le formulaire est incomplet";
    }
}
// Est-ce que le numagence existe et n'est pas vide dans l'URL
if(isset($_GET['NumSalarie']) && !empty($_GET['NumSalarie'])){
    require_once('connect.php');
    // On nettoie l'id envoyé
    $NumSalarie = strip_tags($_GET['NumSalarie']);

    $sql = 'SELECT * FROM `salarie` WHERE `NumSalarie` = :NumSalarie;';

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
        $_SESSION['erreur1'] = "Ce salarie n'existe pas";
    }
}
    else{
        $_SESSION['erreur1'] = "URL invalide";
        header('Location: indexsal.php');

}




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modifier un salarie</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="contener"></main>
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur1'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur1'].'
                            </div>';
                        $_SESSION['erreur1'] = "";
                    }
                ?>
                <h1>modifier un salarie</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="CodeService">CodeService</label>
                        <input type="number" id="CodeService" name="CodeService" class="form-control" value="<?= $CodeService['CodeService']?>">
                    </div>
                    <div class="form-group">
                        <label for="NumAgence">NumAgence</label>
                        <input type="number" id="NumAgence" name="NumAgence" class="form-control"value="<?= $CodeService['NumAgence']?>">
                
                    </div>
                    <div class="form-group">
                        <label for="NomSalarie">NomSalarie</label>
                        <input type="text" id="NomSalarie" name="NomSalarie" class="form-control"value="<?= $CodeService['NomSalarie']?>">
                    </div>
                    <div class="form-group">
                        <label for="PrenomSalarie">PrenomSalarie</label>
                        <input type="text" id="PrenomSalarie" name="PrenomSalarie" class="form-control"value="<?= $CodeService['PrenomSalarie']?>">
                    </div>
                    <div class="form-group">
                        <label for="AdrSalarie">AdrSalarie</label>
                        <input type="text" id="AdrSalarie" name="AdrSalarie" class="form-control"value="<?= $CodeService['AdrSalarie']?>">
                    </div>
                    <div class="form-group">
                        <label for="CpSalarie">CpSalarie</label>
                        <input type="text" id="CpSalarie" name="CpSalarie" class="form-control"value="<?= $CodeService['CpSalarie']?>">
                    </div>
                    <div class="form-group">
                        <label for="VilleSalarie">VilleSalarie</label>
                        <input type="text" id="VilleSalarie" name="VilleSalarie" class="form-control"value="<?= $CodeService['VilleSalarie']?>">
                    </div>
                    <div class="form-group">
                        <label for="TelSalarie">TelSalarie</label>
                        <input type="text" id="TelSalarie" name="TelSalarie" class="form-control"value="<?= $CodeService['TelSalarie']?>">
                    </div>
                    <div class="form-group">
                        <label for="MailSalarie">MailSalarie</label>
                        <input type="text" id="MailSalarie" name="MailSalarie" class="form-control"value="<?= $CodeService['MailSalarie']?>">
                    </div>
                    <input type="hidden" value="<?= $CodeService['NumSalarie']?>" name="NumSalarie">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>