<?php 
//On démarre une session
session_start();

// on inclut la connexion à la base
require_once('connect.php');

$sql = 'SELECT * FROM `salarie`';

//on prepare la requete 

$query = $db->prepare($sql);

//on execute

$query->execute();

// on stocke le résulat dans un tableau

$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>agence</title>

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
            <?php
                    if(!empty($_SESSION['message1'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message1'].'
                            </div>';
                        $_SESSION['message1'] = "";
                    }
                ?>
            <h1>Liste des salaries</h1>
                <table class="table">
                    <thread>
                        <th>NumSalarie</th>
                        <th>CodeService</th>
                        <th>NumAgence</th>
                        <th>NomSalarie</th>
                        <th>PrenomSalarie</th>
                    </thread>
                    <tbody>
                        <?php
                        //On boucle sur la variable result
                        foreach($result as $CodeService){
                           ?>
                                <tr>
                                    <td><?= $CodeService['NumSalarie'] ?></td>
                                    <td><?= $CodeService['CodeService'] ?></td>
                                    <td><?= $CodeService['NumAgence'] ?></td>
                                    <td><?= $CodeService['NomSalarie'] ?></td>
                                    <td><?= $CodeService['PrenomSalarie'] ?></td>
                                    <td><a href="disable.php?NumSalarie=<?= $CodeService['NumSalarie'] ?>">A/D</a> <a href="detailssal.php?NumSalarie=<?= $CodeService['NumSalarie'] ?>">Voir</a> <a href="editsal.php?NumSalarie=<?= $CodeService['NumSalarie'] ?>">Modifier</a> <a href="deletesal.php?NumSalarie=<?= $CodeService['NumSalarie'] ?>">Supprimer</a></td>
                                </tr>

                           <?php 
                        }
                        ?>
                    </tbody>
                </table>
                <a href="addsal.php" class="btn btn-primary">Ajouter un salarié</a>
            </section>
        </div>
    </main>
    <br>
    <a href="index.php" class="btn btn-primary">revenir aux services</a>
</body>
</html>