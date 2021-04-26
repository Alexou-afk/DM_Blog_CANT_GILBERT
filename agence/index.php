<?php 
//On démarre une session
session_start();

// on inclut la connexion à la base
require_once('connect.php');

$sql = 'SELECT * FROM `service`';

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
                if(!empty($_SESSION['erreur'])){
                    echo '<div class="alert alert-danger" role="alert">
                            '. $_SESSION['erreur'].'
                        </div>';
                    $_SESSION['erreur'] = "";
                }
            ?>
            <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
            <h1>Liste des services</h1>
                <table class="table">
                    <thread>
                        <th>NumAgence</th>
                        <th>CodeService</th>
                        <th>NumSalarie</th>
                        <th>NomService</th>
                        <th>Actions</th>
                    </thread>
                    <tbody>
                        <?php
                        //On boucle sur la variable result
                        foreach($result as $CodeService){
                           ?>
                                <tr>
                                    <td><?= $CodeService['NumAgence'] ?></td>
                                    <td><?= $CodeService['CodeService'] ?></td>
                                    <td><?= $CodeService['NumSalarie'] ?></td>
                                    <td><?= $CodeService['NomService'] ?></td>
                                    <td><a href="disable.php?NumAgence=<?= $CodeService['NumAgence'] ?>">A/D</a> <a href="details.php?NumAgence=<?= $CodeService['NumAgence'] ?>">Voir</a> <a href="edit.php?NumAgence=<?= $CodeService['NumAgence'] ?>">Modifier</a> <a href="delete.php?NumAgence=<?= $CodeService['NumAgence'] ?>">Supprimer</a></td>
                                </tr>

                           <?php 
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter un service</a>
            </section>
        </div>
    </main>
    <br>
    <a href="indexsal.php" class="btn btn-primary">Voir les salariés</a>
</body>
</html>